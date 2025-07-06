<?php

if (!function_exists('logout')) {
    function logout(): void {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}
