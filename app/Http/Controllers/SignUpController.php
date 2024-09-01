<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUp\RegisterRequest;
use App\Http\Requests\SignUp\StoreRequest;
use App\UseCases\Login\LoginAction;
use App\UseCases\SignUp\CreateUserAction;
use App\UseCases\SignUp\GetTmpRegistrationUserAction;
use App\UseCases\SignUp\RegisterAction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SignUpController extends Controller
{
    public function signup()
    {
        return view('account.signup');
    }

    public function register(RegisterRequest $request, RegisterAction $registerAction)
    {
        $tmpRegistrationUser = $registerAction($request->input('email'));
        if (!$tmpRegistrationUser) {
            throw new Exception('初回登録に失敗しました。');
        }

        return view('account.email-send-complete');
    }

    public function activate(
        string $token,
        GetTmpRegistrationUserAction $getTmpRegistrationUserAction,
    ) {
        $tmpRegistrationUser = $getTmpRegistrationUserAction($token);
        if (!$tmpRegistrationUser) {
            throw new Exception('認証に失敗しました。');
        }

        return view('account.activate', ['email' => $tmpRegistrationUser->email]);
    }

    public function store(
        StoreRequest $request,
        CreateUserAction $createUserAction,
        LoginAction $loginAction,
    ) {
        $input = $request->only(['name', 'password', 'email']);
        try {
            DB::beginTransaction();
            if (!$createUserAction($input)) {
                DB::rollback();
                throw new Exception('ユーザー作成に失敗しました。');
            }
            if (!$loginAction($input['email'], $input['password'])) {
                DB::rollback();
                throw new Exception('ログインに失敗しました。');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception('エラーが発生しました。');
        }

        return redirect()->route('account.addresses');
    }

    public function addresses() {}
}
