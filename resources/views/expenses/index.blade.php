<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                History Expense
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('expenses.create') }}"
                   class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    + Expense Baru
                </a>

                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-2 border text-left">Tanggal</th>
                                <th class="p-2 border text-right">Nominal</th>
                                <th class="p-2 border text-left">Deskripsi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($expenses as $e)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-2 border">
                                        {{ optional($e->created_at)->format('d-m-Y H:i') }}
                                    </td>

                                    <td class="p-2 border text-right">
                                        Rp {{ number_format((float)($e->amount ?? 0), 0, ',', '.') }}
                                    </td>

                                    <td class="p-2 border">
                                        {{ $e->description ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500">
                                        Belum ada expense.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $expenses->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
