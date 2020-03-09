<?php


namespace App\Repositories;

use App\User;
use Laravel\Socialite\Two\User as UserOAuth;

class UserRepository
{
    public function getUserBySocId(UserOAuth $user, string $socName)
    {
        $userInSystem = User::query()
            ->where('social_id', $user->id)
            ->where('social_type', $socName)
            ->first();

        if (empty($userInSystem)) {
            $exist = User::where('email', $user->getEmail())->first();

            if (!empty($exist)) {
                $userInSystem = false;
            } else {
                $userInSystem = new User();
                $userInSystem->fill([
                    'name' => !empty($user->getName()) ? $user->getName() : '',
                    'email' => $user->getEmail(),
                    'password' => '',
                    'social_id' => !empty($user->getId()) ? $user->getId() : '',
                    'social_type' => $socName,
                    'avatar' => !empty($user->getAvatar()) ? $user->getAvatar() : ''
                ]);
                $userInSystem->save();
            }
        }

        return $userInSystem;
    }
}
