<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipCalculatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MortgageController;
use App\Http\Controllers\LoanCalculatorController;
use App\Http\Controllers\AutoLoanController;
use App\Http\Controllers\InterestCalculatorController;
use App\Http\Controllers\PaymentCalculatorController;
// Route::get('/', function () {
//     return view('index');
// });
Route::get('/api/recommended-calculators', [HomeController::class, 'getRecommendedCalculators']);
Route::get('/', [HomeController::class, 'index']);
Route::get('/tip-calculator', [TipCalculatorController::class, 'show']);
Route::post('/tip-calculator', [TipCalculatorController::class, 'calculate']);


// 房贷计算器
Route::get('/mortgage-calculator', [MortgageController::class, 'show']);
Route::post('/mortgage-calculator/calculate', [MortgageController::class, 'calculate']);

// 贷款计算器
Route::get('/loan-calculator', [LoanCalculatorController::class, 'show']);
Route::post('/loan-calculator/calculate', [LoanCalculatorController::class, 'calculate'])->name('loan.calculate');

// 汽车贷款计算器
Route::get('/auto-loan-calculator', [AutoLoanController::class, 'show']);
Route::post('/auto-loan-calculator/calculate', [AutoLoanController::class, 'calculate'])->name('auto.loan.calculate');

// 利息计算器
Route::get('/interest-calculator', [InterestCalculatorController::class, 'show'])->name('interest.calculator');
Route::post('/interest-calculator/calculate', [InterestCalculatorController::class, 'calculate'])->name('interest.calculate');


Route::get('/payment-calculator', [PaymentCalculatorController::class, 'show'])->name('payment.calculator');
Route::post('/payment-calculator/calculate', [PaymentCalculatorController::class, 'calculate'])->name('payment.calculate');
