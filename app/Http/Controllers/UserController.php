<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function show($id){
        // var_dump($id);
        return response()->json(['user_id' => $id]);
    }

    public function Age($age){
        
        return response()->json(['message' => 'You are allowed']);
    }

}
