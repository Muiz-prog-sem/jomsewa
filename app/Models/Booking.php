<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Car;
use App\Models\Payment;

class Booking extends Model
{
    use HasFactory;

    public $table = "bookings";
    protected $fillable = ['user_id', 'car_id', 'pay_status', 'book_from', 'book_to', 'totalcar', 'days', 'book_status', 'book_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Optionally, define the relationship to the Car model if it exists
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
