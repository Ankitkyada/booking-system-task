<style>
    form {
        max-width: 500px;
        margin: 20px auto;
        padding: 25px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="time"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #aaa;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 14px;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    p {
        text-align: center;
        font-weight: bold;
    }

    p[style*="color:green"] {
        color: #28a745;
    }

    p[style*="color:red"] {
        color: #dc3545;
    }

    #half_day_slot,
    #custom_time {
        padding: 10px;
        border: 1px dashed #ccc;
        margin-bottom: 15px;
        border-radius: 5px;
        background-color: #fff;
    }
</style>
<h2>Create Booking</h2>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
<p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ url('/bookings/store') }}">
    @csrf

    <label>Customer Name</label>
    <input type="text" name="customer_name" required>

    <label>Customer Email</label>
    <input type="email" name="customer_email" required>

    <label>Booking Date</label>
    <input type="date" name="booking_date" required>

    <label>Booking Type</label>
    <select name="booking_type" id="booking_type" onchange="toggleOptions()" required>
        <option value="">Select</option>
        <option value="full_day">Full Day</option>
        <option value="half_day">Half Day</option>
        <option value="custom">Custom</option>
    </select>

    <div id="half_day_slot" style="display:none;">
        <label>Booking Slot</label>
        <select name="booking_slot">
            <option value="first_half">First Half</option>
            <option value="second_half">Second Half</option>
        </select>
    </div>

    <div id="custom_time" style="display:none;">
        <label>From Time</label>
        <input type="time" name="from_time">

        <label>To Time</label>
        <input type="time" name="to_time">
    </div>

    <button type="submit">Submit</button>
</form>

<script>
    function toggleOptions() {
        let type = document.getElementById('booking_type').value;

        document.getElementById('half_day_slot').style.display =
            type == 'half_day' ? 'block' : 'none';

        document.getElementById('custom_time').style.display =
            type == 'custom' ? 'block' : 'none';
    }
</script>