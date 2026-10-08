<?php

namespace Modules\Categories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Departments\Models\Department;

class TicketCategory extends Model
{

    protected $table = 'tickets_categories';

    protected $fillable = [
        'uid',
        'department_id',
        'team_id',
        'name',
        'description',
        'color',
        'status',
        'created_by'
    ];

    /**
     * Relations
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
