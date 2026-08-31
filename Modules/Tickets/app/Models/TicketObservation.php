<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Tickets\Database\Factories\TicketObservationFactory;

class TicketObservation extends Model
{
    use HasFactory;

    protected $table = 'tickets_observations';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ticket_id',
        'status_id',
        'user_id',
        'ticket_priority_id',
        'description'
    ];
}
