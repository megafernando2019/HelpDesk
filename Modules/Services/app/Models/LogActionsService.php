<?php

namespace Modules\Services\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Services\Database\Factories\LogActionsServiceFactory;

class LogActionsService extends Model
{
    use HasFactory;

    protected $table = 'log_actions_services';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_id',
        'user_id',
        'resource_name',
        'section_name',
        'message',
        'values',
    ];

    protected $casts = [
        'values' => 'array',
    ];

    // protected static function newFactory(): LogActionsServiceFactory
    // {
    //     // return LogActionsServiceFactory::new();
    // }
}
