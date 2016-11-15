<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Krucas\Settings\Facades\Settings;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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

    /**
     * @return View
     */
    public function index()
    {
        $user = Auth::user();

        $roles = $user->roles()->with('perms')->get();

        return view('home')->with(['roles' => $roles]);
    }

    /**
     * @return View
     */
    public function getSettings()
    {
        $allow_reg = Settings::get('enable-registration', false);
        $checked_allow_reg = ($allow_reg) ? 'checked' : '';
        $email_blacklist = join(',', Settings::get('excluded-email-domains', []));

        return view('settings', [
            'allow_reg' => (int)$allow_reg,
            'checked_allow_reg' => $checked_allow_reg,
            'email_blacklist' => $email_blacklist
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveSettings(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'allow_reg' => 'nullable|integer|min:0|max:1',
            'email_blacklist' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->exceptInput()->withErrors($validator);
        }

        Settings::set('enable-registration', array_key_exists('allow_reg', $data));
        Settings::set('excluded-email-domains', array_map('trim', explode(',', $data['email_blacklist'])));

        return redirect('/settings');

    }

}
