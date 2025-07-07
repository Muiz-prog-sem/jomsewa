@extends('layouts.app')
 
@section('title', 'Admin - Payments Details')
 
@section('contents')
<h1 class="font-bold text-2xl ml-3">Payments Details - {{ $list->payer_name }}</h1>
<hr />
<div class="border-b border-gray-900/10 pb-12">
    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Payment ID - <strong>{{ $list->payment_id }}</strong></label>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Name - <strong>{{ $list->payer_name }}</strong></label>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Email - <strong>{{ $list->payer_email }}</strong></label>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Amount - <strong>{{ $list->amount }}</strong></label>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Status - <strong>{{ $list->payment_status }}</strong></label>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Method - <strong>{{ $list->payment_method }}</strong></label>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Time - <strong>{{ $list->created_at }}</strong></label>
        </div>
        </form>
    </div>
</div>
@endsection