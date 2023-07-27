<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mall extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'mall_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'mall_name',
        'mall_image_path',
    ];
}
