<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\WelcomeMail;
use Mail;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    public function auth()
    {

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user             = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;

            return response()->json(['success' => $success,"user"=>$user], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

        /* $userRequested = $request->all(); */

        /* try {
    $userFound = User::where("email", $userRequested["email"])->first();

    } catch (\Throwable $th) {
    return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    if ($userFound && $userFound->password == $userRequested["password"]) {
    unset($userFound->password);
    $request->session()->put("user-logged",$userFound);
    $token = $userFound->createToken("authToken")->accessToken;
    $userFound->token = $token;
    return $userFound;
    } else {
    return response()->json(['error' => 'Unauthenticated.'], 401);
    } */
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }else{
            $input             = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user              = User::create($input);
            $success['token']  = $user->createToken('MyApp')->accessToken;
            $success['name']   = $user->name;
            Mail::to($user->email)->send(new WelcomeMail(["name"=>$user->name,"email"=>$user->email]));
            return response()->json(['success' => $success], $this->successStatus);
        }


        /* $found = User::where("email", $request->email)->count();
        if ($found === 0) {
            $userCreated = User::create($request->all());
            unset($userCreated->password);
            return $userCreated;
        } else {
            return response()->json(['error' => 'User already exists.'], 404);
        } */

    }

    public function delete($id)
    {
        $userToDelete = User::find($id);
        if (isset($userToDelete)) {
            $userToDelete->makeHidden('password');
            $userToDelete->delete();
            return $userToDelete;
        } else {
            return response()->json(['error' => 'User don\'t exists.'], 404);
        }

    }

    public function getsessiondata(Request $request)
    {
        $user = $request->session()->has("user-logged");
        return $user;
    }
    public function logout($id){
        $userTokens = User::find($id)->tokens;

        if (Auth::check()) {
            foreach($userTokens as $token) {
                $token->revoke();
            }
            return response()->json(['success' =>'logout_success'],200);
        }else{
            return response()->json(['error' =>'api.something_went_wrong'], 500);
        }
    }
}
