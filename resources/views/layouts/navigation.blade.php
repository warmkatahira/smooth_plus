@vite(['resources/scss/navigation.scss'])

<nav id="navigation">
    <a href="{{ route('top.index') }}" class="logo">smooth+</a>
    <ul class="links flex">
        <li class="dropdown"><a href="#" class="trigger-drop">受注</a>
            <ul class="drop">
                <li><a href="{{ route('order_import.index') }}">受注インポート</a></li>
                <li><a href="">受注管理</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#" class="trigger-drop">出荷</a>
            <ul class="drop">
                <li><a href="">出荷管理</a></li>
                <li><a href="">出荷検品</a></li>
                <li><a href="">出荷履歴</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#" class="trigger-drop">商品</a>
            <ul class="drop">
                <li><a href="">商品マスタ</a></li>
                <li><a href="">商品アップロード</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#" class="trigger-drop">在庫</a>
            <ul class="drop">
                <li><a href="">在庫</a></li>
                <li><a href="">入庫予定</a></li>
                <li><a href="">入庫</a></li>
                <li><a href="">出庫</a></li>
                <li><a href="">在庫操作履歴</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#" class="trigger-drop">設定</a>
            <ul class="drop">
                <li><a href="">ショップ</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#" class="trigger-drop">マスタ</a>
            <ul class="drop">
                <li><a href="">倉庫</a></li>
            </ul>
        </li>
        @can('systemFuncIsAvailable')
            <li class="dropdown"><a href="" class="trigger-drop">システム</a>
            </li>
        @endcan
    </ul>
    <ul class="user_info">
        <li class="dropdown"><a href="#" class="trigger-drop">{{ Auth::user()->last_name.' '.Auth::user()->first_name.'さん' }}</a>
            <ul class="drop">
                <li><a href="">アカウント</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="">ログアウト</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- アラート表示 -->
<x-alert/>