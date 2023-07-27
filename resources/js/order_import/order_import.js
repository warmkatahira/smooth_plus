import start_loading from '../loading';

// 取込ボタンが押下されたら
$('#order_import_enter').on("click",function(){
    const select_file = document.getElementById('select_file');
    try {
        // データが選択されているか
        if (select_file.value == '') {
            throw new Error('データが選択されていません。');
        }
        // ラジオボタンの要素を取得
        const radio_btn = $('input[type="radio"]');
        // カウント用の変数をセット
        let count = 0;
        // チェックされているラジオボタンの数を数える
        radio_btn.each(function() {
        if($(this).prop('checked')) {
            count++;
        }
        });
        // 受注インポート設定が1つだけ選択されているか
        if(count != 1){
            throw new Error('受注データインポート設定を選択して下さい。');
        }
        // 処理を実行するか確認
        const result = window.confirm("受注をインポートしますか？");
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            start_loading();
            $("#order_import_form").submit();
        }
    } catch (e) {
        alert(e.message);
    }
});