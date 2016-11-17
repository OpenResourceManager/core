<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Models\API\Account;
use App\Http\Models\API\Course;
use App\Http\Models\API\Email;
use App\Http\Models\API\MobilePhone;
use App\Models\History\History;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        $secret = $user->api_secret;
        $accountCount = Account::count();
        $courseCount = Course::count();
        $mobilePhoneCount = MobilePhone::where('verified', true)->count();
        $emailCount = Email::where('verified', true)->count();
        $apiQueries = History::where('user_id', $user->id)->count();

        return view('frontend.user.dashboard')
            ->with('secret', strtolower($secret))
            ->with('accountCount', strval($accountCount))
            ->with('courseCount', strval($courseCount))
            ->with('mobilePhoneCount', strval($mobilePhoneCount))
            ->with('emailCount', strval($emailCount))
            ->with('apiQueries', strval($apiQueries));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function macros()
    {
        return view('frontend.macros');
    }

    /**
     * @return View
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Generates a new api secret for user
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function newSecret()
    {
        $user = auth()->user();
        $user->newSecret();
        return redirect('/home');
    }
}
