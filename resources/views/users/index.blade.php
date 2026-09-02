@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-person-plus me-1"></i> Add New
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 small">{{ session('status') }}</div>
    @endif

    @error('user')
        <div class="alert alert-danger py-2 small">{{ $message }}</div>
    @enderror

    <div class="card">
        <div class="card-header">
            <h6 class="m-0">All Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <form method="POST" id="deleteUserForm" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete <strong id="deleteUserName"></strong>? This cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteUserBtn">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            var deleteModalEl = document.getElementById('deleteUserModal');
            var deleteModal = new bootstrap.Modal(deleteModalEl);
            var deleteForm = document.getElementById('deleteUserForm');
            var deleteNameEl = document.getElementById('deleteUserName');
            var pendingDeleteUrl = null;

            function escapeHtml(value) {
                return $('<div>').text(value).html();
            }

            $('#usersTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: @json(route('users.data')),
                },
                order: [[0, 'asc']],
                columns: [
                    { data: 'name' },
                    { data: 'email' },
                    {
                        data: 'is_admin',
                        className: 'text-center',
                        render: function (isAdmin) {
                            return isAdmin
                                ? '<span class="badge bg-primary">Admin</span>'
                                : '<span class="badge bg-secondary">User</span>';
                        },
                    },
                    { data: 'created_at' },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-end',
                        render: function (row) {
                            var deleteDisabled = row.is_self ? 'disabled' : '';

                            return '' +
                                '<div class="input-group justify-content-end">' +
                                '<a href="' + row.show_url + '" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>' +
                                '<a href="' + row.edit_url + '" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>' +
                                '<button type="button" class="btn btn-sm btn-outline-danger" data-delete-url="' + row.delete_url + '" data-delete-name="' + escapeHtml(row.name) + '" ' + deleteDisabled + '><i class="bi bi-trash"></i></button>' +
                                '</div>';
                        },
                    },
                ],
                language: {
                    emptyTable: 'No users found.',
                },
            });

            $('#usersTable tbody').on('click', '[data-delete-url]', function () {
                pendingDeleteUrl = this.dataset.deleteUrl;
                deleteNameEl.textContent = this.dataset.deleteName;
                deleteModal.show();
            });

            document.getElementById('confirmDeleteUserBtn').addEventListener('click', function () {
                deleteForm.action = pendingDeleteUrl;
                deleteForm.submit();
            });
        })();
    </script>
@endpush
