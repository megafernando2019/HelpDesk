<?php

namespace Modules\Categories\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Departments\Models\Department;
use Modules\Services\Models\TicketServiceEntity;

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

    // Relación con el usuario que creó la categoría
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relación con los servicios asignados
    public function services()
    {
        return $this->hasMany(TicketServiceEntity::class, 'category_id');
    }

    public function logs_actions()
    {
        return $this->hasMany(LogActionsCategory::class, 'category_id');
    }
}
