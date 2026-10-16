<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Tickets\Database\Factories\TicketNotificationFactory;

class TicketNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
   
    protected $table = 'tickets_notifications';

    protected $fillable = [
        'ticket_id',
        'ticket_action_id',
        'user_id',
        'title',
        'description',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
