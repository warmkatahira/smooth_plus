<!-- ページネーション -->
<div class="ml-auto">
    @if($pagination)
        <div class="">
            {{ $pagination->appends(request()->input())->links() }}
        </div>
    @endif
</div>