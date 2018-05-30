<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{


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

      return view('userDirectory')
        ->with('users', $users)
        ->with('groups', $groups);
    }

    public function userAdd(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'username' => 'required|string',
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'password' => 'required|string',
        'confirmPassword' => 'required|string',
        'group' => 'required|int',
        'logins' => 'required|int'
      ]);

      $username = $request['username'];
      $firstname = ucwords($request['firstname']);
      $lastname = ucwords($request['lastname']);
      $password = $request['password'];
      $confirmPassword = $request['confirmPassword'];
      $group = $request['group'];
      $logins = $request['logins'];

      // check username does not already exist
      $check = DB::table('users')->where('username', $username)->first();
      if (empty($check)) {}
      else {
        return back()->with('error', 'Username already exists.');
      }

      // check username string length
      if (strlen($username) > 40) {
        return back()->with('error', 'Username length exceeds 40 characters.');

      }

      // check firstname and lastname string lengths
      if (strlen($firstname) > 50 || strlen($lastname) > 50) {
        return back()->with('error', 'First and last names cannot exceed 50 characters.');
      }

      // check password rules
      $check = $this->checkPassword($password, $confirmPassword, $firstname, $lastname);
      if ($check !== true) {
        return back()->with('error', $check);
      }

      // hash password
      $password = sha1($password);

      // get group name
      $group = DB::table('groups')->where('id', $group)->pluck('name')->first();



      // insert into DB
      DB::table('users')->insert([
        'username' => $username,
        'firstname' => $firstname,
        'lastname' => $lastname,
      ]);

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

      DB::table('radusergroup')->insert([
        'username' => $username,
        'groupname' => $group
      ]);

      return redirect('/admin/users')->with('info', 'User added.');

    }

    public function showUserModify(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'id' => 'required|int'
      ]);

      $id = $request['id'];

      $user = $this->getUserInfo($id);

      $groups = DB::table('groups')->get();

      return view('userModify')
        ->with('user', $user)
        ->with('groups', $groups);
    }

    public function userChangePassword(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $origin = $request['origin'];
      $id = $request['id'];
      $password = $request['password'];
      $confirmPassword = $request['confirmPassword'];

      if ($password != $confirmPassword) {
        return back()->with('error', 'Passwords do not match.');
      }

      // password rules
      $user = DB::table('users')->where('id', $id)->first();

      $username = $user->username;
      $firstname = $user->firstname;
      $lastname = $user->lastname;

      $check = $this->checkPassword($password, $confirmPassword, $firstname, $lastname);
      if ($check !== true) {
        return back()->with('error', $check);
      }

      // hash password
      $password = sha1($password);

      // update db
      DB::table('radcheck')
        ->where('username', $username)
        ->where('attribute', 'SHA-Password')
        ->update([
          'value' => $password
        ]);

      return redirect($origin)->with('info', 'Password changed.');
    }

    public function userChangeLogins(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'id' => 'required|int'
      ]);

      $origin = $request['origin'];
      $id = $request['id'];
      $logins = $request['logins'];

      $user = DB::table('users')->where('id', $id)->first();
      $username = $user->username;

      DB::table('radcheck')->where('username', $username)
        ->where('attribute', 'Simultaneous-Use')
        ->update([
          'value' => $logins
        ]);

      return redirect($origin)->with('info', 'User logins updated.');

    }

    public function userChangeGroup(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'id' => 'required|int',
        'group' => 'required|int'
      ]);

      $origin = $request['origin'];
      $id = $request['id'];
      $groupId = $request['group'];

      $user = DB::table('users')->where('id', $id)->first();
      $group = DB::table('groups')->where('id', $groupId)->first();

      // delete all groups entries for user
      DB::table('radusergroup')->where('username', $user->username)->delete();

      // make new entries
      DB::table('radusergroup')->insert([
        'username' => $user->username,
        'groupname' => $group->name
      ]);

      return redirect($origin)->with('info', 'User group updated.');

    }

    public function userChangeName(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'id' => 'int|required',
        'origin' => 'string|required',
        'firstname' => 'string|required',
        'lastname' => 'string|required'
      ]);

      $origin = $request['origin'];
      $id = $request['id'];
      $firstname = ucfirst($request['firstname']);
      $lastname = ucfirst($request['lastname']);

      // update database
      DB::table('users')->where('id', $id)->update([
        'firstname' => $firstname,
        'lastname' => $lastname
      ]);

      return redirect($origin)->with('info', 'User names changed.');

    }

    public function userDelete(Request $request) {
      $check = $this->checkLoggedIn();
      if ($check == false) {
        session()->flush();
        return redirect('/');
      }

      $request->validate([
        'id' => 'int|required'
      ]);

      $id = $request['id'];
      $user = DB::table('users')->where('id', $id)->first();

      if (empty($user)) {
        session()->flush();
        return redirect('/');
      }

      DB::table('radcheck')->where('username', $user->username)->delete();
      DB::table('radusergroup')->where('username', $user->username)->delete();
      DB::table('users')->where('username', $user->username)->delete();

      return redirect('/admin/users')->with('info', 'User deleted.');

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

    private function getUserInfo($userId) {
      $user = DB::table('users')->where('id', $userId)->first();

      $username = $user->username;

      $logins = DB::table('radcheck')
        ->where('username', $username)
        ->where('attribute', 'Simultaneous-Use')
        ->pluck('value')->first();

      $group = DB::table('radusergroup')
        ->where('username', $username)
        ->pluck('groupname')->first();

      $user->fullname = $user->firstname . ' ' . $user->lastname;
      $user->logins = $logins;
      $user->group = $group;

      return $user;

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
