<?php

namespace App;

use App\Models\User;

/**
 * Class Auth
 *
 * @package App
 * @method static User|null user();
 * @method static void setUser(User $user)
 * @method static void login(User $user, bool $remember = false)
 * @method static User loginUsingId(mixed $id, bool $remember = false)
 */
class Auth extends \Illuminate\Support\Facades\Auth
{

}
