<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Megatravel\SSO\LaravelSSOBroker;
use App\Models\User;

class SSOAutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $broker = new LaravelSSOBroker();
        $response = $broker->getUserInfo();
        $request->session()->put('umo', $response);
        // dd($request->session()->get('umo', ['session']));

        // If client is logged out in SSO server but still logged in broker.
        if (
            ! isset($response['user']) &&
            ! auth()->guest()
        ) {
            return $this->logout($request);
        }

        // If client is logged in SSO server and didn't logged in broker...
        if (
            isset($response['user']) &&
            (
                auth()->guest() ||
                auth()->user()->id_sso != $response['user']['sso']
            )
        ) {
            // ... we will authenticate our client.
            if ($response['user']['sso_active']['id'] == 1)
            {
                if ($response['platforms']['bloqueos']['active'] == 1)
                {
                    $user = User
                        ::where('id_sso', $response['user']['sso'])
                        ->first();

                    if ($user)
                    {
                        auth()->loginUsingId($user->id);
                    }
                }
            }
        }

        if (isset($response['session']))
        {
            $request->session()->put(
                'user_session_token',
                $response['session']['token']
            );
        }
        else
        {
            return redirect()->away(env('SSO_LOGIN_URL'));
        }

        return $next($request);
    }

    /**
     * Logging out authenticated user.
     * Need to make a page refresh because current page may be accessible only for authenticated users.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function logout(Request $request)
    {
        auth()->logout();
        return redirect($request->fullUrl());
    }
}
