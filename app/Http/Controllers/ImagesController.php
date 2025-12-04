<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Room;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function index($id)
    {
        $room = Room::find($id);
        $images = $room->images;
        return view('pages.dashboard.rooms.images', compact('images', 'id'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required',
            'room_id' => 'required'
        ]);

        $path = $request->file('image')->store('room/images', 'public');

        $room = Room::find($request->room_id);
        $room->images()->create([
            'path' => $path,
        ]);

        toastify()->success('Berhasil Menambah Gambar');
        return redirect()->back();
    }

    public function destroy(Request $request, $id) {
        $id = $id;
        $image = Images::find($id);
        $image->delete();
        toastify()->success('Berhasil Meghapus');
        return redirect()->back();
    }
}
