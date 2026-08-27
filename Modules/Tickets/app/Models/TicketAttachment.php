<?php

namespace Modules\Tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ticket_id',
        'file_path',
        'file_name',
        'file_size',
        'mime_type'
    ];

    public function ticket(): BelongsTo
    {
       return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
