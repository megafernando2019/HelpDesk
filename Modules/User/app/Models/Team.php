<?php

namespace Modules\User\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Tickets\Models\Ticket;

// use Modules\User\Database\Factories\TeamFactory;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    /**
     * Obtiene los usuarios/integrantes asignados a este equipo.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')
                    ->withTimestamps();
    }
}
