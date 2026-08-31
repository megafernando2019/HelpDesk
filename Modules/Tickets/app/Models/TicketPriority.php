<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Tickets\Database\Factories\TicketPriorityFactory;

class TicketPriority extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'tickets_priorities';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): TicketPriorityFactory
    // {
    //     // return TicketPriorityFactory::new();
    // }
}
