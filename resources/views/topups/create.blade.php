<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">

        {{-- Judul --}}
        <h1 class="text-xl font-bold mb-6">Topup Saldo</h1>

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('topups.store') }}">
            @csrf

            {{-- Quick Amount --}}
            <div class="mb-4">
                <label class="block mb-2 font-medium">Quick Nominal</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ([20000, 50000, 100000, 200000, 500000] as $qa)
                        <button type="button"
                                onclick="document.getElementById('amount').value='{{ $qa }}'"
                                class="px-3 py-1 border rounded hover:bg-gray-100">
                            Rp {{ number_format($qa, 0, ',', '.') }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Nominal --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Nominal</label>
                <input id="amount"
                       type="number"
                       name="amount"
                       min="1000"
                       required
                       value="{{ old('amount') }}"
                       class="w-full border rounded p-2 focus:outline-none focus:ring">
            </div>

            {{-- Metode Pembayaran --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Metode Pembayaran</label>
                <select name="payment_method"
                        required
                        class="w-full border rounded p-2 focus:outline-none focus:ring">
                    <option value="">-- pilih --</option>
                    <option value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'selected' : '' }}>
                        Transfer Bank
                    </option>
                    <option value="QRIS" {{ old('payment_method') == 'QRIS' ? 'selected' : '' }}>
                        QRIS
                    </option>
                    <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>
                        E-Wallet
                    </option>
                </select>
            </div>

            {{-- Catatan --}}
            <div class="mb-6">
                <label class="block mb-1 font-medium">Catatan (opsional)</label>
                <textarea name="notes"
                          rows="3"
                          class="w-full border rounded p-2 focus:outline-none focus:ring">{{ old('notes') }}</textarea>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3">
                {{-- Cancel --}}
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-100">
                    Cancel
                </a>

                {{-- Submit --}}
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Submit
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
