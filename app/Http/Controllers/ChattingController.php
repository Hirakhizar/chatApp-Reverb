<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChattingController extends Controller
{
    public function index(Request $request){
        $request->validate([
            "username"=> "required",
        ]);
        $username=$request->username;

        return view("chat_room",compact('username'));
    }
    public function fireMessage(Request $request){
        MessageSent::dispatch($request->sender,$request->message);
        return $request->all();
    }
}
