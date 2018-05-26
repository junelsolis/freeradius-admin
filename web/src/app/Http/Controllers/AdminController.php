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

    public function showUsers() {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $users = DB::table('users')->orderBy('lastname')->get();
      $users = $this->getUsers($users);

      $groups = DB::table('groups')->orderby('name')->get();

      $users = $this->collectUsersAlpha($users);

      return view('users')
        ->with('users', $users)
        ->with('groups', $groups);
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

      return redirect('/admin/users')->with('info', 'User added to database.');
    }


    public function showAdmins() {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $admins = DB::table('admins')->orderBy('lastname')->get();

      return view('showAdmins')->with('admins', $admins);
    }

    public function adminAdd(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $username = $request['username'];
      $firstname = ucwords($request['firstname']);
      $lastname = ucwords($request['lastname']);
      $password = $request['password'];
      $confirmPassword = $request['confirmPassword'];

      $admins = DB::table('admins')->orderBy('lastname')->get();

      // check that username does not already exist
      $exists = $admins->where('username', $username)->first();
      if (empty($exists) == false) {
        return back()->with('error', 'Username already exists.');
      }

      // check that name does not already exist
      $fnameExists = $admins->where('firstname', $firstname)->first();
      $lnameExists = $admins->where('lastname', $lastname)->first();

      if (empty($fnameExists) == false && empty($lnameExists) == false) {
        return back()->with('error', 'Administrator already exists.');
      }

      // check passwords are the same
      if ($password != $confirmPassword) {
        return back()->with('error', 'The passwords do not match. Please try again.');
      }

      // enforce password rules
      $checkPassword = $this->checkPassword($password, $confirmPassword, $firstname, $lastname);
      if ($checkPassword !== true) {
        return back()->with('error', $checkPassword);
      }

      // encode password
      $password = sha1($password);

      // enter into database
      DB::table('admins')->insert([
        'username' => $username,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'password' => $password
      ]);

      // return to admins view
      return redirect('/admin/show-admins')
        ->with('info', 'Successfully added administrator.');

    }

    public function adminDelete(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'id' => 'int|required'
      ]);

      $id = $request['id'];

      // delete from db
      DB::table('admins')
        ->where('id', $id)
        ->delete();

      return redirect('/admin/show-admins')->with('info', 'Administrator deleted.');
    }

    public function adminModify(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $id = $request['id'];
      $password = $request['currentPassword'];
      $newPassword = $request['newPassword'];
      $confirmPassword = $request['confirmPassword'];

      // get admin object
      $admin = DB::table('admins')->where('id', $id)->first();

      if (empty($admin)) {
        session()->flush();
        return redirect('/');
      }

      // check that current password is correct
      if (sha1($password) != $admin->password) {
        return back()->with('error', 'Incorrect password.');
      }

      // check that new passwords match
      if ($newPassword != $confirmPassword) {
        return back()->with('error', 'New passwords do not match.');
      }

      // enforce password rules
      $checkPassword = $this->checkPassword($newPassword, $confirmPassword, $admin->firstname, $admin->lastname);

      if ($checkPassword !== true) {
        return back()->with('error', $checkPassword);
      }

      // encode new password
      $newPassword = sha1($newPassword);

      // modify db
      DB::table('admins')->where('id', $id)
        ->update([
          'password' => $newPassword
        ]);

      // return to view
      return redirect('/admin/show-admins')->with('info', 'Administrator was modified.');

    }

    public function showGroups() {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $groups = DB::table('groups')->orderBy('name')->get();

      foreach ($groups as $group) {
        $users = $this->getUsersInGroup($group);
        $group->usersInGroup = count($users);
      }

      return view('groups')->with('groups', $groups);
    }

    public function groupAdd(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'name' => 'string|required',
        'description' => 'string|nullable'
      ]);

      $name = $request['name'];
      $description = $request['description'];

      if (strlen($name) > 30) {
        return back()->with('error', 'Group name cannot be more than 30 characters.');
      }

      if (strlen($description) > 80) {
        return back()->with('error', 'Description cannot be more than 80 characters.');
      }

      // insert into db
      DB::table('groups')->insert([
        'name' => $name,
        'description' => $description
      ]);

      return redirect('/admin/groups')->with('info', 'Group added.');

    }

    public function groupModify(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'id' => 'int|required',
        'groupname' => 'string',
        'description' => 'string',
      ]);

      $id = $request['id'];
      $groupname = $request['groupname'];
      $description = $request['description'];

      if (empty($id)) {
        session()->flush();
        return redirect('/');
      }

      // sanitize string lengths
      if (strlen($groupname) > 20) {
        return back()->with('error', 'Group name cannot be longer than 20 characters.');
      }

      if (strlen($description) > 50) {
        return back()->with('error', 'Group description cannot be longer than 50 characters.');
      }



      if (empty($groupname)) {

      } else {
        DB::table('groups')->where('id', $id)
          ->update([
            'groupname', $groupname
          ]);
      }

      if (empty($description)) {}
      else {
        DB::table('groups')->where('id', $id)
          ->update([
            'description', $groupname
          ]);
      }
    }

    public function groupDelete(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $id = $request['id'];

      if (empty($id)) {
        session()->flush();
        return redirect('/');
      }

      // check if there are any users assigned
      $group = DB::table('groups')->where('id', $id)->first();
      $usersInGroup = $this->getUsersInGroup($group);

      if ($usersInGroup->count() > 0) {
        return back()->with('error', 'Group has assigned users.');
      }

      DB::table('groups')->where('id', $id)->delete();

      return redirect('/admin/groups')->with('info', 'Group deleted.');
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

    private function deleteUsers($ids) {

      // get collection of usernames
      $usernames = DB::table('users')->whereIn('id', $ids)->pluck('username');

      // delete from radusergroup
      DB::table('radusergroup')->whereIn('username', $usernames)->delete();

      // delete from radcheck
      DB::table('radcheck')->whereIn('username', $usernames)->delete();

      // delete from users
      DB::table('users')->whereIn('username', $usernames)->delete();

      return count($usernames);

    }

    private function getUsersInGroup($group) {
      $users = DB::table('radusergroup')->where('groupname', $group->name)->get();

      return $users;
    }

    private function collectUsersAlpha($users) {
      $letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

      $collection = collect();

      foreach ($letters as $letter) {
        $userCollection = collect();

        foreach ($users as $user) {
          if (stripos($user->lastname, $letter) === 0) {
            $userCollection->push($user);
          }
        }

        if ($userCollection->isEmpty() === true) {

        } else {
          $object = new \stdClass();
          $object->letter = $letter;
          $object->users = $userCollection;

          $collection->push($object);

        }
      }

      return $collection;
    }
}
