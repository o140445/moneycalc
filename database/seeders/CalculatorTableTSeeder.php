<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calculator; // 确保导入 Calculator 模型

class CalculatorTableTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $calculators = [
            [
                'name' => 'Tip Calculator',
                'description' => 'Quickly calculate tips and split bills.',
                'url' => '/tip-calculator',
                'icon' => '💵',
            ],
            [
                'name' => 'Mortgage Calculator',
                'description' => 'Calculate your monthly mortgage payments.',
                'url' => '/mortgage-calculator',
                'icon' => '🏠',
            ],
            [
                'name' => 'Loan Calculator',
                'description' => 'Estimate your loan payments.',
                'url' => '/loan-calculator',
                'icon' => '💳',
            ],
            [
                'name' => 'Auto Loan Calculator',
                'description' => 'Calculate your auto loan payments.',
                'url' => '/auto-loan-calculator',
                'icon' => '🚗',
            ],
            [
                'name' => 'Interest Calculator',
                'description' => 'Calculate simple and compound interest.',
                'url' => '/interest-calculator',
                'icon' => '📈',
            ],
            [
                'name' => 'Payment Calculator',
                'description' => 'Calculate payment amounts for various loans.',
                'url' => '/payment-calculator',
                'icon' => '💰',
            ],
            [
                'name' => 'Retirement Calculator',
                'description' => 'Plan your retirement savings.',
                'url' => '/retirement-calculator',
                'icon' => '👴🏻‍♂️',
            ],
            [
                'name' => 'Amortization Calculator',
                'description' => 'Calculate amortization schedules.',
                'url' => '/amortization-calculator',
                'icon' => '📉',
            ],
            [
                'name' => 'Investment Calculator',
                'description' => 'Estimate your investment growth over time.',
                'url' => '/investment-calculator',
                'icon' => '📊',
            ],
            [
                'name' => 'Inflation Calculator',
                'description' => 'Calculate the impact of inflation on your savings.',
                'url' => '/inflation-calculator',
                'icon' => '📉',
            ],
            [
                'name' => 'Finance Calculator',
                'description' => 'General finance calculations.',
                'url' => '/finance-calculator',
                'icon' => '💼',
            ],
            [
                'name' => 'Income Tax Calculator',
                'description' => 'Estimate your income tax.',
                'url' => '/income-tax-calculator',
                'icon' => '🧾',
            ],
            [
                'name' => 'Compound Interest Calculator',
                'description' => 'Calculate compound interest over time.',
                'url' => '/compound-interest-calculator',
                'icon' => '🔄',
            ],
            [
                'name' => 'Salary Calculator',
                'description' => 'Calculate your salary after taxes.',
                'url' => '/salary-calculator',
                'icon' => '💼',
            ],
            [
                'name' => 'Interest Rate Calculator',
                'description' => 'Determine interest rates for loans.',
                'url' => '/interest-rate-calculator',
                'icon' => '📊',
            ],
            [
                'name' => 'Sales Tax Calculator',
                'description' => 'Calculate sales tax for purchases.',
                'url' => '/sales-tax-calculator',
                'icon' => '🛒',
            ]
        ];

        foreach ($calculators as $calculator) {
            Calculator::create($calculator);
        }
    }
}