<?php

namespace Nodesol\Lightcms\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login(Request $request)
    {
        if (auth(config('lightcms.guard'))->check()) {
            return redirect()->route('lightcms-admin-dashboard');
        }
        $data = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if (auth(config('lightcms.guard'))->attempt($data)) {
            return redirect()->route('lightcms-admin-dashboard');
        } else {
            return redirect()->route('lightcms-admin-login');
        }
    }

    public function logout()
    {
        if (auth(config('lightcms.guard'))->check()) {
            auth(config('lightcms.guard'))->logout();
        }

        return redirect()->route('lightcms-admin-login');
    }
}
