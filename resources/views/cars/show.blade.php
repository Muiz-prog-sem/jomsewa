@extends('layouts.app')
 
@section('title', 'Admin - Car Details')
 
@section('contents')
<h1 class="font-bold text-2xl ml-3">Car Details</h1>
<hr />
<div class="border-b border-gray-900/10 pb-12">
    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Model</label>
            <div class="mt-2">
                <strong>{{ $cars->model }}</strong>
            </div>
        </div>
 
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Type</label>
            <div class="mt-2">
                <strong>{{ $cars->type }}</strong>
            </div>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Price</label>
            <div class="mt-2">
                <strong>RM{{ $cars->price }}/day</strong>
            </div>
        </div>
        <div class="sm:col-span-4">
            <label class="block text-sm font-medium leading-6 text-gray-900">Image</label>
            <div class="showPhoto">
                <div id="imagePreview" style="@if ($cars->image != '') background-image:url('{{ url('/') }}/uploads/{{ $cars->image }}')@else background-image: url('{{ url('/img/avatar.png') }}') @endif;">
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
<style>
    .showPhoto {
        width: 100%;
        height: 1000%;
        margin: auto;
    }
 
    .showPhoto>div {
        width: 60%;
        height: 100%;
        border-radius: 10%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>