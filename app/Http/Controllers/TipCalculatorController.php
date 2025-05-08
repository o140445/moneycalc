<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipCalculatorController extends Controller
{
    public function show()
    {
        $title = 'Tip Calculator - Money Calc Tools';
        $description = 'Calculate tips and split bills with our easy-to-use tip calculator.';
        $keywords = 'tip calculator, tips, split bills, financial calculator';
        return view('tip-calculator', compact('title', 'description', 'keywords'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'tip_rate' => 'required|numeric|min:0',
            'people' => 'required|integer|min:1',
        ]);

        $amount = $validated['amount'];
        $tipRate = $validated['tip_rate'];
        $people = $validated['people'];

        $tip = $amount * ($tipRate / 100);
        $total = $amount + $tip;
        $perPerson = $total / $people;

        return response()->json([
            'tip' => number_format($tip, 2),
            'total' => number_format($total, 2),
            'per_person' => number_format($perPerson, 2),
        ]);
    }
}