@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto mt-4 p-4 gap-4">
        <h1 class="text-2xl font-bold mb-6">Loan Calculator</h1>

        <div class="flex flex-col md:flex-row gap-4">
            <div class="bg-white rounded shadow p-8 md:w-1/3">
                <form id="loanCalculatorForm">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold">Loan Type</label>
                        <select name="loan_type" required class="w-full p-2 border rounded">
                            <option value="amortized">Amortized Loan</option>
                            <option value="deferred">Deferred Payment Loan</option>
                            <option value="bond">Bond (Lump Sum)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Loan Amount ($)</label>
                        <input type="number" name="loan_amount" step="0.01" required class="w-full p-2 border rounded">
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
                        <label class="block font-semibold">Compound</label>
                        <select name="compound" required class="w-full p-2 border rounded">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="semiannually">Semiannually</option>
                            <option value="yearly">Yearly</option>
                            <option value="continuous">Continuous</option>

                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Calculate</button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-lg md:w-2/3">
                <div id="result" class="mb-6  p-6 rounded-lg ">
                    <h2 class="text-2xl font-bold mb-4 text-blue-600">Result</h2>
                    <p class="text-lg"><strong>Loan Type:</strong> <span id="resultLoanType"></span></p>
                    <p class="text-lg"><strong>Monthly Payment:</strong> $<span id="resultMonthlyPayment"></span></p>
                    <p class="text-lg"><strong>Total Payment:</strong> $<span id="resultTotalPayment"></span></p>
                    <p class="text-lg"><strong>Total Interest:</strong> $<span id="resultInterest"></span></p>
                </div>
            </div>
        </div>

        <div class="py-4  px-2">
            <p>
            This loan calculator helps you estimate your monthly payments and total interest for various types of loans. Choose from Amortized Loans, Deferred Payment Loans, Bonds, Compound Loans, and Pay Back Loans to see how different loan structures affect your financial obligations.
            </p>
        </div>

        @include('components.recommended-calculators')
    </div>

    <script>
        document.getElementById('loanCalculatorForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('{{ route("loan.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                document.getElementById('resultLoanType').textContent = result.loan_type;
                document.getElementById('resultTotalPayment').textContent = result.total_payment;
                document.getElementById('resultMonthlyPayment').textContent = result.monthly_payment;
                document.getElementById('resultInterest').textContent = result.total_interest;
                document.getElementById('result').classList.remove('hidden');

            } catch (err) {
                alert("Calculation failed.");
                console.error(err);
            }
        });


    </script>
@endsection
