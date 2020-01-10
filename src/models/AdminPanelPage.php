<?php

namespace SmartContact\AdminPanel\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminPanelPage extends Model
{
    use SoftDeletes;

    protected $table = 'adminpanelpages';

    protected $fillable = ['name', 'normalizeName', 'config', 'queryData', 'url', 'pageId'];

    protected static $data = [
        'name' => [
             'type' => 'text',
             'view' => true
         ],
        'config' => [
             'type' => 'text',
             'view' => false
         ],
        'queryData' => [
             'type' => 'text',
             'view' => false
         ],
        'url' => [
             'type' => 'text',
             'view' => true
         ],
        'paged' => [
             'type' => 'text',
             'view' => true
         ]
    ];

    protected $casts = [
        'config' => 'array',
        'queryData' => 'array',
    ];

    public static function getColumns()
    {
        return collect(self::$data)
            ->filter(function($data) {
                return $data['view'];
            })
            ->keys()
            ->toArray();
    }

    public static function getData()
    {
        return collect(self::$data)
            ->filter(function($item) {
                return $item['view'];
            })
            ->toArray();
    }
}
