<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use DB;

use App\Models\Car;
use App\Models\User;
use App\Models\Booking;

//mail
use App\Mail\BookingApproved;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Booking::with('user', 'car')->get();
        return view('bookings.index',compact('books'));
    }

    /**
     * Change "Denied" or "Approved".
     */
    public function status($id)
    {
        $booking = Booking::findOrFail($id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found.');
        }

        // Toggle booking status
        $booking->book_status = !$booking->book_status;
        $booking->save();

        // Send email notification if status is approved
        if ($booking->book_status) {
            Mail::to($booking->user->email)->send(new BookingApproved($booking));
        }

        $statusMessage = $booking->book_status ? 'Booking approved successfully!' : 'Booking denied successfully!';

        return redirect()->back()->with('success', $statusMessage);
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
        $books = Booking::find($id);
        return view('bookings.show',compact('books'));
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
        $cars = Booking::findOrFail($id);
        $cars->delete();
        return redirect()->route('bookings.index')
                        ->with('success','Booking deleted successfully');
    }

    public function destroyUser(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('users.show', auth()->id())->with('success', 'Booking canceled successfully');
    }

}


