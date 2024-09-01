<?php

namespace App\UseCases\SignUp;

use App\Models\TmpRegistrationUser;
use Carbon\Carbon;

class GetTmpRegistrationUserAction
{
    public function __invoke(string $token): ?TmpRegistrationUser
    {
        $tmpRegistrationUser = TmpRegistrationUser::query()
            ->where('token', $token)
            ->where('expired_at', '>', Carbon::now())
            ->first();

        return $tmpRegistrationUser;
    }
}
