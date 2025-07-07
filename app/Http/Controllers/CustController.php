<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use DB;

class CustController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cust = User::where('id', '!=', 3)->get();
        return view('customers.index', compact('cust'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cust = User::findOrFail($id);
        return view('customers.show',compact('cust'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cust = User::findOrFail($id);
        $cust->delete();
        return redirect()->route('customers.index')
                        ->with('success','User deleted successfully');
    }
}
