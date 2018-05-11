<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    public function main() {
      return view('main');
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

      return redirect('/admin');

    }

    public function showDashboard() {
      $check = checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }
    }
    public function logout() {
      $check = checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      // clear session database
      session()->flush();

      // redirect to login page
      return redirect('/');
    }

    public function showChangePassword() {
      $check = checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      return view('changePassword');
    }
    public function changePassword(Request $request) {
      $request->validate([
        'password' => 'string|required',
        'newPassword' => 'string|required',
        'confirmNewPassword' => 'string|required'
      ]);

      // assign variables
      $password = sha1($request['password']);
      $newPassword = sha1($request['newPassword']);
      $confirmNewPassword = sha1($request['confirmNewPassword']);

      // retrieve user from DB
      $id = session('id');
      $admin = DB::table('admins')->where('id', $id)->first();

      // if not found, flush session and redirect to main page
      if (empty($admin)) {
        session()->flush();
        return redirect('/');
      }

      // compare password with DB
      if ($password != $admin->password) {
        return back()->with('error', 'Wrong password.');
      }

      // compare the new passwords
      if ($newPassword != $confirmNewPassword) {
        return back()->with('error', 'New passwords must match. Try again.');
      }

      // insert new password into DB
      DB::table('admins')
        ->where('id', $id)
        ->update(['password' => $newPassword]);

      return redirect('/admin')->with('msg', 'Your password has been changed.');
    }

    public function showUserAdd() {}
    public function userAdd() {}

    public function showUserModify() {}
    public function userModify() {}

    public function userDelete(Request $request) {}

    private function checkLoggedIn() {
      $loggedIn = session('loggedIn');
      $username = session('username');
      $id = session('id');

      if (empty($loggedIn) || empty($username) || empty($id)) {
        return false;
      }
      else {
        return true;
      }
    }

}
