@php $isEdit = isset($user); @endphp

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $isEdit ? $user->name : '') }}" required autofocus>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email Address</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $isEdit ? $user->email : '') }}" required>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password" class="form-label">
        Password
        @if ($isEdit)
            <span class="text-gray-600 small">(leave blank to keep current password)</span>
        @endif
    </label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" @if (! $isEdit) required @endif>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" @if (! $isEdit) required @endif>
</div>

<div class="mb-4">
    <div class="form-check form-switch">
        <input
            class="form-check-input"
            type="checkbox"
            role="switch"
            id="is_admin"
            name="is_admin"
            value="1"
            @disabled($isEdit && auth()->id() === $user->id)
            @checked(old('is_admin', $isEdit ? $user->is_admin : false))
        >
        <label class="form-check-label" for="is_admin">Administrator</label>
    </div>
    <div class="form-text">Administrators have full access to manage users and settings.</div>
</div>

<button type="submit" class="btn btn-primary">
    <i class="bi bi-check-circle me-1"></i> {{ $submitLabel }}
</button>

<!-- Admin Confirmation Modal -->
<div class="modal fade" id="adminConfirmModal" tabindex="-1" aria-labelledby="adminConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminConfirmModalLabel"><i class="bi bi-shield-exclamation text-warning me-2"></i>Grant Administrator Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">You are about to make this user an administrator, giving them full access. Are you sure?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAdminBtn">
                    <i class="bi bi-check-circle me-1"></i> Yes, Make Admin
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (function () {
            var adminSwitch = document.getElementById('is_admin');

            if (! adminSwitch) {
                return;
            }

            var adminModalEl = document.getElementById('adminConfirmModal');
            var adminModal = new bootstrap.Modal(adminModalEl);
            var confirmed = false;

            adminSwitch.addEventListener('change', function () {
                if (adminSwitch.checked) {
                    confirmed = false;
                    adminModal.show();
                }
            });

            document.getElementById('confirmAdminBtn').addEventListener('click', function () {
                confirmed = true;
                adminModal.hide();
            });

            adminModalEl.addEventListener('hidden.bs.modal', function () {
                if (! confirmed) {
                    adminSwitch.checked = false;
                }
            });
        })();
    </script>
@endpush
