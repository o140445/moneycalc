<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

/**
 * AutoLoanController
 *
 * This controller handles the auto loan calculator functionality.
 *
 */
class AutoLoanController extends Controller
{
    public function show()
    {
        $title = 'Auto Loan Calculator - Money Calc Tools';
        $description = 'Calculate your auto loan payments with our easy-to-use auto loan calculator.';
        $keywords = 'auto loan calculator, car loan, auto finance, financial calculator';
        return view('auto-loan-calculator', compact('title', 'description', 'keywords'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'car_price' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0',
            'trade_in' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'other_fees' => 'nullable|numeric|min:0',
            'loan_term' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0',
        ]);

        $carPrice = $validated['car_price'];
        $downPayment = $validated['down_payment'];
        $tradeIn = $validated['trade_in'] ?? 0;
        $taxRate = $validated['tax_rate'] ?? 0;
        $otherFees = $validated['other_fees'] ?? 0;
        $loanTermYears = $validated['loan_term'];
        $interestRate = $validated['interest_rate'] / 100;

        $taxAmount = $carPrice * ($taxRate / 100);
        $upfrontPayment = $downPayment + $tradeIn;

        $loanAmount = $carPrice - $upfrontPayment + $taxAmount + $otherFees;

        $monthlyRate = $interestRate / 12;
        $totalMonths = $loanTermYears * 12;

        // 等额本息月供
        $monthlyPayment = $loanAmount * $monthlyRate / (1 - pow(1 + $monthlyRate, -$totalMonths));
        $totalLoanPayments = $monthlyPayment * $totalMonths;
        $totalInterest = $totalLoanPayments - $loanAmount;

        $totalCost = $totalLoanPayments + $upfrontPayment;

        return response()->json([
            'total_loan_amount' => round($loanAmount, 2),
            'sale_tax' => round($taxAmount, 2),
            'upfront_payment' => round($upfrontPayment + $otherFees, 2),
            'monthly_payment' => round($monthlyPayment, 2),
            'total_loan_payments' => round($totalLoanPayments, 2),
            'total_loan_interest' => round($totalInterest, 2),
            'total_cost' => round($totalCost + $taxAmount + $otherFees, 2),
        ]);
    }
}
