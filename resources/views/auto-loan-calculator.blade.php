@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto mt-4 p-4 gap-4">
        <h1 class="text-2xl font-bold mb-6">Car Loan Calculator</h1>

        <div class="flex flex-col md:flex-row gap-4">
            <div class="bg-white rounded shadow p-8 md:w-1/3">
                <form id="carLoanForm">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold">Car Price ($)</label>
                        <input type="number" name="car_price" step="0.01" required class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Down Payment ($)</label>
                        <input type="number" name="down_payment" step="0.01" required class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Loan Term (years)</label>
                        <input type="number" name="loan_term" required class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Interest Rate (% per year)</label>
                        <input type="number" name="interest_rate" step="0.01" required class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Trade-In Value ($)</label>
                        <input type="number" name="trade_in" step="0.01" class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Sales Tax Rate (%)</label>
                        <input type="number" name="tax_rate" step="0.01" class="w-full p-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Other Fees ($)</label>
                        <input type="number" name="other_fees" step="0.01" class="w-full p-2 border rounded">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Calculate</button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-lg md:w-2/3">
                <div id="carLoanResult" class="mb-6 p-6 rounded-lg ">
                    <h2 class="text-2xl font-bold mb-4 text-blue-600">Result</h2>
                    <p class="text-lg"><strong>Loan Amount:</strong> $<span id="resultLoanAmount"></span></p>
                    <p class="text-lg"><strong>Sales Tax:</strong> $<span id="resultSaleTax"></span></p>
                    <p class="text-lg"><strong>Upfront Payment:</strong> $<span id="resultUpfrontPayment"></span></p>
                    <p class="text-lg"><strong>Monthly Payment:</strong> $<span id="resultMonthlyPayment"></span></p>
                    <p class="text-lg"><strong>Total Payment:</strong> $<span id="resultTotalLoanPayments"></span></p>
                    <p class="text-lg"><strong>Total Interest:</strong> $<span id="resultTotalInterest"></span></p>

                </div>
            </div>
        </div>

        <div class="py-4  px-2">
            <p>
            The Car Loan Calculator helps you estimate your monthly payments, total interest, and total cost for purchasing a vehicle.
        Enter the car price, down payment, loan term, interest rate, trade-in value, sales tax rate, and other fees to get a detailed breakdown of your loan.

            </p>
        </div>

        @include('components.recommended-calculators')
    </div>

    <script>
        document.getElementById('carLoanForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const response = await fetch('{{ route("auto.loan.calculate") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            });
            const data = await response.json();
            // document.getElementById('resultLoanType').textContent = result.loan_type;
            // document.getElementById('resultTotalPayment').textContent = result.total_payment;
            // document.getElementById('resultMonthlyPayment').textContent = result.monthly_payment;
            // document.getElementById('resultInterest').textContent = result.total_interest;
            // document.getElementById('result').classList.remove('hidden');
            document.getElementById('carLoanResult').classList.remove('hidden');
            document.getElementById('resultLoanAmount').textContent = data.total_loan_amount;
            document.getElementById('resultSaleTax').textContent = data.sale_tax;
            document.getElementById('resultUpfrontPayment').textContent = data.upfront_payment;
            document.getElementById('resultMonthlyPayment').textContent = data.monthly_payment;
            document.getElementById('resultTotalLoanPayments').textContent = data.total_loan_payments;
            document.getElementById('resultTotalInterest').textContent = data.total_loan_interest;
            document.getElementById('resultTotalCost').textContent = data.total_cost;
        });
    </script>
@endsection
