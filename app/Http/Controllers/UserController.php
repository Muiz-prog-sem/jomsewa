<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

use App\Models\Car;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::where('available', '>', 0);

        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }

        if ($request->filled('color')) {
            $query->where('color', 'like', '%' . $request->color . '%');
        }

        if ($request->filled('person')) {
            $query->where('person', $request->person);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $cars = $query->paginate();

        return view('users.index', compact('cars'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Car $car)
    {
        $books = Booking::where('car_id', $car->id)->get(['book_from', 'book_to']);
        return view('users.create', compact('car', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'book_from' => 'required|date',
            'book_to' => 'required|date|after_or_equal:start_date',
            'booking_status' => 'required|integer',
            'totalcar' => 'required|integer|min:1',
        ]);
        
        $car = Car::findOrFail($request->car_id);
        //Booking::create($request->all());

        //Check kalau kereta ada ke takde
        if ($car->available < $request->totalcar) 
        {
            return redirect()->back()->withErrors(['Car is not available for booking']);
        }

        //convert kepada date
        $startdate = Carbon::parse($request->input('book_from'));
        $enddate = Carbon::parse($request->input('book_to'));

        $days = $startdate->diffInDays($enddate) + 1;
        $priceperday = $car->price;

        //kira-kira semua sekali
        $totalPrice = ($days * $priceperday) * $request->totalcar;
   
        Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'book_from' => $request->book_from,
            'book_to' => $request->book_to,
            'totalcar' => $request->totalcar,
            'days' => $days,
            'book_status' => $request->booking_status,
            'book_price' => $totalPrice,
        ]);

        $car->available -= $request->totalcar;
        $car->save();
    
        return redirect()->route('users.show', ['id' => auth()->user()->id])->with('success', 'Your booking was successful. Proceed to payment to complete your reservation.');
    }

    private function getUserAndBookings($id)
    {
        $user = User::findOrFail($id);
        $bookings = $user->bookings()->with('car')->get();
        return compact('user', 'bookings');
    }

    // Show method
    public function show($id)
    {
        $data = $this->getUserAndBookings($id);
        return view('users.show', $data);
    }

    // Detail method / for confirmation or pay
    public function detail($id)
    {
        $user = auth()->user();
        $booking = Booking::with('car')->findOrFail($id);
        return view('users.confirmation', compact('booking', 'user'));
    }
    
    public function confirmation(Request $request)
    {
        $user = auth()->user();
        $bookings = $user->bookings()->where('book_status', 0)->get(); // Assuming only pending bookings are to be paid
        $totalPrice = $bookings->sum('book_price');
    
        return view('users.confirmationTotal', compact('user', 'bookings', 'totalPrice'));
    }
    
    

    public function edit(Booking $booking)
    {
        $car = $booking->car;
        $books = Booking::where('car_id', $car->id)->where('id', '!=', $booking->id)->get(['book_from', 'book_to']);
        return view('users.edit', compact('booking', 'car', 'books'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'book_from' => 'required|date',
            'book_to' => 'required|date|after_or_equal:book_from',
            'totalcar' => 'required|integer|min:1',
        ]);

        $car = $booking->car;

        // Parse the new booking dates
        $startdate = Carbon::parse($request->input('book_from'));
        $enddate = Carbon::parse($request->input('book_to'));

        // Check for overlapping bookings excluding the current booking

        $days = $startdate->diffInDays($enddate) + 1;
        $priceperday = $car->price;

        // Recalculate the total price
        $totalPrice = ($days * $priceperday) * $request->totalcar;

        // Update the booking details
        $booking->book_from = $request->input('book_from');
        $booking->book_to = $request->input('book_to');
        $booking->days = $days;
        $booking->totalcar = $request->totalcar;
        $booking->book_price = $totalPrice;
        $booking->save();

        $data = $this->getUserAndBookings($booking->user_id);
        return redirect()->route('users.show', $data['user']->id)->with('success', 'Booking updated successfully.');
    }

    public function extendform(Booking $booking)
    {
        $car = $booking->car;

        // Retrieve all existing bookings for the same car excluding the current booking
        $books = Booking::where('car_id', $car->id)
                    ->where('id', '!=', $booking->id)
                    ->get(['book_from', 'book_to']);

        return view('users.extend', compact('booking', 'books', 'car'));
    }

    public function updateextendform(Request $request, Booking $booking)
    {
        $request->validate([
        'book_to' => 'required|date|after_or_equal:' . Carbon::parse($booking->book_to)->toDateString(),
        'totalcar' => 'required|integer|min:1',
        ]);

        $car = $booking->car;

        // Parse the new booking end date
        $newEndDate = Carbon::parse($request->input('book_to'));

        // Calculate the number of days for the extension
        $extensionDays = $newEndDate->diffInDays($booking->book_to);

        // Calculate the new total price
        $pricePerDay = $car->price;
        $newTotalPrice = ($extensionDays * $pricePerDay) * $request->totalcar;

        // Update the booking details
        $booking->book_to = $newEndDate;
        $booking->days += $extensionDays;
        $booking->totalcar = $request->totalcar;
        $booking->book_price = $newTotalPrice;
        $booking->save();

        $data = $this->getUserAndBookings($booking->user_id);
        return redirect()->route('users.confirmation', ['id' => $data['user']->id])->with('success', 'Booking updated successfully.');

    }

    public function destroy(string $id)
    {
        //
    }

}
