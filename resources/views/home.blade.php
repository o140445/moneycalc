@extends('layouts.app')

@section('content')
<div class="w-full max-w-4xl mx-auto mt-6">
<h2 class="text-2xl font-bold mb-4">Welcome to Money Calc Tools</h2>
<p class="text-gray-700 mb-4">
    Money Calc Tools is your one-stop solution for all financial calculations. Whether you need to calculate tips, mortgages, loans, or investments, our comprehensive suite of tools has got you covered. Our easy-to-use calculators are designed to help you make informed financial decisions with ease.
</p>
</div>

<div class="w-full max-w-4xl mx-auto mb-10">
    <form method="GET" action="{{ url('/') }}" class="w-full max-w-4xl mx-auto">
        <input type="text" name="query" placeholder="Search a tool..." value="{{ request('query') }}" class="w-full p-3 border rounded shadow-sm" />
    </form>
</div>

<div class="w-full max-w-4xl mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($tools as $tool)
        <a href="{{ $tool->url }}" target="_blank" class="block p-5 bg-white rounded-lg shadow hover:shadow-md transition">
            <div class="text-3xl mb-2">{{ $tool->icon }}</div>
            <h2 class="text-xl font-semibold">{{ $tool->name }}</h2>
            <p class="text-gray-600 mt-1">{{ $tool->description }}</p>
        </a>
    @empty
        <div class="col-span-full text-center p-5 bg-white rounded-lg shadow w-full">
            <p class="text-gray-600">No tools available.</p>
        </div>
    @endforelse
</div>



<div class="w-full max-w-4xl mx-auto mt-10">

    <h3 class="text-xl font-semibold mb-2">About Us</h3>
    <p class="text-gray-700">
        At Money Calc Tools, we are committed to providing accurate and reliable financial tools to help you manage your finances effectively. Our team of experts continuously updates our calculators to ensure they meet the latest industry standards and provide the most accurate results.
    </p>
</div>
@endsection
