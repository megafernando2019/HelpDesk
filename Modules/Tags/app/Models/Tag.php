<?php

namespace Modules\Tags\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Tags\Database\Factories\TagFactory;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tickets_tags';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'uid',
        'description',
        'color',
        'created_by',
        'status'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

     public function logs_actions()
    {
        return $this->hasMany(LogActionsTag::class, 'tag_id');
    }

}
