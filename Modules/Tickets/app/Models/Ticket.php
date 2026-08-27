<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    // protected static function newFactory(): TicketFactory
    // {
    //     // return TicketFactory::new();
    // }
}
