@extends('layouts.app')

@section('content')
<div class="w-full mx-auto mt-4 p-4 gap-4">
    <h1 class="text-2xl font-bold mb-6 ">Interest Calculator</h1>

    <div class="flex flex-col md:flex-row gap-8 justify-center">
        <div class="bg-white rounded-lg shadow-lg p-8 md:w-1/3">
            <form id="interestCalculatorForm">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Principal ($)</label>
                    <input type="number" name="principal" step="0.01" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Annual Interest Rate (%)</label>
                    <input type="number" name="rate" step="0.01" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Time (years)</label>
                    <input type="number" name="time" step="0.01" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-gray-700">Interest Type</label>
                    <select name="type" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="simple">Simple Interest</option>
                        <option value="compound">Compound Interest</option>
                    </select>
                </div>

                <div class="mb-4" id="compoundFrequencyDiv" style="display:none;">
                    <label class="block font-semibold text-gray-700">Compound Frequency (per year)</label>
                    <input type="number" name="compound_frequency" min="1" value="1" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <small class="text-gray-500">E.g. 1=yearly, 4=quarterly, 12=monthly</small>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition duration-300">Calculate</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-lg md:w-2/3">
            <div id="result" class="mb-6  p-6 rounded-lg ">
                <h2 class="text-2xl font-bold mb-4 text-blue-600">Result</h2>
                <p class="text-lg"><strong>Total Interest:</strong> $<span id="resultInterest"></span></p>
                <p class="text-lg"><strong>Total Amount:</strong> $<span id="resultTotal"></span></p>
            </div>
        </div>
    </div>

    <div class="py-4 px-2 ">
        <p class="mb-6  text-gray-700">
            Calculate simple or compound interest for your investment or loan. Enter the principal, interest rate, time period, and select the interest type to see the result.
        </p>
        <p class="text-gray-700">
            <strong>Simple Interest:</strong> Interest is calculated only on the original principal.<br>
            <strong>Compound Interest:</strong> Interest is calculated on the principal plus accumulated interest.
        </p>
    </div>

    @include('components.recommended-calculators')
</div>

<script>
    // Show/hide compound frequency input
    document.querySelector('select[name="type"]').addEventListener('change', function() {
        document.getElementById('compoundFrequencyDiv').style.display = this.value === 'compound' ? 'block' : 'none';
    });

    document.getElementById('interestCalculatorForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        const response = await fetch('{{ route("interest.calculate") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        document.getElementById('resultInterest').textContent = result.interest;
        document.getElementById('resultTotal').textContent = result.total;
        document.getElementById('result').classList.remove('hidden');
    });
</script>
@endsection