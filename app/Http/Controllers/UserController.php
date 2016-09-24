<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function postSignUp(Request $request)
    {
        //perform validation using a Laravel helper method
        //unique in the users table .. way cool
        $this->validate($request, [
                'email' => 'email|unique:users|required|max:255',
                'first_name' => 'required|max:120',
                'password' => 'required|min:4',
        ]);

        $email = $request['email']; //from form name attribute
        $first_name = $request['first_name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->password = $password;

//        Log::info('hello there');
//        Log::info(User::where('email', 'test@yahoo.com')->first());

        $user->save();  //saves to the database automatically populating the timestamps

        //TODO: What does the login method do behind the seens?
        Auth::login($user);

        //TODO: Test this ---- why not just return view('dashboard')?
        return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request)
    {
        $this->validate($request, [
                'email2' => 'required',
                'password2' => 'required',
        ]);
        //Sweet!!
        if (Auth::attempt(['email' => $request['email2'], 'password' => $request['password2']])) {
            return redirect()->route('dashboard');
        }

        return redirect()->back();
    }

    public function getSignOut(Request $request)
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function getAccount()
    {
        return view('account', ['user' => Auth::user()]);
    }
    public function postEditAccount(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:120',
        ]);

        $user = Auth::user();
        $prev_first_name = $user->first_name;
        $user->first_name = $request['first_name'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['first_name'].'-'.$user->id.'.jpg';
        $prev_filename = $prev_first_name.'-'.$user->id.'.jpg';
        //check if there was a file submitted in the request
        if ($file) {
            //write the file to the storage/app folder per filesystems.php configuration
            Log::info($filename);
            // if ($prev_filename != $filename) {

            // }
            Storage::disk('local')->put($filename, File::get($file));
        } else {
            if ($prev_first_name != $request['first_name']) {
                //update the filename on disk
                Storage::disk('local')->move($prev_filename, $filename);
            }
        }

        return redirect()->route('account');
    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        //route is accessed by <img src= /> element so need to return a response
        //below creates a url for the img element
        return new Response($file, 200);
    }
}
