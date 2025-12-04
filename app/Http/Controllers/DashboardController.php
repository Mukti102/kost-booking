<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Fasility;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\TypePayment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {   
        $bookings = Booking::all();
        $typePayments = TypePayment::all();
        $facilities = Fasility::all();
        $rooms = Room::all();
        $tenants = Tenant::all();
        return view('pages.dashboard.dashboard',compact('bookings','typePayments','facilities','rooms','tenants'));
    }
}
