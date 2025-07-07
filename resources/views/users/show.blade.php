@extends('layouts.user')

@section('title', 'Customer - Booking Details')

@section('contents')
    <h1 class="font-bold text-2xl ml-3 mt-8">My Bookings</h1>
    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
    <br>
    @endif
    <hr />
    <div class="border-b border-gray-900/10 pb-12">
        <div class="mt-10 overflow-x-auto">
            @if($bookings->count() > 0)
                @php
                    $totalPrice = 0;
                @endphp
                <div style="overflow-x:auto;">
                    <table class="min-w-full bg-white border border-gray-300 shadow-lg rounded-lg">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-3 border-b text-center">No.</th>
                                <th class="py-3 px-3 border-b text-center">Car Model</th>
                                <th class="py-3 px-2 border-b text-center">From</th>
                                <th class="py-3 px-2 border-b text-center">To</th>
                                <th class="py-3 px-3 border-b text-center">Duration</th>
                                <th class="py-3 px-3 border-b text-center">Booked Car</th>
                                <th class="py-3 px-3 border-b text-center">Status</th>
                                <th class="py-3 px-3 border-b text-center">Payment Status</th>
                                <th class="py-3 px-2 border-b text-center">Total Price</th>
                                <th class="py-3 px-3 border-b text-center">Car Image</th>
                                <th class="py-3 px-3 border-b text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($bookings as $index => $booking)
                                <tr>
                                    <td class="py-4 px-3 text-center">{{ $index + 1 }}</td>
                                    <td class="py-4 px-3 text-center">{{ $booking->car->model }}</td>
                                    <td class="py-4 px-2 text-center">{{ \Carbon\Carbon::parse($booking->book_from)->format('d/m/Y') }}</td>
                                    <td class="py-4 px-2 text-center">{{ \Carbon\Carbon::parse($booking->book_to)->format('d/m/Y') }}</td>
                                    <td class="py-4 px-3 text-center">{{ $booking->days }} days</td>
                                    <td class="py-4 px-3 text-center">{{ $booking->totalcar }}</td>
                                    <td class="py-4 px-3 text-center">
                                        @if($booking->book_status === 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($booking->book_status === 1)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Unknown
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-3 text-center">
                                        @if($booking->pay_status)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                            @php
                                                $totalPrice += $booking->book_price; // Add to total price if payment is pending
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 text-center">RM{{ $booking->book_price }}</td>
                                    <td class="py-4 px-3 text-center">
                                        <img src="{{ asset('uploads/' . $booking->car->image) }}" class="w-24 h-auto mx-auto" alt="Car Image">
                                    </td>
                                    <td class="py-4 px-3 text-center space-x-4 flex items-center justify-center">
                                        @if($booking->book_status === 0 && $booking->pay_status)
                                            <form action="{{ route('bookings.destroyUser', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                                    Cancel
                                                </button>
                                            </form>
                                        @elseif($booking->book_status === 0)
                                            <a href="{{ route('users.confirmation', ['id' => $booking->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                                Pay
                                            </a>
                                            <a href="{{ route('users.edit', ['booking' => $booking->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                                Edit
                                            </a>
                                            <form action="{{ route('bookings.destroyUser', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                                    Cancel
                                                </button>
                                            </form>
                                        @elseif($booking->book_status === 1)
                                            <form action="{{ route('bookings.destroyUser', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total Price and Pay Button Section -->
                @if($totalPrice > 0)
                    <div class="flex justify-end items-center mt-4">
                        <div class="mr-4 text-lg font-bold">
                            Total Price: RM{{ $totalPrice }}
                        </div>
                        <form action="{{ route('users.confirmationTotal', ['id' => $booking->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="total" value="{{ $totalPrice }}">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Pay Total Price
                            </button>
                        </form>
                    </div>
                @endif

            @else
                <div class="py-4 px-6 text-center text-gray-700">
                    No bookings made.
                </div>
            @endif
        </div>
    </div>
@endsection
