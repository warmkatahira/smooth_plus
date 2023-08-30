<?php

namespace App\Services\OrderImport;

use Symfony\Component\HttpFoundation\StreamedResponse;

class ErrorDownloadService
{
    // ダウンロードする情報を取得
    public function getDownloadItem()
    {
        $response = new StreamedResponse(function () {
            // セッションから配列を取得
            $data = session('order_import_error')[0]['エラー情報'];
            // チャンクサイズを指定
            $chunkSize = 500;
            // ハンドルを取得
            $handle = fopen('php://output', 'wb');
            // BOMを書き込む
            fwrite($handle, "\xEF\xBB\xBF");
            // ヘッダー行を書き込む
            $headerRow = [
                '受注番号',
                '配送先名',
            ];
            fputcsv($handle, $headerRow);
            // 配列をチャンク処理
            $chunks = collect($data)->chunk($chunkSize);
            // チャンクの数だけループ処理
            foreach($chunks as $chunk){
                // 1チャンク内のデータをループ処理
                foreach($chunk as $item){
                    $row = [
                        $item->order_no,
                        $item->ship_name,
                    ];
                    // 1行分を書き込む
                    fputcsv($handle, $row);
                }
            }
            // ファイルを閉じる
            fclose($handle);
        });
        return $response;
    }
}