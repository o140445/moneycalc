<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class MortgageController
 * @package App\Http\Controllers
 *
 * 房贷计算器控制器
 * This controller handles mortgage calculations.
 */
class MortgageController extends Controller
{
    /**
     * 显示房贷计算器页面
     * Show the mortgage calculator page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $title = 'Mortgage Calculator - Money Calc Tools';
        $description = 'Calculate your monthly mortgage payments with our easy-to-use mortgage calculator.';
        $keywords = 'mortgage calculator, home loan, mortgage payment, financial calculator';
        return view('mortgage-calculator', compact('title', 'description', 'keywords'));
    }

    /**
     * 计算房贷
     * Calculate the mortgage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'home_price' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0',
            'loan_term' => 'required|integer|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'property_taxes' => 'nullable|numeric|min:0',
            'home_insurance' => 'nullable|numeric|min:0',
            'pmi' => 'nullable|numeric|min:0',
            'hoa_fees' => 'nullable|numeric|min:0',
        ]);

        $homePrice = $validated['home_price'];
        $downPayment = $validated['down_payment'] / 100;
        $loanTerm = $validated['loan_term'];
        $interestRate = $validated['interest_rate'] / 100 / 12;
        $loanAmount = $homePrice * (1 - $downPayment);

        $monthlyPrincipalInterest = ($loanAmount * $interestRate) / (1 - pow(1 + $interestRate, -$loanTerm * 12));

        $monthlyPropertyTaxes = ($validated['property_taxes'] ?? 0) / 100 * $homePrice / 12; // 房产税
        $monthlyHomeInsurance = ($validated['home_insurance'] ?? 0) / 12; // 房屋保险
        $monthlyPMI = ($validated['pmi'] ?? 0) / 100 * $loanAmount / 12; //
        $monthlyHOAFees = $validated['hoa_fees'] ?? 0;

        $monthlyPayment = $monthlyPrincipalInterest + $monthlyPropertyTaxes + $monthlyHomeInsurance + $monthlyPMI + $monthlyHOAFees;
        return response()->json([
            'monthly_payment' => number_format($monthlyPayment, 2), // 月供
            'principal_interest' => number_format($monthlyPrincipalInterest, 2), // 本金和利息
            'property_taxes' => number_format($monthlyPropertyTaxes, 2), // 房产税
            'home_insurance' => number_format($monthlyHomeInsurance, 2), // 房屋保险
            'pmi_cost' => number_format($monthlyPMI, 2), //  // 贷款保险
            'hoa_fees' => number_format($monthlyHOAFees, 2), // 物业管理费
            'total_cost' => number_format($monthlyPayment * 12 * $loanTerm, 2), // 年总支出
            'total_interest' => number_format(($monthlyPayment * 12 * $loanTerm) - $loanAmount, 2), // 总利息
        ]);
    }
}
