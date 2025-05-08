<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Calculator;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $tools = Calculator::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        })
            ->where('status', 1)
            ->get();
        return view('home', compact('tools'));
    }

    //getRecommendedCalculators
    public function getRecommendedCalculators()
    {
        // 随机获取4个计算器
        $calculators = Calculator::where('status', 1)
            ->inRandomOrder()
            ->take(4)
            ->get(['name', 'description', 'url', 'icon']);

        return response()->json($calculators);
    }
}
