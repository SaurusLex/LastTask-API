<?php

namespace App\Http\Controllers;
use App\Client;
use App\User;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function create(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'type'    => ['required',Rule::in(['Empresa','Particular'])]

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }else{
            $client = $request->all();
            $client += ["user_id" => $user->id];
            return Client::create($client);
        }

    }
    public function getAll(){
        $user = Auth::user();
        return Client::where("user_id",$user->id)->get();
    }
}
