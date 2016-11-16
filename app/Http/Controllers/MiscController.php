<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Validator;

class MiscController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function docs()
    {
        return view('vendor.l5-swagger.index');
    }

}
