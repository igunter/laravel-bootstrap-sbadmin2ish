@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Users
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">User Details</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        @include('users.partials.form', ['user' => $user, 'submitLabel' => 'Save Changes'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
