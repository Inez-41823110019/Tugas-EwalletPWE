<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    <div class="mt-6 bg-white p-6 rounded shadow">
                        <h2 class="text-lg font-semibold mb-2">Saldo Wallet</h2>

                        <p class="text-3xl font-bold text-green-600">
                            Rp {{ number_format(auth()->user()->wallet->balance ?? 0, 2, ',', '.') }}
                        </p>

                        <div class="flex flex-wrap gap-2 mt-4">
                            <a href="{{ route('topups.create') }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Topup Saldo
                            </a>

                            <a href="{{ route('expenses.create') }}"
                               class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Tambah Expense
                            </a>

                            <a href="{{ route('topups.index') }}"
                               class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                                History Topup
                            </a>

                            <a href="{{ route('expenses.index') }}"
                               class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                                History Expense
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
