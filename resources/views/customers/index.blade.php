@extends('layouts.app')
 
@section('title', 'Admin - Customer List')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Customer List</h1>

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
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Phone</th>
                <th scope="col" class="px-6 py-3">Joined On</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @if($cust->count() > 0)
            @foreach($cust as $rs)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $loop->iteration }}
                </th>
                <td>
                    {{ $rs->name }}
                </td>
                <td>
                    {{ $rs->email }}
                </td>
                <td>
                    {{ $rs->phone }}
                </td>
                <td>
                    {{ $rs->created_at }}
                </td>
                </td>
                <td class="px-6 py-4 w-46">
                    <div class="h-14 pt-5">
                        <a href="{{ route('customers.show', $rs->id) }}" class="text-blue-800">Detail</a><hr>
                        <form action="{{ route('customers.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="text-red-800">
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
                <td class="text-center" colspan="5">No customer found</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection