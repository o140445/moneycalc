<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

/**
 * LoanCalculatorController
 * 贷款计算器控制器
 *
 * This controller handles the loan calculator functionality.
 * It provides methods to show the calculator form and to calculate loan payments.
 */
class LoanCalculatorController extends Controller
{
    public function show()
    {
        $title = 'Loan Calculator - Money Calc Tools';
        $description = 'Calculate your loan payments and interest with our easy-to-use loan calculator.';
        $keywords = 'loan calculator, loan payments, interest calculator, financial calculator';
        return view('loan-calculator', compact('title', 'description', 'keywords'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'loan_type' => 'required|string|in:amortized,deferred,bond',
            'loan_amount' => 'required|numeric|min:0',
            'loan_term' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'compound' => 'required|string|in:daily,weekly,monthly,quarterly,semiannually,yearly,continuous',
        ]);

        $type = $validated['loan_type'];
        $amount = (float) $validated['loan_amount'];
        $years = (int) $validated['loan_term'];
        $rate = (float) $validated['interest_rate'] / 100;
        $compound = $validated['compound'];

        $compoundFreq = match ($compound) {
            'daily' => 365,
            'weekly' => 52,
            'monthly' => 12,
            'quarterly' => 4,
            'semiannually' => 2,
            'yearly' => 1,
            'continuous' => 1,
        };

        $totalPeriods = $compound === 'continuous' ? 0 : $compoundFreq * $years;

        $monthlyPayment = 0;
        $totalPayment = 0;

        if ($type === 'amortized') {
            if ($compound === 'continuous') {
                $totalPayment = $amount * exp($rate * $years);
                $monthlyPayment = $totalPayment / ($years * 12); // 粗略分成月还
            } else {
                $r = $rate / $compoundFreq;
                $monthlyPayment = ($amount * $r) / (1 - pow(1 + $r, -$totalPeriods));
                $totalPayment = $monthlyPayment * $totalPeriods;
            }
        } else {
            // deferred 或 bond：都是到期一次性还款
            if ($compound === 'continuous') {
                $totalPayment = $amount * exp($rate * $years);
            } else {
                $totalPayment = $amount * pow(1 + $rate / $compoundFreq, $compoundFreq * $years);
            }
        }

        $totalInterest = $totalPayment - $amount;

        return response()->json([
            'loan_type' => ucfirst($type),
            'total_payment' => round($totalPayment, 2),
            'monthly_payment' => round($monthlyPayment, 2),
            'total_interest' => round($totalInterest, 2),
        ]);
    }
}
