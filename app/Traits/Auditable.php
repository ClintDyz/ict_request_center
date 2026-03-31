<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function (Model $model) {
            AuditLog::log(
                'create',
                'Created ' . class_basename($model),
                $model,
                null,
                $model->toArray()
            );
        });

        static::updated(function (Model $model) {
            $changes = $model->getChanges();
            $oldValues = [];

            foreach ($changes as $key => $value) {
                if (!in_array($key, ['updated_at'])) {
                    $oldValues[$key] = $model->getOriginal($key);
                }
            }

            AuditLog::log(
                'update',
                'Updated ' . class_basename($model),
                $model,
                $oldValues,
                array_diff_key($changes, ['updated_at' => ''])
            );
        });

        static::deleted(function (Model $model) {
            AuditLog::log(
                'delete',
                'Deleted ' . class_basename($model),
                $model,
                $model->toArray(),
                null
            );
        });
    }
}
