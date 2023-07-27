<?php

namespace App\Http\Controllers\OrderImport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderImportSetting;
use App\Http\Requests\OrderImport\OrderImportRequest;

class OrderImportController extends Controller
{
    public function index()
    {
        // 受注インポート設定を全て取得
        $order_import_settings = OrderImportSetting::getAll()->get();
        return view('order_import.index')->with([
            'order_import_settings' => $order_import_settings,
        ]);
    }

    public function import(OrderImportRequest $request)
    {
        
    }
}
