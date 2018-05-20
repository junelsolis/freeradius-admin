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
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      return view('dashboard');

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

    public function userAdd(Request $request) {
      $check = checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      // validate request
      $request->validate([
        'firstname' => 'string|required',
        'lastname' => 'string|required',
        'username' => 'string|required',
        'password' => 'string|required',
        'confirmPassword' => 'string|required',
        'group' => 'string|required',
        'logins' => 'int|required',
      ]);

      // assign variables
      $firstname = ucfirst($request['firstname']);
      $lastname = ucfirst($request['lastname']);
      $username = $request['username'];
      $password = $request['password'];
      $confirmPassword = $request['confirmPassword'];
      $group = lcwords($request['group']);
      $logins = $request['logins'];

      // check that this username does not already exist
      $exists = DB::table('users')->where('username', $username)->first();
      if (!empty($exists)) {
        return back()->with('error', 'User already exists. Please choose another username.');
      }

      // make sure passwords are the same
      if ($password != $confirmPassword) {
        return back()->with('error', 'Passwords must be the same.');
      }

      // make sure minimum of 8 character password
      if (strlen($password) < 8) {
        return back()->with('error', 'Password must have a minimum of 8 characters.');
      }

      // encode password
      $password = sha1($password);

      // if all checks passed, insert new user into database
      DB::table('users')->insert([
        'username' => $username,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'password' => $password
      ]);

      // insert group data
      DB::table('radusergroup')->insert([
        'username' => $username,
        'groupname' => $group,
      ]);

      // insert radcheck data
      DB::table('radcheck')->insert([
        'username' => $username,
        'attribute' => 'SHA-Password',
        'op' => ':=',
        'value' => $password
      ]);

      DB::table('radcheck')->insert([
        'username' => $username,
        'attribute' => 'Simultaneous-Use',
        'op' => ':=',
        'value' => $logins
      ]);

      return redirect('/admin')->with('msg', 'User added to database.');
    }

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
