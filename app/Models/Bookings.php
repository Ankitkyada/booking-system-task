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

    public static function createBooking($request)
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
        $booking->user_id = Auth::id();
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
}
