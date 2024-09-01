<?php

namespace App\UseCases\SignUp;

use App\Models\TmpRegistrationUser;
use App\Models\User;

class CreateUserAction
{
    public function __invoke(array $data): ?User
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        if (!$user->save()) {
            return null;
        }

        TmpRegistrationUser::query()
            ->where('email', $data['email'])
            ->delete();

        return $user;
    }
}
