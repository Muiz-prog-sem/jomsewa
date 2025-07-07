@extends('layouts.app')
 
@section('title', 'Admin - Car List')

@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Car List</h1>

    @if(Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ Session::get('success') }}
    </div>
    <br>
    @endif
    <a href="{{ route('cars.create') }}" class="text-white float-right bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add Car</a>
    <hr>
 
    <table class="w-full text-sm text-center rtl:text-right text-gray-900 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Model</th>
                <th scope="col" class="px-6 py-3">Type</th>
                <th scope="col" class="px-6 py-3">Color</th>
                <th scope="col" class="px-6 py-3">Capacity</th>
                <th scope="col" class="px-6 py-3">Availability</th>
                <th scope="col" class="px-6 py-3">Price</th>
                <th scope="col" class="px-6 py-3">Image</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @if($cars->count() > 0)
            @foreach($cars as $rs)
            @if($rs->type == "MPV" && $rs->available < 4)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ $loop->iteration }}
                </th>
                <td>
                    {{ $rs->model }}
                </td>
                <td>
                    {{ $rs->type }}
                </td>
                <td>
                    {{ $rs->color }}
                </td>
                <td>
                    {{ $rs->person }}
                </td>
                <td>
                    {{ $rs->available }}
                </td>
                <td>
                    <p>RM{{ $rs->price }}/day</p>
                </td>
                <td>
                <div class="showPhoto">
                    <div id="imagePreview" style="@if ($rs->image != '') background-image:url('{{ url('/') }}/uploads/{{ $rs->image }}')@else background-image: url('{{ url('/img/avatar.png') }}') @endif;">
                </div>
                </div>
                </td>
                <td class="w-36">
                    <div class="h-14 pt-5">
                        <a href="{{ route('cars.show',$rs->id) }}" class="text-blue-800">Detail</a> |
                        <a href="{{ route('cars.edit', $rs->id) }}" class="text-green-800 pl-2">Edit</a> |
                        <form action="{{ route('cars.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="float-right text-red-800">
                            @csrf
                            @method('DELETE')
                            <button>Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endif
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="5">No Available Car</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection

<style>
    .showPhoto {
        width: 100%;
        height: 70px;
        margin: auto;
    }
 
    .showPhoto>div {
        width: 100%;
        height: 100%;
        border-radius: 30%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>