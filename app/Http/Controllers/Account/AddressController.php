<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Address\StoreRequest;
use App\UseCases\Account\Address\SaveAction;
use App\UseCases\Account\GetPrefecturesAction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function index()
    {
        // TODO: ログインユーザーの住所情報を取得
        return view('account.addresses.index');
    }

    public function create(GetPrefecturesAction $getPrefecturesAction)
    {
        $prefectures = $getPrefecturesAction();

        return view('account.addresses.create', ['prefectures' => $prefectures]);
    }

    public function store(StoreRequest $request, SaveAction $saveAction)
    {
        try {
            DB::beginTransaction();
            if (!$saveAction($request->all())) {
                DB::rollback();
                throw new Exception('ユーザー作成に失敗しました。');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception('エラーが発生しました。');
        }

        session()->flash('address_saved', true);

        return redirect()->route('account.addresses.index');
    }
}
