<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Wallet;
use App\Models\Topup;

class TopupController extends Controller
{
   public function index()
{
    // pastikan wallet selalu ada
    $wallet = Wallet::firstOrCreate(
        ['user_id' => auth()->id()],
        ['balance' => 0]
    );

    $topups = Topup::where('wallet_id', $wallet->id)
        ->latest()
        ->paginate(10);

    return view('topups.index', compact('topups'));
}


    public function create()
    {
        return view('topups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required','numeric','min:1000','max:10000000'],
            'payment_method' => ['required','string'],
            'notes' => ['nullable','string','max:500'],
        ]);

        DB::transaction(function () use ($validated, $request) {

    $wallet = Wallet::where('user_id', auth()->id())
    ->lockForUpdate()
    ->first();

if (!$wallet) {
    $wallet = Wallet::create([
        'user_id' => auth()->id(),
        'balance' => 0,
    ]);
}



if (!$wallet) {
    $wallet = Wallet::create([
        'user_id' => auth()->id(),
        'balance' => 0,
    ]);
}

            $reference = 'TOP-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 10));

            Topup::create([
                'wallet_id'      => $wallet->id,
                'reference'      => $reference,
                'amount'         => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'notes'          => $validated['notes'] ?? null,
                'status'         => 'SUCCESS',
                'user_ip'        => $request->ip(),
            ]);

            $wallet->balance = bcadd((string)$wallet->balance, (string)$validated['amount'], 2);
            $wallet->save();
        });

        return redirect()->route('dashboard')->with('success', 'Topup berhasil, saldo bertambah.');
    }
}
