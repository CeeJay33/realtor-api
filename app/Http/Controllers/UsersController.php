<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::select( 'username', 'email')->get();

        return response()->json([
            "success" => true,
            "data" => $user
        ]);

    }



    //  public function invalidateAndDeleteToken(Request $request)
    // {
    //     // Step 1: Check if token exists in the database and delete it
    //     $token = $request->header('X-XSRF-TOKEN'); // Get CSRF token from the request header

    //     if ($token) {
    //         // Assuming your CSRF tokens are stored in a 'csrf_tokens' table
    //         DB::table('sessions')->where('token', $token)->delete();
    //     }

    //     // Step 2: Invalidate the current session
    //     $request->session()->invalidate();

    //     // Step 3: Regenerate a new CSRF token
    //     $request->session()->regenerateToken();

    //     return response()->json([
    //         'message' => 'CSRF token invalidated, session ended, and token deleted from the database.',
    //     ]);
    // }


    // creates the user data and stores in database
    public function store(Request $request){

        $fields = $request->validate([
            "username"=> "required|string",
            "email"=> "required|string|unique:users,email",
            "password"=> "required|string",
        ]);

         $user = User::create([

            "username" => $fields["username"],
            "email" => $fields["email"],
            "password" => bcrypt($fields["password"]),
         ]);

        // return json_encode(["message" => "created successfully!"]);

        $token = $user->createToken("my_app")->plainTextToken;

        //  if(!$user)
        $response = [
            "status" => "Successful",
            "token" => $token
        ];

        return response($response, 201);
    }


    // find user base on the ID

    public function show($id)
    {
        return User::find($id);
    }


    // check if user is aunthenticated
    public function checkAuthStats(Request $request)
    {
        $user = $request->user();
        if ($user) {
            return response()->json(['authenticated' => true, 'user' => $user]);
        }

        return response()->json(['authenticated' => false], 401);
    }










    // update the user password, username record 

    public function update(Request $request)
    {

     $userr =  $request->user();
    $userr->update($request->only(['password', 'username']));
    }









    // deletes the user record from the server

   public function destroy(Request $request)
{
    $user = $request->user();  

    $user->delete();

    return response()->json(['message' => 'Your account has been deleted successfully.'], 200);
}








    // search users

    public function search($name)
    {
      return  User::where('username', 'like', '%'.$name.'%')->get();
    }








    // logout all sessions

    public function logoutOutAll(Request $request)
    {
        $request->user()->token()->delete();

        return response()->json([
            "message" => "Logged out"
        ], 200);

        
    }









    // logout the current user

    public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

   Session::flush(); 
    Session::invalidate(); 

        $request->session()->regenerateToken();


    return response()->json([
        "message" => "Logged out "
    ], 200);
}










    //login method


public function login(Request $request)
{
     $fields = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || ! Hash::check($fields['password'], $user->password)){

            return response([
                "message" => "Invalid credentials"
            ], 401);

        }

        $token = $user->createToken("my_app")->plainTextToken;

        return response([

                 "message" => "Login successful",
                 "token" => $token
            ], 200);
}


 public function SearchProductByName($SeachByName)
 {
    return Product::where("propertylistCard0contentType", 'like', '%'.$SeachByName.'%')->get();
 }

}
