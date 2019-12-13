<?php

/**
 * Created by PhpStorm.
 * User: ujjwal
 * Date: 12/4/17
 * Time: 1:39 PM
 */

namespace App\Services\Auth;


use App\Extensions\FirebaseUserProxyProvider;
use App\Http\Parsers\AuthHeaders;
use App\Models\Auth\User\FirebaseUser;
use App\Models\UserProfile;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\BadMethodCallException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use UnexpectedValueException;

class FirebaseGuard implements Guard
{
    protected $request;
    protected $provider;
    protected $user;

    public function __construct(FirebaseUserProxyProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->user = NULL;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        // Use dummy user for auth while in debug mode, make sure to disable this in production
        if (env('APP_DEBUG') && env('USE_DEMO_USER')) {
            $this->setUser(new FirebaseUser('Test User', 'ABZ-TU', 'testuser@example.com', ''));
            return true;
        }
        $publicKeyURL = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';
        $kids = json_decode(file_get_contents($publicKeyURL), true);

        $parser = new AuthHeaders();
        $token = $parser->parse($this->request);
        if ($token) {
            try {
                $decoded = JWT::decode($token, $kids, array('RS256'));

                if ($decoded->iss !== config('firebase.iss')) {
                    throw new \Exception;
                }
                $name = property_exists($decoded, 'name') ? $decoded->name : '';
                $email = property_exists($decoded, 'email') ? $decoded->email : '';
                $image = property_exists($decoded, 'picture') ? $decoded->picture : '';

                // fetch user associated with given firebase user in our database,
                // check if the user is blocked or not, if blocked return 417 error code
                $profile = UserProfile::where('user_id', $decoded->user_id)->first();
                if ($profile && $profile->is_blocked) {
                    // handle blocked user, this exception will be catched by HttpException below
                    abort(417);
                }

                $firebaseUser = new FirebaseUser($name, $decoded->user_id, $email, $image);
                $this->setUser($firebaseUser);
                return true;
            } catch (HttpException $ex) {
                // handle blocked user
                abort(417);
            } catch (\Exception $ex) {
                throw new BadRequestHttpException('token_invalid');
            }
        }
        throw new BadRequestHttpException('token_not_provided');
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return $this->user;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        throw new BadMethodCallException;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        throw new BadMethodCallException;
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }
}
