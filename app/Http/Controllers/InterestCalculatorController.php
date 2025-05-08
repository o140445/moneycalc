<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


/**
 * * Class InterestCalculatorController
 * * @package App\Http\Controllers
 *
 * * Interest Calculator Controller
 * * * This controller handles interest calculations.
 */
class InterestCalculatorController extends Controller
{
    public function show()
    {
        $title = 'Interest Calculator - Money Calc Tools';
        $description = 'Calculate simple or compound interest for your investment or loan.';
        $keywords = 'interest calculator, simple interest, compound interest, financial calculator';
        return view('interest-calculator', compact('title', 'description', 'keywords'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'principal' => 'required|numeric|min:0', //  本金
            'rate' => 'required|numeric|min:0', // 利率
            'time' => 'required|numeric|min:0', //  时间
            'type' => 'required|in:simple,compound', // 计算类型
            'compound_frequency' => 'nullable|numeric|min:1' // 复利频率
        ]);

        $principal = $validated['principal'];
        $rate = $validated['rate'] / 100;
        $time = $validated['time'];

        if ($validated['type'] === 'simple') {
            $interest = $principal * $rate * $time;
            $total = $principal + $interest;
        } else {
            $n = $validated['compound_frequency'] ?? 1;
            $total = $principal * pow((1 + $rate / $n), $n * $time);
            $interest = $total - $principal;
        }

        return response()->json([
            'interest' => number_format($interest, 2),
            'total' => number_format($total, 2),
        ]);
    }
}
