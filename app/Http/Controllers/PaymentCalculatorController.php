<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentCalculatorController extends Controller
{
    public function show()
    {
        $title = 'Payment Calculator - Money Calc Tools';
        $description = 'Calculate your fixed periodic payment for a loan or installment plan.';
        $keywords = 'payment calculator, loan payment, installment, financial calculator';
        return view('payment-calculator', compact('title', 'description', 'keywords'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'principal' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0',
            'periods' => 'required|integer|min:1',
        ]);

        $P = $validated['principal'];
        $annualRate = $validated['rate'] / 100;
        $n = $validated['periods'];
        $r = $annualRate / 12;

        if ($r == 0) {
            $payment = $P / $n;
        } else {
            $payment = $P * $r * pow(1 + $r, $n) / (pow(1 + $r, $n) - 1);
        }
        $totalPayment = $payment * $n;
        $totalInterest = $totalPayment - $P;

        return response()->json([
            'payment' => number_format($payment, 2),
            'total_payment' => number_format($totalPayment, 2),
            'total_interest' => number_format($totalInterest, 2),
        ]);
    }
}