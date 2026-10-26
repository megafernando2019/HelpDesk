<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Departments\Models\Department;
use Modules\Tickets\Models\Ticket;
use Modules\User\app\Models\Team;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    //Se usara el uid para localizar el rol
    const SISTEMAS = 'ROL123WS';
    const JEFEEQUIPO = 'ROL241FF';
    const USUARIO = 'ROL720QW';
    const ENCARGADO = 'ROL517AS';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_sso',
        'first_name',
        'last_name',
        'email',
        'status_id',
        'role_id',
        'department_id',
        'user_type_id',
        'password',
        'active',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relations
     */

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
                    ->withTimestamps();
    }

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'tickets_users_assignations')
                    ->withTimestamps();
    }

    /**
     * Tickets asignados al usuario que se encuentran en estatus 2 o 3
     */
    public function active_assigned_tickets()
    {
        return $this->belongsToMany(
            Ticket::class, 
            'tickets_users_assignations', 
            'user_id', 
            'ticket_id'
        )
        ->select('tickets.*')
        ->whereIn('tickets.status_id', [2, 3])
        ->withTimestamps();
    }

    /**
     * Tickets del integrante asignados
     */
    public function tickets_assing_team()
    {
       return $this->belongsToMany(
         Ticket::class, 
        'tickets_users_assignations', 
        'user_id',
        'ticket_id' 
       );
    }
}
