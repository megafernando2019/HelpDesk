<?php

namespace Modules\Services\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Categories\Models\TicketCategory;

// use Modules\Services\Database\Factories\TicketServiceFactory;

class TicketServiceEntity extends Model
{
    use HasFactory;

    /**
     * alias para apuntar a la tabla
     * @var string
     */
    protected $table = 'tickets_services';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    /**
     * Relations
     */

    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

}
