<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return JsonResponse
     */
    public function redirect(): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver('google')->redirect()->getTargetUrl()
        ]);
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Factory|View
     */
    public function handleCallback(Request $request)
    {
        $socialiteUser = Socialite::driver('google')->stateless()->user();

        if (explode("@", $socialiteUser->email)[1] !== 'oa.edu.ua') {
            return "error";    //TODO
        }

        $user = $this->findOrCreateUser($socialiteUser);

        $this->guard()->login($user);

        return $this->sendLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        auth('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    /**
     * Finding or creating user with provided credentials.
     *
     * @param \Laravel\Socialite\Contracts\User $socialiteUser
     * @return User
     */
    protected function findOrCreateUser(\Laravel\Socialite\Contracts\User $socialiteUser): User
    {
        $existingUser = User::where('email', $socialiteUser->email)->first();
        if ($existingUser) {
            $existingUser->name = $socialiteUser->name;
            $existingUser->google_id = $socialiteUser->id;
            $existingUser->avatar = $socialiteUser->avatar;
            $existingUser->save();

            return $existingUser;
        } else {
            $newUser = new User;
            $newUser->name = $socialiteUser->name;
            $newUser->email = $socialiteUser->email;
            $newUser->google_id = $socialiteUser->id;
            $newUser->avatar = $socialiteUser->avatar;
            $newUser->role_id = 1;    // FIXME
            $newUser->save();

            return $newUser;
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return Factory|\Illuminate\Contracts\Foundation\Application|View
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return view('oauth.callback', [
            'payload' => ['success' => true],
        ]);
    }
}
