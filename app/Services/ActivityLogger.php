<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        string $action,
        ?Model $subject = null,
        array $old = [],
        array $new = [],
        ?string $description = null,
        ?int $causerId = null,
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => $causerId ?? Auth::id(),
            'action' => $action,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'old_values' => empty($old) ? null : $old,
            'new_values' => empty($new) ? null : $new,
            'ip_address' => Request::ip(),
        ]);
    }
}
