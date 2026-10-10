<?php

namespace Modules\Tags\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Tags\Database\Factories\LogActionsTagFactory;

class LogActionsTag extends Model
{
    use HasFactory;

     protected $table = 'logs_actions_tag';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tag_id',
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
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    /**
     * Relación con el usuario que generó la acción.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // protected static function newFactory(): LogActionsTagFactory
    // {
    //     // return LogActionsTagFactory::new();
    // }
}
