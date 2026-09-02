@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Details</h1>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Users
        </a>
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
@endsection
