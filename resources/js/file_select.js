// ファイルが選択された場合
$('#select_file').on("change",function(){
    // 拡張子が許可されたものであるか確認
    File_Extension_Check(this.files[0].name);
});

// ドラッグオーバーされた場合
$('#select_file_div').on('dragover', function(e) {
    // ブラウザのデフォルトのイベント動作をキャンセル
    e.preventDefault();
    // クラスを追加
    $(this).addClass('dragover');
});

// ドラッグリーヴされた場合
$('#select_file_div').on('dragleave', function() {
    // クラスを削除
    $(this).removeClass('dragover');
});

// ドロップされた場合
$('#select_file_div').on('drop', function(e) {
    // クラスを削除
    $(this).removeClass('dragover');
    // ドロップされたファイル情報を取得
    var files = e.originalEvent.dataTransfer.files;
    // 拡張子が許可されたものであるか確認
    File_Extension_Check(files[0].name);
});

// 拡張子が許可されたものであるか確認
function File_Extension_Check(file_name){
    // 許可する拡張子を定義
    const allowedExtensions = ['.csv', '.xlsx'];
    // ファイルから拡張子を取得
    var fileExtension = file_name.slice(file_name.lastIndexOf('.')).toLowerCase();
    // 許可する拡張子に存在する拡張子であるか確認
    if(allowedExtensions.indexOf(fileExtension) === -1){
        // ファイル選択をクリアする
        $('#select_file_name').empty();
        $('#select_file').val(''); 
    }else{
        // 選択したファイル名を要素に出力
        $('#select_file_name').html(file_name);
    }
};