<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get latest users
        $data['users'] = User::latest()->get();

        // redirect to users index view with data
        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // redirect to create user view
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'role' => 'required',
            'email'=>'required|unique:users,email,NULL,id,deleted_at,NULL|email:rfc,filter',
            'name'=>'required',
            'username'=>'required|without_spaces|unique:users,username,NULL,id,deleted_at,NULL',
            'password'=>'required|without_spaces|min:8',
        ]);

        // collect data request
        $data = $request->except('_method', '_token');

        if($request->get('password') != ''){
            $data['password'] = bcrypt($request->get('password'));
        }

        // create user
        $user = User::create($data);

        // redirect to users index view with success message
        return redirect('admin/users')->with('success', 'User Saved!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get user by id
        $result['user'] = User::find($id);

        // redirect to edit user view with data
        return view('users.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation
        $request->validate([
            'role' => 'required',
            'email'=>'required|unique:users,email,'.$id.',id,deleted_at,NULL|email:rfc,filter',
            'name'=>'required',
            'username'=>'required|without_spaces|unique:users,username,'.$id.',id,deleted_at,NULL',
            'password'=>'nullable|without_spaces|min:8',
        ]);

        // collect data request  except password
        $data = $request->except('_method', '_token', 'password');

        // if password not empty
        if($request->get('password') != ''){
            // hash password and collect to data
            $data['password'] = bcrypt($request->get('password'));
        }

        // update user by id
        $user = User::find($id)->update($data);

        // redirect to users index view with success message
        return redirect('admin/users')->with('success', 'User Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete user by id
        $user = User::find($id)->delete();

        // redirect to users index view with success message
        return redirect()->back()->with('success', 'User Removed!');
    }
}
