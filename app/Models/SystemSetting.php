<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;
    // オートインクリメント無効化
    public $incrementing = false;
    // 操作可能なカラムを定義
    protected $fillable = [
        'stock_allocated_use_column_1',
        'stock_allocated_use_column_2',
        'stock_allocated_use_column_3',
        'rito_shipping_method_id',
    ];
}
