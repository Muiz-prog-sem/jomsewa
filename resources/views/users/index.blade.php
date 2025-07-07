@extends('layouts.user')

@section('title', 'Customer - Car List')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3 mt-8">Car List</h1><br>
    
    <form action="{{ route('users.index') }}" method="GET" class="mb-4">
        <div class="flex items-center">
            <input type="text" name="model" id="model" value="{{ request('model') }}" class="w-40 mr-4 ml-1.5 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Model">
            <input type="text" name="type" id="type" value="{{ request('type') }}" class="w-40 mr-4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Type">
            <input type="text" name="color" id="color" value="{{ request('color') }}" class="w-40 mr-4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Color">
            <input type="text" name="person" id="person" value="{{ request('person') }}" class="w-40 mr-4 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Capacity">
            <input type="number" name="min_price" id="min_price" value="{{ request('price') }}" class="w-40 mr-4 px-1 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Min Price">
            <input type="number" name="max_price" id="max_price" value="{{ request('price') }}" class="w-40 mr-4 px-1 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Max Price">
            <!-- Add more filter inputs as needed -->
            <button type="submit" class="inline-flex justify-center mr-4 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Filter</button>
            <a href="{{ route('users.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Clear
            </a>
        </div>
    </form>
    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
    <br>
    @endif
    <hr>

    <table class="min-w-full bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden" id="carTable">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th scope="col" class="py-3 px-4 text-center">No</th>
                <th scope="col" class="py-3 px-4 text-center">Model</th>
                <th scope="col" class="py-3 px-4 text-center">Type</th>
                <th scope="col" class="py-3 px-4 text-center">Color</th>
                <th scope="col" class="py-3 px-4 text-center">Capacity</th>
                <th scope="col" class="py-3 px-4 text-center">Availability</th>
                <th scope="col" class="py-3 px-4 text-center">Price</th>
                <th scope="col" class="py-3 px-4 text-center">Total Price</th> <!-- New column -->
                <th scope="col" class="py-3 px-4 text-center">Image</th>
                <th scope="col" class="py-3 px-4 text-center">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @if($cars->count() > 0)
            @foreach($cars as $car)
            <tr class="hover:bg-gray-50">
                <td class="py-4 px-6 text-center">{{ $loop->iteration }}</td>
                <td class="py-4 px-6 text-center">{{ $car->model }}</td>
                <td class="py-4 px-6 text-center">{{ $car->type }}</td>
                <td class="py-4 px-6 text-center">{{ $car->color }}</td>
                <td class="py-4 px-6 text-center">{{ $car->person }}</td>
                <td class="py-4 px-6 text-center">{{ $car->available }}</td>
                <td class="py-4 px-6 text-center">RM{{ $car->price }}/day</td>
                <td class="py-4 px-6 text-center">RM{{ $car->price * $car->available }}</td> <!-- New data cell -->
                <td class="py-4 px-6 text-center">
                    <div class="showPhoto mx-auto">
                        <img src="{{ url('/') }}/uploads/{{ $car->image }}" alt="Car Image" class="w-full h-auto">
                    </div>
                </td>
                <td class="py-4 px-6 text-center">
                    <a href="{{ route('users.create', $car->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full shadow-md transition duration-300">
                        Book Now
                    </a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center py-4 px-6" colspan="10">Sorry No Available Car</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection

<style>
    .showPhoto img {
        max-width: 150px;
        border-radius: 10px;
        object-fit: cover;
    }
</style>

@push('js')
<script type="text/javascript">
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var searchValue = this.value.toLowerCase();
        var table = document.getElementById('carTable');
        var rows = table.getElementsByTagName('tr');
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var showRow = false;
            for (var j = 0; j < cells.length; j++) {
                if (cells[j].innerText.toLowerCase().indexOf(searchValue) > -1) {
                    showRow = true;
                    break;
                }
            }
            rows[i].style.display = showRow ? '' : 'none';
        }
    });
</script>
@endpush
