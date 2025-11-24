<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // Show form
    public function index()
    {
        return view('booking.create');
    }

    // Save booking
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'booking_date' => 'required|date',
            'booking_type' => 'required|in:full_day,half_day,custom'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'The given data was invalid.');
        }

        $booking_result = Bookings::createBooking($request);

        if (!$booking_result) {
            return back()->with('error', 'This booking overlaps with an existing booking');
        }

        return back()->with('success', 'Booking created successfully');
    }
}
