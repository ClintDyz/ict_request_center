<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function setOldValuesAttribute($value)
    {
        $this->attributes['old_values'] = $value ? json_encode($value) : null;
    }

    public function setNewValuesAttribute($value)
    {
        $this->attributes['new_values'] = $value ? json_encode($value) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log($action, $description, $model = null, $oldValues = null, $newValues = null)
    {
        return self::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public static function getActionLabel($action)
    {
        $labels = [
            'create' => '<span class="badge bg-success">Create</span>',
            'update' => '<span class="badge bg-warning text-dark">Update</span>',
            'delete' => '<span class="badge bg-danger">Delete</span>',
            'login' => '<span class="badge bg-primary">Login</span>',
            'logout' => '<span class="badge bg-secondary">Logout</span>',
            'view' => '<span class="badge bg-info">View</span>',
            'export' => '<span class="badge bg-dark">Export</span>',
            'print' => '<span class="badge bg-dark">Print</span>',
            'approve' => '<span class="badge bg-success">Approve</span>',
            'reject' => '<span class="badge bg-danger">Reject</span>',
        ];

        return $labels[$action] ?? '<span class="badge bg-secondary">' . ucfirst($action) . '</span>';
    }
}
