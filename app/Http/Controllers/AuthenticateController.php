<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Mail;
class AuthenticateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
   {
       // Apply the jwt.auth middleware to all methods in this controller
       // except for the authenticate method. We don't want to prevent
       // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['authenticate','register']]);
   }
    
    
    public function index()
    {
        $users = User::all();
    	return $users;
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
		
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
		$user = JWTAuth::toUser($token);
		// if no errors are encountered we can return a JWT
        return response()->json(array('token'=>$token,'user'=>$user));
    }
	
	public function register(Request $request) 
	{
         $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);	
		if ($validator->fails()) {
			return response()->json(array('status'=>'failure','errors'=>$validator->errors()->all()),401);
		}

		$data = array('name'=> $request->input('name'),
					'email'	=> $request->input('email'),
					'password'	=> $request->input('password')
		);

		$res =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
		
		if($res) {
			Mail::raw("Welcome to Laratasks!\n", function ($message) use ($data) {
    			$message->subject('Welcome!');
    			$message->to($data['email'],$data['name']);
			});
		}
		
		return $this->authenticate($request); 
	
	}
	
}
