<?php

namespace Modules\Tickets\Models;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Services\Models\TicketServiceEntity;

// use Modules\Tickets\Database\Factories\TicketFactory;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uid',
        'ticket_type_id',
        'ticket_service_id',
        'ticket_priority_id',
        'user_id',
        'status_id',
        'title',
        'description'
    ];

    public function ticketService(): BelongsTo
    {
        return $this->belongsTo(TicketServiceEntity::class, 'ticket_service_id');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(TicketPriority::class, 'ticket_priority_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function url(): HasOne
    {
        return $this->hasOne(TicketUrl::class, 'ticket_id');
    }

    public function attachments(): HasMany {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }

    public function observation(): HasOne {
        return $this->hasOne(TicketObservation::class, 'ticket_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(
            User::class, 
            'tickets_users_assignations', 
            'ticket_id',                  
            'user_id'                
        )->withTimestamps();
    }

    // protected static function newFactory(): TicketFactory
    // {
    //     // return TicketFactory::new();
    // }
}
