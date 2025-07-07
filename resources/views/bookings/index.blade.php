@extends('layouts.app')
 
@section('title', 'Admin - Booking List')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Booking List</h1>

    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
    <br>
    @endif
    <hr>
 
    <table class="w-full text-sm text-center rtl:text-right text-gray-900 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-4 py-3">No</th>
            <th scope="col" class="px-4 py-3">Name</th>
            <th scope="col" class="px-4 py-3">Phone</th>
            <th scope="col" class="px-4 py-3">Car</th>
            <th scope="col" class="px-4 py-3">Booked For</th>
            <th scope="col" class="px-4 py-3">From</th>
            <th scope="col" class="px-4 py-3">To</th>
            <th scope="col" class="px-4 py-3">Days</th>
            <th scope="col" class="px-4 py-3">Amount</th>
            <th scope="col" class="px-4 py-3">Status</th>
            <th scope="col" class="px-4 py-3">Action</th>
        </tr>
    </thead>
    <tbody>
        @if($books->count() > 0)
        @foreach($books as $rs)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $loop->iteration }}
            </th>
            <td class="px-4 py-4">
                {{ $rs->user->name }}
            </td>
            <td class="px-4 py-4">
                {{ $rs->user->phone }}
            </td>
            <td class="px-4 py-4">
                {{ $rs->car->model }}
            </td>
            <td class="px-4 py-4">
                {{ $rs->totalcar }}
            </td>
            <td class="px-4 py-4">
            {{ \Carbon\Carbon::parse($rs->book_from)->format('d/m/Y') }}
            </td>
            <td class="px-4 py-4">
            {{ \Carbon\Carbon::parse($rs->book_to)->format('d/m/Y') }}
            </td>
            <td class="px-4 py-4">
                {{ $rs->days }}
            </td>
            <td class="px-4 py-4">
                RM{{ $rs->book_price }}
            </td>
            <td class="px-4 py-4">
                <a href="{{ route('bookings.status', $rs->id) }}" @class([
                    'btn',
                    'btn-danger-success' => $rs->book_status,
                    'btn-danger-danger' => !$rs->book_status,
                ])>
                    {{ $rs->book_status ? 'Approved' : 'Pending' }}
                </a>
            </td>
            <td class="px-10 py-4 w-46">
                <div class="h-14 pt-15">
                    <a href="{{ route('bookings.show', $rs->id) }}" class="text-blue-800">Detail</a>
                    <form action="{{ route('bookings.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="float-right text-red-800">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="px-6 py-4 text-center" colspan="7">No booking found</td>
        </tr>
        @endif
    </tbody>
</table>

</div>
@endsection

<style>
    .btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn:hover {
    text-decoration: none;
}

.btn:focus, .btn.focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn.disabled, .btn:disabled {
    opacity: 0.65;
    pointer-events: none;
}

.btn-danger-success {
    background-color: green;
    color: white;
}

.btn-danger-danger {
    background-color: red;
    color: white;
}
</style>