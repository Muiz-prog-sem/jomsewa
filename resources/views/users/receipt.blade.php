@extends('layouts.user')

@section('title', 'Receipt - Payment Successful')

@section('contents')
    <div class="bg-white border rounded-lg shadow-lg px-6 py-8 max-w-md mx-auto mt-8">
        <h1 class="font-bold text-3xl mb-4 text-center text-gray-800">Payment Receipt</h1>
        <hr class="mb-6">

        <div class="bg-white border rounded-lg shadow-lg px-6 py-8 max-w-md mx-auto">
            <div class="mb-8">
                <h2 class="text-lg font-bold mb-4">Payment Details:</h2>
                <div class="text-gray-700 mb-2">Invoice #: {{ $payment->payment_id }}</div>
                <div class="text-gray-700 mb-2">Payer Name: {{ $payment->payer_name }}</div>
                <div class="text-gray-700 mb-2">Payer Email: {{ $payment->payer_email }}</div>
                <div class="text-gray-700 mb-2">Amount Paid: RM{{ $payment->amount }}</div>
                <div class="text-gray-700 mb-2">Payment Method: {{ $payment->payment_method }}</div>
                <div class="text-gray-700">Payment Status: {{ $payment->payment_status }}</div>
            </div>
            <div class="text-gray-700 mb-2 text-center">Thank you for your payment!</div>
        </div>

        <div class="flex justify-center space-x-4 mt-8">
            <a href="{{ route('users.show', ['id' => auth()->user()->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                Back to Bookings
            </a>
            <a href="{{ route('receipt.pdf', ['payment' => $payment->id]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                Download PDF
            </a>
        </div>
    </div>

    <!-- JavaScript for Notification -->
    <script>
        // Display a pop-up notification
        alert('Your payment is successful. Please wait for approval from admin via email. Remember to save this payment receipt for your records.');
    </script>
@endsection
