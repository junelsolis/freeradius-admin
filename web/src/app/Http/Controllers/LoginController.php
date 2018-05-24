<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LoginController extends Controller
{
  public function main() {
    return view('login');
  }

  public function login(Request $request) {
    // validate request
    $request->validate([
      'username' => 'required|string',
      'password' => 'required|string'
    ]);

    // assign variables
    $username = $request['username'];
    $password = $request['password'];

    // encode password in sha1
    $password = sha1($password);

    // attempt to find admin user in DB
    $admin = DB::table('admins')->where('username', $username)->first();

    // return with error if user not found
    if (empty($admin)) {
      return back()->with('error', 'Invalid credentials.');
    }

    // check password against database
    if ($password != $admin->password) {
      return back()->with('error', 'Invalid credentials.');
    }

    // if password is correct, store some session variables
    // then redirect to main admin view
    session(['loggedIn' => true]);
    session(['username' => $admin->username]);
    session(['id' => $admin->id]);
    session(['fullname' => $admin->firstname . ' ' . $admin->lastname]);

    return redirect('/admin/users');
  }
}
