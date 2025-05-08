@extends('layouts.app')

@section('content')
<div class="w-full mx-automt-4 p-4 gap-4 ">

    <h1 class="text-2xl font-bold mb-6">Tip Calculator</h1>



    <div class="flex flex-col md:flex-row gap-4">

        <div class="bg-white rounded shadow p-8 md:w-1/3">
            <div id="result" class="mb-6 bg-green-100 p-4 rounded hidden">
                <p><strong>Tip:</strong> $<span id="tipAmount"></span></p>
                <p><strong>Total with Tip:</strong> $<span id="totalAmount"></span></p>
                <p><strong>Per Person:</strong> $<span id="perPersonAmount"></span></p>
            </div>

            <form id="tipCalculatorForm" >
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold">Bill Amount ($)</label>
                    <input type="number" name="amount" step="0.01" required class="w-full p-2 border rounded">
                    <p class="text-red-500 text-sm" id="amountError"></p>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Tip Rate (%)</label>
                    <input type="number" name="tip_rate" value="15" step="0.1" required class="w-full p-2 border rounded">
                    <p class="text-red-500 text-sm" id="tipRateError"></p>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">People</label>
                    <input type="number" name="people" value="1" min="1" class="w-full p-2 border rounded">
                    <p class="text-red-500 text-sm" id="peopleError"></p>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Calculate</button>
            </form>
        </div>

        <div class="bg-white rounded shadow p-8 md:w-2/3">
            <h2 class="text-xl font-bold mb-4">Tipping Guide by Industry</h2>
            <ul class="list-disc pl-5">
                <li><strong>Restaurants, Bartenders:</strong> 15%-20%</li>
                <li><strong>Food Delivery:</strong> 15%-20% depending on distance and total price</li>
                <li><strong>Hotel Room Service:</strong> 15%-20% if not included in the price</li>
                <li><strong>Hotel Housekeeping:</strong> $1-$2 per person per night</li>
                <li><strong>Automotive Services, Mechanic:</strong> Not expected, or a few dollars</li>
                <li><strong>Mover, Furniture, or Appliance Delivery:</strong> Not expected, or $5-$20 each</li>
                <li><strong>Plumber, Handyman, Electrician, Cleaner:</strong> Not expected, or $5-$20 each</li>
                <li><strong>Hairstylists, Barber, Nail Service:</strong> 10%-20%</li>
                <li><strong>Massage:</strong> 10%-20%</li>
                <li><strong>Taxi or Limo Drivers:</strong> 15%-20%</li>
                <li><strong>Shuttle Drivers, Parking Attendant:</strong> $1-$3</li>
                <li><strong>Tour Guides:</strong> $1-$5 depending on the length of the tour</li>
            </ul>
        </div>

    </div>

    <div class="py-4  px-2">
        <p>
            The tip calculator is a simple tool that allows you to calculate the tip amount for a given bill amount and tip rate. In the U.S., a tip of 15% of the before-tax meal price is typically expected. However, tipping customs vary around the world. In some countries, tipping is seen as an insult, while in others, it is a crucial part of a service worker's income.
        </p>
        <p class="mt-2">
            Understanding local tipping customs can enhance your travel experience and ensure you are respecting local practices. Use this calculator to quickly determine the appropriate tip for your service.
        </p>
    </div>

    @include('components.recommended-calculators')



</div>

<script>
document.getElementById('tipCalculatorForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Clear previous errors
    document.getElementById('amountError').textContent = '';
    document.getElementById('tipRateError').textContent = '';
    document.getElementById('peopleError').textContent = '';

    const formData = new FormData(this);

    fetch('{{ url('/tip-calculator') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.errors) {
            if (data.errors.amount) {
                document.getElementById('amountError').textContent = data.errors.amount[0];
            }
            if (data.errors.tip_rate) {
                document.getElementById('tipRateError').textContent = data.errors.tip_rate[0];
            }
            if (data.errors.people) {
                document.getElementById('peopleError').textContent = data.errors.people[0];
            }
        } else {
            document.getElementById('tipAmount').textContent = data.tip;
            document.getElementById('totalAmount').textContent = data.total;
            document.getElementById('perPersonAmount').textContent = data.per_person;
            document.getElementById('result').classList.remove('hidden');
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>
@endsection
