<!-- 検索条件 -->
<div class="bg-white border border-gray-600 shadow-md mr-3">
    <p class="text-sm bg-gray-600 text-white py-1 pl-2">検索条件</p>
    <form method="GET" action="{{ route($searchRoute) }}" class="m-0">
        <div class="flex flex-col px-3">
            <x-search.search-input id="search_order_no" label="受注番号" />
            <x-search.search-input id="search_order_control_id" label="受注管理ID" />
            <!-- 検索ボタン -->
            <button type="submit" class="start_loading text-sm text-center border border-blue-500 text-blue-500 bg-blue-100 py-2 mt-2 shadow-md">
                <i class="las la-search la-lg"></i>検索
            </button>
            <!-- リセットボタン -->
            <a href="{{ route($resetRoute) }}" class="start_loading text-sm text-center border border-black bg-gray-100 py-2 my-2 shadow-md">
                <i class="las la-eraser la-lg"></i>リセット
            </a>
        </div>
    </form>
</div>