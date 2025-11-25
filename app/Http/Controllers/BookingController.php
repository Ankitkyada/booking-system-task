<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $skip = (int)$request->input('skip', 0);
            $take = (int)$request->input('take', 10);

            $validator = Validator::make($request->all(), [
                'skip'    => 'nullable|integer|min:0',
                'take'    => 'nullable|integer|min:1',
                'sort'    => 'nullable|array',
                'search'  => 'nullable|string|max:255',
                'filters' => 'nullable|array'
            ]);

            if ($validator->fails()) {
                return back()->with('error', 'Invalid filters.');
            }

            $filterData = [
                'skip'    => $skip,
                'take'    => $take,
                'sorting' => $request->input('sort', []),
                'search'  => $request->input('search', ''),
                'filters' => $request->input('filters', [])
            ];

            $bookingQuery = Bookings::getAllBookings($filterData);

            $totalRecords = $bookingQuery->count();
            $totalPages = $take > 0 ? ceil($totalRecords / $take) : 1;
            $currentPage = ($skip / $take) + 1;

            $bookings = $bookingQuery->skip($skip)->take($take)->get();

            $responseData = [
                'total_records' => $totalRecords,
                'total_pages' => $totalPages,
                'current_page' => $currentPage,
                'per_page' => $take,
                'skip' => $skip,
                'take' => $take,
                'data' => $bookings
            ];

            return view('booking.index', compact('responseData'));
        } catch (\Exception $e) {
            return back()->with('error', 'Server error: ' . $e->getMessage());
        }
    }

    // Show create form
    public function create()
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
        $user = Auth::user();

        $booking_result = Bookings::createBooking($request, $user->id);

        if (!$booking_result) {
            return back()->with('error', 'This booking overlaps with an existing booking');
        }

        return back()->with('success', 'Booking created successfully');
    }
}
