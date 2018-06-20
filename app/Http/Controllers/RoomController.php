<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function all() {
        return Room::all();
    }

    public function one(Room $room) {
        return $room;
    }

    public function create(Request $request) {
        $room = Room::create($request->all());

        return response()->json($room, 201);
    }

    public function update(Request $request, Room $room) {
        $room->update($request->all());
        return response()->json($room, 200);
    }

    public function delete(Room $room) {
        $room->delete();
        return response()->json(null, 204);
    }
}
