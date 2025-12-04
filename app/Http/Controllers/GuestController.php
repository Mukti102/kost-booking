<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Testimoni;
use App\Models\TypePayment;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {   
        $rooms = Room::where('status','belum terpakai')->get();
        $testimonis = Testimoni::all();
        return view('pages.guest.index',compact('rooms','testimonis'));
    }
    
    public function showRoom($id)
    {       
        $id = decrypt($id);
        $typePayments = TypePayment::all();
        $room = Room::findOrFail($id);
        return view('pages.guest.show',compact('room','typePayments'));
    }
}
