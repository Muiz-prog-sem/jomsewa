@extends('layouts.user')

@section('title', 'Customer - Edit Booking Date')

@section('contents')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 text-center">Edit Booking Details</h1>
        <hr class="my-4">
        @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
    <br>
    @endif
        <div class="bg-white shadow-md rounded-lg overflow-hidden mx-auto max-w-2xl">
            <div class="p-4 sm:p-6">
                <form action="{{ route('users.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6">
                       

                        <div>
                            <label for="book_from" class="block text-sm font-medium text-gray-700">From</label>
                            <input type="date" name="book_from" id="book_from" value="{{ $booking->book_from }}" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="book_to" class="block text-sm font-medium text-gray-700">To</label>
                            <input type="date" name="book_to" id="book_to" value="{{ $booking->book_to }}" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>

                         <div>
                            <label for="totalcar" class="block text-sm font-medium text-gray-700">Number of Car to Book</label>
                            <input type="text" name="totalcar" id="totalcar" value="{{ $booking->totalcar }}" class="block w-full mt-1 px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>

                        <input type="hidden" name="booking_status" id="booking_status" value="0">
                        <input type="hidden" name="car_id" value="{{ $car->id }}">

                        <div class="flex justify-center mt-6 space-x-4">
                            <a href="{{ route('users.show', ['id' => auth()->user()->id]) }}" class="inline-flex justify-center w-36 py-3 text-sm font-medium text-white bg-gray-400 border border-transparent rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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
