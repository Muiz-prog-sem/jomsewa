@extends('layouts.user')

@section('title', 'Customer - Book Car')

@section('contents')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 text-center">Book Car</h1>
        <hr class="my-4">
        @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        {{ Session::get('success') }}
    </div>
    <br>
    @endif
        <div class="bg-white shadow-md rounded-lg overflow-hidden mx-auto max-w-2xl">
            <div class="p-4 sm:p-6">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <div class="flex items-center justify-center">
                            <img src="{{ asset('uploads/' . $car->image) }}" alt="Car Image" class="rounded-lg shadow-md h-auto max-w-full">
                        </div>

                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                            <input type="text" name="model" id="model" value="{{ $car->model }}" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <input type="text" name="type" id="type" value="{{ $car->type }}" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Color</label>
                            <input type="text" name="color" id="color" value="{{ $car->color }}" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Capacity</label>
                            <input type="text" name="person" id="person" value="{{ $car->person }}" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price per day</label>
                            <input type="text" name="price" id="price" value="{{ $car->price }}" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" readonly>
                        </div>
                       

                        <div>
                            <label for="book_from" class="block text-sm font-medium text-gray-700">From</label>
                            <input type="date" name="book_from" id="book_from" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="book_to" class="block text-sm font-medium text-gray-700">To</label>
                            <input type="date" name="book_to" id="book_to" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="totalcar" class="block text-sm font-medium text-gray-700">Number of Car to Book</label>
                            <input type="text" name="totalcar" id="totalcar" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>

                        <input type="hidden" name="booking_status" id="booking_status" value="0">
                        <input type="hidden" name="car_id" value="{{ $car->id }}">

                        <div class="flex justify-center mt-6 space-x-4">
                            <a href="{{ route('users.index') }}" class="inline-flex justify-center w-36 py-3 text-sm font-medium text-white bg-gray-400 border border-transparent rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Back
                            </a>
                            <button type="submit" class="inline-flex justify-center w-36 py-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
@endsection

@push('styles')
    <style>
        input[type='date']::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>
@endpush
