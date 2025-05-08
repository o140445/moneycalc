@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Tip Calculator</h1>

    <form method="POST" action="{{ url('/tip-calculator') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Bill Amount ($)</label>
            <input type="number" name="amount" value="{{ old('amount', $input['amount'] ?? '') }}" step="0.01" required class="w-full p-2 border rounded">
            @error('amount') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Tip Rate (%)</label>
            <input type="number" name="tip_rate" value="{{ old('tip_rate', $input['tip_rate'] ?? 15) }}" step="0.1" required class="w-full p-2 border rounded">
            @error('tip_rate') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-semibold">People</label>
            <input type="number" name="people" value="{{ old('people', $input['people'] ?? 1) }}" min="1" class="w-full p-2 border rounded">
            @error('people') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Calculate</button>
    </form>

    @if(session()->has('tip'))
        <div class="mt-6 bg-green-100 p-4 rounded">
            <p><strong>Tip:</strong> ${{ session('tip') }}</p>
            <p><strong>Total with Tip:</strong> ${{ session('total') }}</p>
            <p><strong>Per Person:</strong> ${{ session('per_person') }}</p>
        </div>
    @endif
</div>
@endsection