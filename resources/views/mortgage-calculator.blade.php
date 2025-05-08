@extends('layouts.app')

@section('content')
<div class="w-full mx-auto mt-4 p-4 gap-4">

    <h1 class="text-2xl font-bold mb-6">Mortgage Calculator</h1>

    <div class="flex flex-col md:flex-row gap-4">

        <div class="bg-white rounded shadow p-8 md:w-1/3">
            <form id="mortgageCalculatorForm">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold">Home Price ($)</label>
                    <input type="number" name="home_price" step="0.01" required class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Down Payment (%)</label>
                    <input type="number" name="down_payment" step="0.1" required class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Loan Term (years)</label>
                    <input type="number" name="loan_term" required class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Interest Rate (%)</label>
                    <input type="number" name="interest_rate" step="0.01" required class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Property Taxes (% of home price)</label>
                    <input type="number" name="property_taxes" step="0.01" class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Home Insurance ($ per year)</label>
                    <input type="number" name="home_insurance" step="0.01" class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">PMI (% of loan amount)</label>
                    <input type="number" name="pmi" step="0.01" class="w-full p-2 border rounded">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">HOA Fees ($ per month)</label>
                    <input type="number" name="hoa_fees" step="0.01" class="w-full p-2 border rounded">
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Calculate</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-2 md:w-2/3">
            <div id="result" class="mb-6 p-6 rounded-lg ">
                <h2 class="text-2xl font-bold mb-4 text-blue-600">Payment Breakdown</h2>
                <p class="text-lg"><strong>Monthly Payment:</strong> $<span id="monthlyPayment"></span></p>
                <p class="text-lg"><strong>Principal & Interest:</strong> $<span id="principalInterest"></span></p>
                <p class="text-lg"><strong>Property Taxes:</strong> $<span id="propertyTaxes"></span></p>
                <p class="text-lg"><strong>Home Insurance:</strong> $<span id="homeInsurance"></span></p>
                <p class="text-lg"><strong>PMI:</strong> $<span id="pmiCost"></span></p>
                <p class="text-lg"><strong>HOA Fees:</strong> $<span id="hoaFees"></span></p>
                <p class="mt-4 text-lg"><strong>Total Cost Over Loan Term:</strong> $<span id="totalCost"></span></p>
                <p class="text-lg"><strong>Total Interest Paid:</strong> $<span id="totalInterest"></span></p>
            </div>
        </div>

    </div>

    <div class="py-4  px-2">
        <p>
            Use this mortgage calculator to estimate your monthly mortgage payments. Enter the details of your home loan to calculate your monthly payment and see a breakdown of your costs. This tool helps you understand the financial commitment of a mortgage and plan your budget accordingly.
        </p>
    </div>

    @include('components.recommended-calculators')

</div>

<script>
document.getElementById('mortgageCalculatorForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('{{ url('/mortgage-calculator/calculate') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.errors) {
            // Handle validation errors
        } else {
            document.getElementById('monthlyPayment').textContent = data.monthly_payment;
            document.getElementById('principalInterest').textContent = data.principal_interest;
            document.getElementById('propertyTaxes').textContent = data.property_taxes;
            document.getElementById('homeInsurance').textContent = data.home_insurance;
            document.getElementById('pmiCost').textContent = data.pmi_cost;
            document.getElementById('hoaFees').textContent = data.hoa_fees;
            document.getElementById('totalCost').textContent = data.total_cost;
            document.getElementById('totalInterest').textContent = data.total_interest;
            document.getElementById('result').classList.remove('hidden');
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
@endsection
