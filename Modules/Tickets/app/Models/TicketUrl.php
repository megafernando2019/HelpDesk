<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Tickets\Database\Factories\TicketUrlFactory;

class TicketUrl extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'tickets_urls';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ticket_id'
    ];
}
