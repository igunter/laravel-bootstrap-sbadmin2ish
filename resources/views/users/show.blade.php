@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Details</h1>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#userActivityOffcanvas" aria-controls="userActivityOffcanvas">
                <i class="bi bi-clock-history me-1"></i> Activity Log
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Users
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 small">{{ session('status') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body text-center p-4 p-lg-5">
                    <i class="bi bi-person-circle text-gray-300" style="font-size: 5rem;"></i>
                    <h2 class="h4 mt-3 mb-1 text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-600 mb-2">{{ $user->email }}</p>

                    @if ($user->is_admin)
                        <span class="badge bg-primary">Administrator</span>
                    @else
                        <span class="badge bg-secondary">User</span>
                    @endif

                    <hr>

                    <dl class="row text-start mb-0">
                        <dt class="col-sm-5 text-gray-600">User ID</dt>
                        <dd class="col-sm-7">{{ $user->id }}</dd>

                        <dt class="col-sm-5 text-gray-600">Joined</dt>
                        <dd class="col-sm-7">{{ $user->created_at->format('M j, Y \a\t g:i A') }}</dd>

                        <dt class="col-sm-5 text-gray-600">Last Updated</dt>
                        <dd class="col-sm-7">{{ $user->updated_at->format('M j, Y \a\t g:i A') }}</dd>

                        <dt class="col-sm-5 text-gray-600">Email Verified</dt>
                        <dd class="col-sm-7">
                            @if ($user->email_verified_at)
                                <i class="bi bi-check-circle-fill text-success me-1"></i>{{ $user->email_verified_at->format('M j, Y') }}
                            @else
                                <i class="bi bi-x-circle-fill text-danger me-1"></i>Not verified
                            @endif
                        </dd>
                    </dl>

                    <hr>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Side Window -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="userActivityOffcanvas" aria-labelledby="userActivityOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="userActivityOffcanvasLabel"><i class="bi bi-clock-history me-2"></i>Activity Log</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @forelse ($activityLogs as $log)
                @php
                    $colors = [
                        'login' => 'success',
                        'logout' => 'secondary',
                        'user.created' => 'primary',
                        'user.updated' => 'info',
                        'user.deleted' => 'danger',
                        'user.password_changed' => 'warning',
                    ];
                    $color = $colors[$log->action] ?? 'secondary';
                    $fields = array_unique(array_merge(array_keys($log->old_values ?? []), array_keys($log->new_values ?? [])));
                @endphp
                <div class="border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-{{ $color }}">{{ $log->action }}</span>
                        <small class="text-gray-600">{{ $log->created_at->format('M j, Y g:i A') }}</small>
                    </div>
                    <p class="mb-1 mt-2">{{ $log->description }}</p>
                    <p class="mb-0 small text-gray-600">
                        By {{ $log->causer?->name ?? 'System' }}
                        @if ($log->ip_address)
                            &middot; {{ $log->ip_address }}
                        @endif
                    </p>

                    @if (count($fields))
                        <ul class="list-unstyled small mb-0 mt-2">
                            @foreach ($fields as $field)
                                @php
                                    $hasOld = isset($log->old_values[$field]);
                                    $hasNew = isset($log->new_values[$field]);
                                    $old = $log->old_values[$field] ?? null;
                                    $new = $log->new_values[$field] ?? null;
                                    $changed = $hasOld && $hasNew && $old !== $new;
                                    $format = fn ($v) => is_bool($v) ? ($v ? 'Yes' : 'No') : $v;
                                @endphp
                                <li class="{{ $changed ? 'bg-warning-subtle rounded px-1' : '' }}">
                                    <span class="text-gray-600">{{ $field }}:</span>
                                    @if ($hasOld)
                                        <span>{{ $format($old) }}</span>
                                    @endif
                                    @if ($changed)
                                        <i class="bi bi-arrow-right mx-1"></i>
                                    @endif
                                    @if ($hasNew)
                                        <strong>{{ $format($new) }}</strong>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @empty
                <p class="text-gray-600 mb-0">No activity recorded for this user yet.</p>
            @endforelse
        </div>
    </div>
@endsection
