@extends('layouts.app')
 
@section('title', 'Admin - Payment List')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Payment List</h1>

    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
    <br>
    @endif
    <hr>
 
    <table class="w-full text-sm text-center rtl:text-right text-gray-900 dark:text-gray-800">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-1">No</th>
                <th scope="col" class="px-4 py-1">Payment ID</th>
                <th scope="col" class="px-4 py-1">Name</th>
                <th scope="col" class="px-4 py-1">Email</th>
                <th scope="col" class="px-4 py-1">Amount</th>
                <th scope="col" class="px-4 py-1">Status</th>
                <th scope="col" class="px-4 py-1">Method</th>
                <th scope="col" class="px-4 py-1">Time</th>
                <th scope="col" class="px-4 py-1">Action</th>
            </tr>
        </thead>
        <tbody>
            @if($list->count() > 0)
            @foreach($list as $rs)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $loop->iteration }}
                </th>
                <td>
                    {{ $rs->payment_id }}
                </td>
                <td>
                    {{ $rs->payer_name }}
                </td>
                <td>
                    {{ $rs->payer_email }}
                </td>
                <td>
                    {{ $rs->amount }}
                </td>
                <td>
                    {{ $rs->payment_status }}
                </td>
                <td>
                    {{ $rs->payment_method }}
                </td>
                <td>
                    {{ $rs->created_at }}
                </td>
                </td>
                <td class="px-6 py-4 w-46">
                    <div class="h-14 pt-5">
                        <a href="{{ route('payments.show', $rs->id) }}" class="text-blue-800">Detail</a>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="5">No payments been made</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection