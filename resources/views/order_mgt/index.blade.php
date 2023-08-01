@vite(['resources/scss/order_mgt.scss'])

<x-app-layout>
    <x-page-header content="受注管理"/>
    <div class="flex flex-row items-start mb-2">
        <!-- 検索条件 -->
        <x-order-list.search searchRoute="order_mgt.index" resetRoute="order_mgt.index" />
        <!-- 受注一覧 -->
        <x-order-mgt.order-list :orders="$orders" />
    </div>
</x-app-layout>