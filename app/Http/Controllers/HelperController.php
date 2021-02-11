<?php


namespace App\Http\Controllers;


class HelperController extends Controller
{
    /**
     * Get refreshed CSRF
     *
     * @return string
     */
    public function refreshCSRF()
    {
        return csrf_token();
    }
}
