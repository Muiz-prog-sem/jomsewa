@extends('layouts.app')
 
@section('title', 'Admin - Booking Details')
 
@section('contents')
<h1 class="font-bold text-2xl ml-3">Booking Details</h1>
<hr />
<div class="border-b border-gray-900/10 pb-12">
    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Name</label>______
            <div class="mt-2">
                <strong>{{ $books->user->name }}</strong>
            </div>
        </div>
 
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Phone</label>______
            <div class="mt-2">
                <strong>{{ $books->user->phone }}</strong>
            </div>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Model</label>______
            <div class="mt-2">
                <strong>{{ $books->car->model }}</strong>
            </div>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Date</label>______
            <div class="mt-2">
                <strong>{{ $books->book_date }}</strong>
            </div>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Book Status</label>
            <div @class([
                    'btn',
                    'btn-danger-success' => $books->book_status,
                    'btn-danger-danger' => !$books->book_status,
                ])>
                {{ $books->book_status ? 'Pending' : 'Approved' }}
            </div>
        </div>
        </form>
    </div>
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