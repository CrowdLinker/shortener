<?php

/**
 * Password Exists Validation
 */
Validator::extend('passcheck', function($attr, $value, $params) {
    if(\Illuminate\Support\Facades\Hash::check($value,Auth::user()->password))
    {
        return true;
    }
    return false;
});