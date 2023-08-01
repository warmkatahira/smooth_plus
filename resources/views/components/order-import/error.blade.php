<div id="import_error_div" class="bg-red-500 text-white text-center w-96">
    <div class="flex justify-end">
        <button type="button" id="import_error_delete" class="pt-1 pr-1 cursor-pointer"><i class="las la-window-close la-lg"></i></button>
    </div>
    <p class="text-center py-2">{{ $title }}</p>
    <p class="pb-2">{{ '処理日時：'.\Carbon\Carbon::parse($procDate)->isoFormat('Y年MM月DD日 HH時mm分ss秒') }}</p>
    <div class="px-10 py-5">
        <a href="{{ route($downloadRoute) }}" class="bg-pink-200 text-black w-full block py-5">ダウンロード</a>
    </div>
</div>