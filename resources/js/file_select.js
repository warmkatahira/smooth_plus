// 選択したファイル名を表示する
$('.select_file input[type=file]').on("change",function(){
    let parent = $(this).closest(".select_file")
    parent.find(".select_file_name").html("")
    $.each($(this).prop('files'),function(index,file){
        parent.find(".select_file_name").append(file.name+"<br>")
    })
})