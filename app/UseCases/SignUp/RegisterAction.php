<?php

namespace App\UseCases\SignUp;

use App\Mail\SignUp\EmailConfirmation;
use App\Models\TmpRegistrationUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterAction
{
    private const TOKEN_LENGTH = 44;

    public function __invoke(string $email): ?TmpRegistrationUser
    {
        while (true) {
            $token = Str::random(self::TOKEN_LENGTH);
            $exists = TmpRegistrationUser::query()
                ->where('token', $token)
                ->exists();

            if (!$exists) {
                $tmpRegistrationUser = TmpRegistrationUser::firstOrNew(['email' => $email]);
                $tmpRegistrationUser->token = $token;
                $tmpRegistrationUser->expired_at = Carbon::now()->addDay();
                $tmpRegistrationUser->save();

                Mail::to($tmpRegistrationUser)->send(new EmailConfirmation($tmpRegistrationUser));

                return $tmpRegistrationUser;
            }
        }

        return null;
    }
}
