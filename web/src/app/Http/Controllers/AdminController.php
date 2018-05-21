<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{

    public function showDashboard() {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      // get current user's name
      $userFullname = $this->getCurrentUserFullname();

      // fetch all users from db
      // $users = DB::table('users')->orderBy('lastname')->get();
      // $users = $this->getUsers($users);

      return view('dashboard')
        ->with('userFullname', $userFullname);

    }

    public function logout() {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      // clear session database
      session()->flush();

      // redirect to login page
      return redirect('/');
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

    public function showUserAdd() {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $userFullname = $this->getCurrentUserFullname();

      // fetch from groups db
      $groups = DB::table('groups')->orderBy('name')->get();

      return view('userAdd')
        ->with('groups', $groups)
        ->with('userFullname', $userFullname);
    }

    public function userAdd(Request $request) {
      $check = $this->checkLoggedIn();
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
        'group' => 'int|required',
        'logins' => 'int|required',
      ]);

      // assign variables
      $firstname = ucfirst($request['firstname']);
      $lastname = ucfirst($request['lastname']);
      $username = $request['username'];
      $password = $request['password'];
      $confirmPassword = $request['confirmPassword'];
      $group = $request['group'];
      $logins = $request['logins'];


      // check that this username does not already exist
      $exists = DB::table('users')->where('username', $username)->first();
      if (!empty($exists)) {
        return back()->with('error', 'Username already exists. Please choose another username.');
      }

      // check first and lastnames do not exist
      $namesExist = DB::table('users')->where('firstname', $firstname)->where('lastname', $lastname)->first();
      if (!empty($namesExist)) {
        return back()->with('error', 'User already exists. Please modify the user instead.');
      }

      // run password checks
      $checkPassword = $this->checkPassword($password, $confirmPassword, $firstname, $lastname);
      if ($checkPassword !== TRUE) {
        return back()->with('error', $checkPassword);
      }

      // encode password
      $password = sha1($password);

      // if all checks passed, insert new user into database
      DB::table('users')->insert([
        'username' => $username,
        'firstname' => $firstname,
        'lastname' => $lastname,
      ]);

      // insert group data
      $groupName = DB::table('groups')->where('id', $group)->pluck('name')->first();
      DB::table('radusergroup')->insert([
        'username' => $username,
        'groupname' => $groupName,
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

      return redirect('/admin/add-user')->with('info', 'User added to database.');
    }

    public function showUserList() {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      // get all users
      $users = DB::table('users')->orderBy('lastname')->get();
      $users = $this->getUsers($users);

      return view('userList')
        ->with('users', $users);

    }

    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    // PRIVATE FUNCTIONS
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
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

    private function checkPassword($password, $confirmPassword, $fname, $lname) {

      // convert names to lowercase strings
      $fname = strtolower($fname);
      $lname = strtolower($lname);

      // make sure passwords are the same
      if ($password != $confirmPassword) {
        return 'Passwords do not match.';
      }

      // make sure minimum of 10 character password
      if (strlen($password) < 10) {
        return 'Password must have a minimum of 10 characters.';
      }

      // no firstname in password
      if (stripos($password, $fname) !== false) {
        return 'First and last names cannot be included in the password.';
      }

      // no lastname in password
      if (stripos($password, $lname) !== false) {
        return 'First and last names cannot be included in the password.';
      }

      return true;

    }

    private function getUsers($users) {

      $radcheck = DB::table('radcheck')->where('attribute', 'Simultaneous-Use')->get();
      $radusergroup = DB::table('radusergroup')->get();

      foreach ($users as $user) {

        // allowed logins
        $logins = $radcheck->where('username', $user->username)->pluck('value')->first();
        $user->logins = $logins;

        // user group
        $group = $radusergroup->where('username', $user->username)->pluck('groupname')->first();
        $user->group = $group;

        // concatenate fullname
        $user->fullname = $user->firstname . ' ' . $user->lastname;
      }

      return $users;
    }

    private function getCurrentUserFullname() {
      $id = session('id');
      $user = DB::table('admins')->where('id', $id)->first();

      if (empty($user)) {
        session()->flush();
        return redirect('/');
      }

      $firstname = $user->firstname;
      $lastname = $user->lastname;

      return $firstname . ' ' . $lastname;
    }

}
