<?php

use App\Models\User;

function getUsers(){
    // Get all users order by username
    $users = User::orderBy('username')->get();

    // return users
    return $users;
}

function getUserID(){
    // Get user id from session or auth
    return Session::get('user_id') ?? Auth::id();
}

function thisUser(){
    // Get user now
    $user = User::find(getUserID());

    // return user
    return $user;
}
