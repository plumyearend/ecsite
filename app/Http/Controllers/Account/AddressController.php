<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Address\StoreRequest;
use App\Models\Address;
use App\UseCases\Account\Address\GetListAction;
use App\UseCases\Account\Address\SaveAction;
use App\UseCases\Account\GetPrefecturesAction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function index(
        GetListAction $getListAction,
        GetPrefecturesAction $getPrefecturesAction,
    ) {
        $addresses = $getListAction();
        $prefectures = $getPrefecturesAction();
        $data = [
            'addresses' => $addresses,
            'prefectures' => $prefectures,
        ];

        return view('account.addresses.index', $data);
    }

    public function create(GetPrefecturesAction $getPrefecturesAction)
    {
        $prefectures = $getPrefecturesAction();
        $data = [
            'prefectures' => $prefectures,
            'address' => null,
        ];

        return view('account.addresses.create', $data);
    }

    public function store(StoreRequest $request, SaveAction $saveAction)
    {
        try {
            DB::beginTransaction();
            if (!$saveAction($request->all())) {
                DB::rollback();
                throw new Exception('お届け先作成に失敗しました。');
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

    public function edit(
        Address $address,
        GetPrefecturesAction $getPrefecturesAction,
    ) {
        $prefectures = $getPrefecturesAction();
        $data = [
            'prefectures' => $prefectures,
            'address' => $address,
        ];

        return view('account.addresses.create', $data);
    }

    public function update(
        Address $address,
        StoreRequest $request,
        SaveAction $saveAction,
    ) {
        try {
            DB::beginTransaction();
            if (!$saveAction($request->all(), $address)) {
                DB::rollback();
                throw new Exception('お届け先の更新に失敗しました。');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception('エラーが発生しました。');
        }

        session()->flash('address_updated', true);

        return redirect()->route('account.addresses.index');
    }
}
