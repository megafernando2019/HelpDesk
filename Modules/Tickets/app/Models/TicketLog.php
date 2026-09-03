<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Tickets\Database\Factories\TicketLogFactory;

class TicketLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ticket_id',
        'user_id',
        'resource_name',
        'section_name',
        'message',
        'event_type',
        'values'
    ];

    public function ticket(): BelongsTo
    {
      return $this->belongsTo(Ticket::class, 'ticket_id');
    }

}
