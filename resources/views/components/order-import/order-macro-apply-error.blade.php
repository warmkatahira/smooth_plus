<div class="bg-red-500 text-white p-10">
    <p class="mb-5 text-xl text-center">受注マクロの適用エラーがあります</p>
    @foreach(session('order_macro_apply_error') as $error)
        <p class="my-1 text-left"><i class="las la-exclamation-triangle mr-1 la-lg"></i>{{ $error }}</p>
    @endforeach
</div>