<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Bookings extends Model
{
    use Uuids;

    protected $table = 'tbl_user_bookings';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'booking_date',
        'booking_type',
        'booking_slot',
        'from_time',
        'to_time'
    ];

    public static function calculateTimeRange($request)
    {
        $type = $request->booking_type;

        if ($type === 'full_day') {
            return ['00:00:00', '23:59:59', null];
        }

        if ($type === 'half_day') {

            if ($request->booking_slot === 'first_half') {
                return ['00:00:00', '11:59:59', 'first_half'];
            }

            return ['12:00:00', '23:59:59', 'second_half'];
        }

        return [$request->from_time, $request->to_time, null];
    }

    public static function createBooking($request, $user)
    {
        [$from, $to, $slot] = Bookings::calculateTimeRange($request);

        if (empty($from) || empty($to)) {
            return false;
        }

        $exists_booking = Bookings::where('booking_date', $request->booking_date)
            ->where(function ($q) use ($from, $to) {
                $q->where('from_time', '<', $to)
                    ->where('to_time', '>', $from);
            })->exists();

        if ($exists_booking) {
            return false;
        }

        // Store booking
        $booking = new Bookings();
        $booking->user_id = Auth::id() ?? $user->id;
        $booking->customer_name = $request->customer_name;
        $booking->customer_email = $request->customer_email;
        $booking->booking_date = $request->booking_date;
        $booking->booking_type = $request->booking_type;
        $booking->booking_slot = $slot;
        $booking->from_time = $from;
        $booking->to_time = $to;
        $booking->save();

        return $booking;
    }

    public static function getAllBookings($filterData = [])
    {
        $query = Bookings::select(
            'tbl_user_bookings.id',
            'tbl_user_bookings.customer_name',
            'tbl_user_bookings.customer_email',
            'tbl_user_bookings.booking_date',
            'tbl_user_bookings.booking_type',
            'tbl_user_bookings.booking_slot',
            'tbl_user_bookings.from_time',
            'tbl_user_bookings.to_time',
            'tbl_user_bookings.created_at'
        )
            ->from('tbl_user_bookings');

        // Search
        if (!empty($filterData['search'])) {
            $query->where(function ($q) use ($filterData) {
                $q->where('customer_name', 'like', '%' . $filterData['search'] . '%')
                    ->orWhere('customer_email', 'like', '%' . $filterData['search'] . '%');
            });
        }

        // Filters
        $filters = $filterData['filters'] ?? [];

        if (!empty($filters['booking_type']) && is_array($filters['booking_type']) && $filters['booking_type'][0] !== null) {
            $query->whereIn('booking_type', $filters['booking_type']);
        }

        if (!empty($filters['from']) && !empty($filters['to'])) {
            $query->whereDate('booking_date', '>=', $filters['from']);
        }

        if (!empty($filters['to']) && !empty($filters['to'])) {
            $query->whereDate('booking_date', '<=', $filters['to']);
        }

        // Sorting
        if (!empty($filterData['sorting']) && is_array($filterData['sorting'])) {
            foreach ($filterData['sorting'] as $sort) {
                $query->orderBy($sort['field'], $sort['dir']);
            }
        } else {
            $query->orderBy('tbl_user_bookings.created_at', 'desc');
        }

        return $query;
    }
}
