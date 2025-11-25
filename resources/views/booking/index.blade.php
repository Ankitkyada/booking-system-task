@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- Header -->
    <div class="card shadow-sm mb-2">
        <div class="card-body d-flex justify-content-between align-items-center py-2">
            <h5 class="mb-0">Bookings List</h5>
            <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm">
                + Create Booking
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white"><strong>Filters</strong></div>

        <div class="card-body">
            <form method="GET" action="{{ route('bookings.index') }}" class="row g-3">

                <input type="hidden" name="skip" value="{{ request('skip', 0) }}">
                <input type="hidden" name="take" value="{{ request('take', 10) }}">

                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control"
                        value="{{ request('search') }}" placeholder="Name or Email">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Booking Type</label>
                    <select name="filters[booking_type][]" class="form-select">
                        <option value="">All</option>
                        <option value="full_day" {{ request('filters.booking_type.0')=='full_day'?'selected':'' }}>Full Day</option>
                        <option value="half_day" {{ request('filters.booking_type.0')=='half_day'?'selected':'' }}>Half Day</option>
                        <option value="custom" {{ request('filters.booking_type.0')=='custom'?'selected':'' }}>Custom</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">From Date</label>
                    <input type="date" name="filters[from]" class="form-control"
                        value="{{ request('filters.from') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">To Date</label>
                    <input type="date" name="filters[to]" class="form-control"
                        value="{{ request('filters.to') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Apply</button>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Booking Records</strong>
        </div>

        @php $bookings = $responseData['data']; @endphp

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Slot</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->customer_name }}</td>
                        <td>{{ $booking->customer_email }}</td>
                        <td>{{ $booking->booking_date }}</td>
                        <td>{{ ucfirst(str_replace('_',' ',$booking->booking_type)) }}</td>
                        <td>{{ ucfirst(str_replace('_',' ',$booking->booking_slot)) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-3 text-muted">No bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @php
        $page = $responseData['current_page'];
        $totalPages = $responseData['total_pages'];
        $skip = $responseData['skip'];
        $take = $responseData['take'];
        @endphp

        <div class="card-footer text-center">

            {{-- Previous --}}
            @if ($page > 1)
            <a href="{{ route('bookings.index', array_merge(request()->query(), ['skip' => $skip - $take])) }}"
                class="btn btn-outline-primary mx-1">Previous</a>
            @endif

            <span class="btn btn-light mx-1">
                Page {{ $page }} of {{ $totalPages }}
            </span>

            {{-- Next --}}
            @if ($page < $totalPages)
                <a href="{{ route('bookings.index', array_merge(request()->query(), ['skip' => $skip + $take])) }}"
                class="btn btn-outline-primary mx-1">Next</a>
                @endif

        </div>
    </div>

</div>

@endsection