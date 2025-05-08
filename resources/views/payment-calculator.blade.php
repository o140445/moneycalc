@extends('layouts.app')

@section('content')
<div class="w-full mx-auto mt-4 p-4 gap-4">
    <h1 class="text-2xl font-bold mb-6 ">Payment Calculator</h1>



    <div class="flex flex-col md:flex-row gap-8 justify-center">
        <div class="bg-white rounded-lg shadow-lg p-8 md:w-1/3">
            <form id="paymentCalculatorForm">
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
                    <label class="block font-semibold text-gray-700">Number of Payments (months)</label>
                    <input type="number" name="periods" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition duration-300">Calculate</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-lg md:w-2/3">
            <div id="result" class="mb-6  p-6 rounded-lg ">
                <h2 class="text-2xl font-bold mb-4 text-blue-600">Result</h2>
                <p class="text-lg"><strong>Periodic Payment:</strong> $<span id="resultPayment"></span></p>
                <p class="text-lg"><strong>Total Payment:</strong> $<span id="resultTotalPayment"></span></p>
                <p class="text-lg"><strong>Total Interest:</strong> $<span id="resultTotalInterest"></span></p>
            </div>
        </div>
    </div>

    <div class="py-4 px-2 r">
        <p class="mb-6  text-gray-700">
            Calculate your fixed periodic payment for a loan or installment plan. Enter the principal, annual interest rate, and number of payments to see your payment schedule.
        </p>
        <p class="text-gray-700">
            This calculator uses the standard amortization formula for fixed-rate loans:<br>
            <code>Payment = P × r × (1 + r)<sup>n</sup> / ((1 + r)<sup>n</sup> - 1)</code><br>
            where P = principal, r = monthly interest rate, n = number of payments.
        </p>
    </div>

    @include('components.recommended-calculators')
</div>

<script>
    document.getElementById('paymentCalculatorForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        const response = await fetch('{{ route("payment.calculate") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        document.getElementById('resultPayment').textContent = result.payment;
        document.getElementById('resultTotalPayment').textContent = result.total_payment;
        document.getElementById('resultTotalInterest').textContent = result.total_interest;
        document.getElementById('result').classList.remove('hidden');
    });
</script>
@endsection