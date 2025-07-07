@extends('layouts.user')

@section('title', 'Customer - Booking Confirmation')

@section('contents')
    <h1 class="font-bold text-2xl ml-3">Booking Confirmation</h1>
    <h5 class="font-bold text-1xl ml-3">Please review your booking details before proceeding with the transaction.</h5>
    <hr />

    @if(Session::has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    @if ($booking)
        <div class="bg-white border rounded-lg shadow-lg px-6 py-8 max-w-md mx-auto mt-8">
            <h1 class="font-bold text-2xl my-4 text-center text-black-600">JomSewa Sdn Bhd</h1>
            <hr class="mb-2">
            <div class="flex justify-between mb-6">
                <h1 class="text-lg font-bold">Invoice</h1>
                <div class="text-gray-700">
                    <div style="display: inline-block;">Date:</div>
                    <div style="display: inline-block;"><p id="todaysDate" style="display: inline;"></p></div>
                    <div>Invoice #: INV12345</div>
                </div>
            </div>
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-4">Your Details:</h2>
                <div class="text-gray-700 mb-2">{{ $user->name }}</div>
                <div class="text-gray-700 mb-2">{{ $user->phone }}</div>
                <div class="text-gray-700">{{ $user->email }}</div>
            </div>
            <table class="w-full mb-8">
                <thead>
                    <tr>
                        <th class="text-left font-bold text-gray-700">Booking Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left text-gray-700">Model</td>
                        <td class="text-right text-gray-700">{{ $booking->car->model }}</td>
                    </tr>
                    <tr>
                        <td class="text-left text-gray-700">Rate</td>
                        <td class="text-right text-gray-700">RM{{ $booking->car->price }}</td>
                    </tr>
                    <tr>
                        <td class="text-left text-gray-700">Booked For</td>
                        <td class="text-right text-gray-700">{{ $booking->totalcar }}</td>
                    </tr>
                    <tr>
                        <td class="text-left text-gray-700">Date</td>
                        <td class="text-right text-gray-700">{{ \Carbon\Carbon::parse($booking->book_from)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($booking->book_to)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-left text-gray-700">Days</td>
                        <td class="text-right text-gray-700">{{ $booking->days }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-left font-bold text-gray-700">Total to Pay</td>
                        <td class="text-right font-bold text-gray-700">RM{{ $booking->book_price }}</td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-gray-700 mb-2">Thank you for choosing us!</div>
            <div class="text-gray-700 text-sm">Please make payment within 24 hours.</div>
            <br>
            <center>
                <form action="{{ route('paypal') }}" class="bg-blue-500 hover:bg-blue-700 py-1 px-10 rounded" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="total" value="{{ $booking->book_price }}">
                    <input type="hidden" name="booking_id[]" value="{{ $booking->id }}">                
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-10 rounded focus:outline-none focus:shadow-outline" style="display: flex; align-items: center;">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-paypal" viewBox="0 0 16 16">
                                <path d="M14.06 3.713c.12-1.071-.093-1.832-.702-2.526C12.628.356 11.312 0 9.626 0H4.734a.7.7 0 0 0-.691.59L2.005 13.509a.42.42 0 0 0 .415.486h2.756l-.202 1.28a.628.628 0 0 0 .62.726H8.14c.429 0 .793-.31.862-.731l.025-.13.48-3.043.03-.164.001-.007a.35.35 0 0 1 .348-.297h.38c1.266 0 2.425-.256 3.345-.91q.57-.403.993-1.005a4.94 4.94 0 0 0 .88-2.195c.242-1.246.13-2.356-.57-3.154a2.7 2.7 0 0 0-.76-.59l-.094-.061ZM6.543 8.82a.7.7 0 0 1 .321-.079H8.3c2.82 0 5.027-1.144 5.672-4.456l.003-.016q.326.186.548.438c.546.623.679 1.535.45 2.71-.272 1.397-.866 2.307-1.663 2.874-.802.57-1.842.815-3.043.815h-.38a.87.87 0 0 0-.863.734l-.03.164-.48 3.043-.024.13-.001.004a.35.35 0 0 1-.348.296H5.595a.106.106 0 0 1-.105-.123l.208-1.32z"/>
                            </svg>
                        </span>
                        <span style="margin-left: 5px;">Pay with PayPal</span>
                    </button>
                </form>
                <br>
                <a href="{{ route('users.show', ['id' => auth()->user()->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-10 rounded focus:outline-none focus:shadow-outline mt-4">
                    <span>Back</span>
                </a>
            </center>
        </div>
    @endif
@endsection

@push('js')
<script type="text/javascript">
    // Get today's date
    var today = new Date();

    // Extract date components
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var year = today.getFullYear();

    // Create a string representing today's date
    var formattedDate = day + '/' + month + '/' + year;

    // Display today's date in the HTML element with id "todaysDate"
    document.getElementById('todaysDate').textContent =  formattedDate;
</script>
@endpush
