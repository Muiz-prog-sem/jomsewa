@extends('layouts.app')
 
@section('title', 'Admin - Customer Details')
 
@section('contents')
<h1 class="font-bold text-2xl ml-3">Customer Details</h1>
<hr />
<div class="border-b border-gray-900/10 pb-12">
    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Name</label>______
            <div class="mt-2">
                <strong>{{ $cust->name }}</strong>
            </div>
        </div>
 
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Email</label>______
            <div class="mt-2">
                <strong>{{ $cust->email }}</strong>
            </div>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Phone</label>______
            <div class="mt-2">
                <strong>{{ $cust->phone }}</strong>
            </div>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Joined On</label>__________
            <div class="mt-2">
                <strong>{{ $cust->created_at }}</strong>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection