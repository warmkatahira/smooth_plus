@vite(['resources/js/order_import/order_import.js'])

<x-app-layout>
    <x-page-header content="受注インポート" />
    <!-- バリデーションエラー -->
    <x-validation-error-msg />
    <!-- 受注データインポートフォーム -->
    <form method="POST" action="{{ route('order_import.import') }}" id="order_import_form" enctype="multipart/form-data" class="ml-5">
        @csrf
        <p class="border-l-4 border-theme-main pl-2 mb-2">受注データ選択</p>
        <div class="flex flex-col mb-5">
            <div class="flex select_file">
                <p class="text-sm whitespace-nowrap select_file_name pl-5 py-1.5 bg-white overflow-hidden" style="width: 500px"></p>
                <label class="text-sm whitespace-nowrap bg-gray-600 text-white inline-block text-center px-10 py-1.5 hover:cursor-pointer">
                    <i class="las la-file-alt la-lg"></i>データ選択
                    <input type="file" id="select_file" name="order_data" class="hidden">
                </label>
            </div>
        </div>
        <div class="">
            <p class="border-l-4 border-theme-main pl-2 mb-2">受注インポート設定選択</p>
            <table class="text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-left text-white bg-gray-600">
                        <th class="font-thin py-1 px-2">選択</th>
                        <th class="font-thin py-1 px-2">設定名</th>
                        <th class="font-thin py-1 px-2">ショップ</th>
                        <th class="font-thin py-1 px-2">データ拡張子</th>
                        <th class="font-thin py-1 px-2">登録ユーザー</th>
                        <th class="font-thin py-1 px-2">更新日時</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($order_import_settings as $order_import_setting)
                        <tr class="text-left hover:bg-theme-sub cursor-default">
                            <td class="py-1 px-2 border text-center">
                                <input type="radio" name="order_import_setting_id" value="{{ $order_import_setting->order_import_setting_id }}">
                            </td>
                            <td class="py-1 px-2 border">{{ $order_import_setting->order_import_setting_name }}</td>
                            <td class="py-1 px-2 border">{{ $order_import_setting->shop->shop_name }}</td>
                            <td class="py-1 px-2 border">{{ $order_import_setting->data_extension }}</td>
                            <td class="py-1 px-2 border">{{ $order_import_setting->user->last_name.' '.$order_import_setting->user->first_name }}</td>
                            <td class="py-1 px-2 border">{{ \Carbon\CarbonImmutable::parse($order_import_setting->updated_at)->isoFormat('YYYY年MM月DD日 HH時mm分ss秒') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="button" id="order_import_enter" class="border border-theme-main bg-theme-sub hover:bg-theme-main text-center py-3 px-28 mt-5">取込開始</button>
    </form>
    <table class="ml-5 text-xs whitespace-nowrap">
        <thead>
            <tr class="text-left text-white bg-gray-600">
                <th class="font-thin py-1 px-2">受注番号</th>
                <th class="font-thin py-1 px-2">注文日</th>
                <th class="font-thin py-1 px-2">注文時間</th>
                <th class="font-thin py-1 px-2">購入者名</th>
                <th class="font-thin py-1 px-2">購入者郵便番号</th>
                <th class="font-thin py-1 px-2">購入者住所</th>
                <th class="font-thin py-1 px-2">購入者電話番号</th>
                <th class="font-thin py-1 px-2">配送先名</th>
                <th class="font-thin py-1 px-2">配送先郵便番号</th>
                <th class="font-thin py-1 px-2">配送先住所</th>
                <th class="font-thin py-1 px-2">配送先電話番号</th>
                <th class="font-thin py-1 px-2">配送希望日</th>
                <th class="font-thin py-1 px-2">配送希望時間</th>
                <th class="font-thin py-1 px-2">配送方法</th>
                <th class="font-thin py-1 px-2">支払方法</th>
                <th class="font-thin py-1 px-2">送料</th>
                <th class="font-thin py-1 px-2">その他費用</th>
                <th class="font-thin py-1 px-2">消費税</th>
                <th class="font-thin py-1 px-2">ポイント値引き</th>
                <th class="font-thin py-1 px-2">クーポン値引き</th>
                <th class="font-thin py-1 px-2">その他値引き</th>
                <th class="font-thin py-1 px-2">合計金額</th>
                <th class="font-thin py-1 px-2">請求金額</th>
                <th class="font-thin py-1 px-2">購入者メモ</th>
                <th class="font-thin py-1 px-2">商品コード</th>
                <th class="font-thin py-1 px-2">商品名</th>
                <th class="font-thin py-1 px-2">単価</th>
                <th class="font-thin py-1 px-2">購入数</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($order_imports as $order_import)
                <tr class="text-left hover:bg-theme-sub cursor-default">
                    <td class="py-1 px-2 border">{{ $order_import->order_no }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->order_date }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->order_time }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->buyer_name }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->buyer_zip_code }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->buyer_address }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->buyer_tel }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->ship_name }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->ship_zip_code }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->ship_address }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->ship_tel }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->desired_delivery_date }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->desired_delivery_time }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->shipping_method }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->payment_method }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->shipping_fee }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->other_fee }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->sales_tax }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->point_discount }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->coupon_discount }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->other_discount }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->total_amount }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->billing_amount }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->buyer_memo }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->order_item_code }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->order_item_name }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->unit_price }}</td>
                    <td class="py-1 px-2 border">{{ $order_import->order_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex mt-5 ml-5">
        <!-- インポートエラー表示 -->
        @if(session('order_import_error'))
            <x-order-import.error title="インポートエラー" downloadRoute="order_import.error_download" :procDate="session('order_import_error')[0]['インポート日時']"/>
        @endif
    </div>
</x-app-layout>