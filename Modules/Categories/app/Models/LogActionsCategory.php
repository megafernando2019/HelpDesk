<?php

namespace Modules\Categories\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Categories\Database\Factories\LogActionsCategoryFactory;

class LogActionsCategory extends Model
{
    use HasFactory;

    protected $table = 'logs_actions_category';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'resource_name',
        'section_name',
        'message',
        'values',
    ];

    // Casteo automático para la columna de tipo JSON
    protected $casts = [
        'values' => 'array',
    ];

    /**
     * Relación con la categoría afectada.
     */
    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    /**
     * Relación con el usuario que generó la acción.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // protected static function newFactory(): LogActionsCategoryFactory
    // {
    //     // return LogActionsCategoryFactory::new();
    // }
}
