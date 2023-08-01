<!-- 受注一覧 -->
<div class="order_list_wrap flex flex-grow overflow-scroll">
    <div class="order_list_table_wrap mb-5 bg-white overflow-x-auto overflow-y-auto border border-gray-600">
        <table class="text-xs block whitespace-nowrap">
            <thead>
                <tr class="text-left text-white bg-gray-600 sticky top-0">
                    <th id="all_check" class="font-thin py-1 px-2"><i class="las la-check-square la-lg"></i></th>
                    <th class="font-thin py-1 px-2">詳細</th>
                    <th class="font-thin py-1 px-2">ステータス</th>
                    <th class="font-thin py-1 px-2">確認</th>
                    <th class="font-thin py-1 px-2">引当</th>
                    <th class="font-thin py-1 px-2">モール</th>
                    <th class="font-thin py-1 px-2">ショップ</th>
                    <th class="font-thin py-1 px-2">出荷倉庫</th>
                    <th class="font-thin py-1 px-2">複数倉庫受注</th>
                    <th class="font-thin py-1 px-2">運送会社</th>
                    <th class="font-thin py-1 px-2">配送方法</th>
                    <th class="font-thin py-1 px-2">伝票番号</th>
                    <th class="font-thin py-1 px-2">受注管理ID</th>
                    <th class="font-thin py-1 px-2">取込日</th>
                    <th class="font-thin py-1 px-2">取込時間</th>
                    <th class="font-thin py-1 px-2">受注番号</th>
                    <th class="font-thin py-1 px-2">受注日</th>
                    <th class="font-thin py-1 px-2">受注時間</th>
                    <th class="font-thin py-1 px-2">配送先名</th>
                    <th class="font-thin py-1 px-2">配送希望日</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($orders as $order)
                    <tr class="text-left hover:bg-theme-sub cursor-default">
                        <td class="py-1 px-2 border">
                            <input type="checkbox" name="chk[]" value="{{ $order->order_control_id }}" form="bulk_proc_form">
                        </td>
                        <td class="py-1 px-2 border text-center">
                            <a href="" class="text-center border border-blue-500 bg-blue-100 text-blue-500 text-xs px-2 py-1">詳細</a>
                        </td>
                        <td class="py-1 px-2 border text-center">{{ $order->order_status_id }}</td>
                        <td class="py-1 px-2 border text-center">@if($order->is_confirmed == 1) <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" style="width:20px;height:20px"></lord-icon> @endif</td>
                        <td class="py-1 px-2 border text-center">@if($order->is_allocated == 1) <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" style="width:20px;height:20px"></lord-icon> @endif</td>
                        <td class="border">
                            <img src="{{ asset($order->shop->mall->mall_image_path) }}" class="inline-block">
                        </td>
                        <td class="py-1 px-2 border">{{ $order->shop_id }}</td>
                        <td class="py-1 px-2 border">{{ is_null($order->shipping_base_id) ? '' : $order->base->base_name }}</td>
                        <td class="py-1 px-2 border text-center">@if($order->is_multi_base_order == 1) <lord-icon src="https://cdn.lordicon.com/egiwmiit.json" style="width:20px;height:20px"></lord-icon> @endif</td>
                        <td class="border">
                            
                        </td>
                        <td class="py-1 px-2 border">{{ $order->shipping_method_id }}</td>
                        <td class="py-1 px-2 border text-blue-500">
                        </td>
                        <td class="py-1 px-2 border">{{ $order->order_control_id }}</td>
                        <td class="py-1 px-2 border">{{ \Carbon\CarbonImmutable::parse($order->order_import_date)->isoFormat('Y年MM月DD日') }}</td>
                        <td class="py-1 px-2 border">{{ \Carbon\CarbonImmutable::parse($order->order_import_time)->isoFormat('HH時mm分ss秒') }}</td>
                        <td class="py-1 px-2 border">{{ $order->order_no }}</td>
                        <td class="py-1 px-2 border">{{ \Carbon\CarbonImmutable::parse($order->order_date)->isoFormat('Y年MM月DD日') }}</td>
                        <td class="py-1 px-2 border">{{ \Carbon\CarbonImmutable::parse($order->order_time)->isoFormat('HH時mm分ss秒') }}</td>
                        <td class="py-1 px-2 border">{{ $order->ship_name }}</td>
                        <td class="py-1 px-2 border">@if(!is_null($order->desired_delivery_date)) {{ \Carbon\CarbonImmutable::parse($order->desired_delivery_date)->isoFormat('Y年MM月DD日') }} @endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>