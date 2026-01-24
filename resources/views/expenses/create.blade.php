<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Tambah Expense</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('expenses.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Nominal</label>
                <input type="number" name="amount" min="1" required
                       value="{{ old('amount') }}"
                       class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <input type="text" name="description"
                       value="{{ old('description') }}"
                       class="w-full border rounded p-2">
            </div>

            <div class="flex gap-2 justify-end">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 border rounded">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                    Submit
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
