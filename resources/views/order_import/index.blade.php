@vite(['resources/js/order_import/order_import.js'])

<x-app-layout>
    <x-page-header content="受注インポート" />
    <!-- バリデーションエラー -->
    <x-validation-error-msg />
    <!-- 受注データインポートフォーム -->
    <form method="POST" action="{{ route('order_import.import') }}" id="order_import_form" enctype="multipart/form-data" class="ml-5">
        @csrf
        <p class="border-l-4 border-theme-main pl-2 mb-2">受注データ選択</p>
        {{-- <div class="flex flex-col mb-5">
            <div class="flex select_file">
                <p class="text-sm whitespace-nowrap select_file_name pl-5 py-1.5 bg-white overflow-hidden" style="width: 500px"></p>
                <label class="text-sm whitespace-nowrap bg-gray-600 text-white inline-block text-center px-10 py-1.5 hover:cursor-pointer">
                    <i class="las la-file-alt la-lg"></i>データ選択
                    <input type="file" id="select_file" name="order_data" class="hidden">
                </label>
            </div>
        </div> --}}


        <div id="select_file_div" class="bg-white border border-dashed border-gray-500 relative mb-2">
            <input type="file" id="select_file" name="order_data" class="cursor-pointer block absolute inset-0 w-full h-full opacity-0 z-50">
            <div class="text-sm text-center py-5">
                ここにファイルをドロップ or 選択して下さい
            </div>
        </div>
        <p id="select_file_name" class="text-sm mb-3"></p>

        <div class="">
            <p class="border-l-4 border-theme-main pl-2 mb-2">受注インポート設定選択</p>
            <table class="text-xs whitespace-nowrap">
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
    <div class="flex mt-5 ml-5">
        <!-- 受注インポートエラー表示 -->
        @if(session('order_import_error'))
            <x-order-import.error title="受注インポートエラー" downloadRoute="order_import.import_error_download" :procDate="session('order_import_error')[0]['インポート日時']"/>
        @endif
    </div>
</x-app-layout>