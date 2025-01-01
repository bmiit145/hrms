<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{


    public function login_form()
    {
        return view('admin_layout.Login');
    }

    public function Authenticate(Request $request)
    {
        // Validate the incoming request
        $validator = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator) {
            // Attempt to authenticate the user
            if (Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ], $request->get('remember'))) {

                // Get the authenticated admin user
                $admin = Auth::guard('admin')->user();

                // Check if the account is locked
                if ($admin->is_lock == 0) {
                    // Check if the account is deleted
                    if ($admin->is_deleted == 1) {
                        // Log out the user and redirect with error message if deleted
                        Auth::guard('admin')->logout();
                        return redirect()->route('login')->with('error', 'Your account has been deleted.');
                    }

                    // Redirect based on user role
                    switch ($admin->role) {
                        case '0':
                            return redirect()->route('admin.dahsboard');
                        case '1':
                            return redirect()->route('teamhead.dahsboard');
                        case '2':
                            return redirect()->route('user.dahsboard');
                        case '3':
                            return redirect()->route('hr.dahsboard');
                        default:
                            // Handle any other roles if needed
                            return redirect()->route('login')->with('error', 'Invalid user role.');
                    }
                } else {
                    // Logout if the account is locked
                    Auth::guard('admin')->logout();
                    return redirect()->route('login')->with('error_auth', 'This ID is Deactivated.');
                }
            } else {
                // If login attempt failed, return error
                return redirect()->route('login')->with('error', 'Email/Password is incorrect');
            }
        } else {
            // If validation fails, return errors
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
