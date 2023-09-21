@vite(['resources/scss/order_list.scss'])

<x-app-layout>
    <x-page-header content="受注管理"/>
    <div class="flex flex-row">
        @foreach($order_statuses_info as $key => $value)
            <div class="flex flex-col w-36 mr-10 text-center shadow-lg text-sm">
                <p class="bg-gray-600 text-white py-1 border-x border-t border-black">{{ $value }}</p>
                <a href="{{ route('order_mgt.index', ['order_status_id' => $key]) }}" class="py-1 border border-black text-blue-600 underline {{ session('order_status_id') == $key ? 'bg-theme-sub' : 'bg-white' }}">{{ OrderCountByOrderStatusFunc::count($key).'件' }}</a>
            </div>
        @endforeach
    </div>
    <div class="flex flex-row mt-2">
        <!-- ページネーション -->
        <x-pagenation :pagination="$orders" />
    </div>
    <div class="flex flex-row items-start mb-2">
        <!-- 検索条件 -->
        <x-order-search.search searchRoute="order_mgt.index" resetRoute="order_mgt.index" />
        <!-- 受注一覧 -->
        <x-order-mgt.order-list :orders="$orders" />
    </div>
</x-app-layout>