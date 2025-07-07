@extends('layouts.app')
 
@section('title', 'Admin')
 
@section('contents')
<div>
    <h1 class="font-bold text-2xl ml-3">Dashboard</h1>
    <?php
            use Illuminate\Support\Facades\Auth;

            //dd(Auth::check(), Auth::user());
            ?>
</div>
@endsection