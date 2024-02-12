<?php

use App\Models\User;

function getUsers(){
    $users = User::orderBy('username')->get();

    return $users;
}

function getUserID(){
    return Session::get('user_id') ?? Auth::id();
}

function thisUser(){
    $user = User::find(getUserID());

    return $user;
}
