<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseGroup;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class ExpenseController extends Controller
{
    public function index()
    {
        $wallet = Wallet::where('user_id', auth()->id())->first();

        // kalau belum punya wallet, history kosong (bukan error)
        $expenses = Expense::query()
            ->when($wallet, fn($q) => $q->where('wallet_id', $wallet->id), fn($q) => $q->whereRaw('1=0'))
            ->latest()
            ->paginate(10);

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount'          => ['required', 'numeric', 'min:1', 'max:10000000'],
            'description'     => ['nullable', 'string', 'max:255'],
            // kamu belum pakai field ini di form, tapi biar aman kalau nanti ditambah
            'expense_group_id'=> ['nullable', 'exists:expense_groups,id'],
        ]);

        DB::transaction(function () use ($validated) {

            // ambil wallet + lock
            $wallet = Wallet::where('user_id', auth()->id())
                ->lockForUpdate()
                ->first();

            // kalau wallet belum ada, buat (wajib user_id)
            if (!$wallet) {
                $wallet = Wallet::create([
                    'user_id'  => auth()->id(),
                    'balance'  => 0,
                ]);
            }

            $amount = (string) $validated['amount'];
            $walletBalance = (string) $wallet->balance;

            // cek saldo cukup
            if (bccomp($walletBalance, $amount, 2) < 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Saldo tidak cukup untuk melakukan expense ini.',
                ]);
            }

            /**
             * FIX UTAMA:
             * Kalau expense_group_id kosong, coba ambil group pertama.
             * Kalau ternyata tabel expense_groups masih kosong, auto-buat "General".
             */
            $groupId = $validated['expense_group_id'] ?? null;

            if (!$groupId) {
                $groupId = ExpenseGroup::query()->value('id');

                if (!$groupId) {
                    $data = [];

                    // minimal: name
                    if (Schema::hasColumn('expense_groups', 'name')) {
                        $data['name'] = 'General';
                    } else {
                        // kalau kolomnya bukan "name", fallback aman
                        $data['title'] = 'General';
                    }

                    // kalau tabel expense_groups punya user_id, isi juga
                    if (Schema::hasColumn('expense_groups', 'user_id')) {
                        $data['user_id'] = auth()->id();
                    }

                    $group = ExpenseGroup::create($data);
                    $groupId = $group->id;
                }
            }

            // simpan expense
            Expense::create([
                'wallet_id'        => $wallet->id,
                'expense_group_id' => $groupId, // tidak akan null lagi kalau DB butuh
                'amount'           => $amount,
                'description'      => $validated['description'] ?? null,
            ]);

            // potong saldo
            $wallet->balance = bcsub($walletBalance, $amount, 2);
            $wallet->save();
        });

        return redirect()->route('dashboard')->with('success', 'Expense berhasil, saldo berkurang.');
    }
}
