@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Activity Log</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="m-0">System Activity</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="activityLogTable" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="logDetailsModal" tabindex="-1" aria-labelledby="logDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logDetailsModalLabel"><i class="bi bi-clock-history me-2"></i>Activity Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="logDetailsBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            var detailsModalEl = document.getElementById('logDetailsModal');
            var detailsModal = new bootstrap.Modal(detailsModalEl);
            var detailsBody = document.getElementById('logDetailsBody');

            function escapeHtml(value) {
                return $('<div>').text(value ?? '').html();
            }

            function actionBadge(action) {
                var colors = {
                    'login': 'success',
                    'logout': 'secondary',
                    'user.created': 'primary',
                    'user.updated': 'info',
                    'user.deleted': 'danger',
                    'user.password_changed': 'warning',
                };

                var color = colors[action] || 'secondary';

                return '<span class="badge bg-' + color + '">' + escapeHtml(action) + '</span>';
            }

            function buildDiffTable(oldValues, newValues) {
                if (! oldValues && ! newValues) {
                    return '<p class="text-gray-600 mb-0">No field changes recorded for this entry.</p>';
                }

                var keys = Object.keys(Object.assign({}, oldValues, newValues));

                var rows = keys.map(function (key) {
                    var oldVal = oldValues ? oldValues[key] : undefined;
                    var newVal = newValues ? newValues[key] : undefined;
                    var changed = oldValues && newValues && oldVal !== newVal;
                    var rowClass = changed ? ' class="table-warning"' : '';

                    return '' +
                        '<tr' + rowClass + '>' +
                        '<td class="fw-bold">' + escapeHtml(key) + (changed ? ' <i class="bi bi-exclamation-circle-fill text-warning ms-1" title="Changed"></i>' : '') + '</td>' +
                        '<td>' + (oldVal === undefined ? '<span class="text-gray-500">&mdash;</span>' : escapeHtml(oldVal)) + '</td>' +
                        '<td>' + (newVal === undefined ? '<span class="text-gray-500">&mdash;</span>' : (changed ? '<strong>' + escapeHtml(newVal) + '</strong>' : escapeHtml(newVal))) + '</td>' +
                        '</tr>';
                }).join('');

                return '' +
                    '<table class="table table-sm table-bordered mb-0">' +
                    '<thead><tr><th>Field</th><th>Old Value</th><th>New Value</th></tr></thead>' +
                    '<tbody>' + rows + '</tbody>' +
                    '</table>';
            }

            $('#activityLogTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: @json(route('activity-log.data')),
                },
                order: [[0, 'desc']],
                columns: [
                    { data: 'created_at' },
                    { data: 'causer' },
                    { data: 'action', render: actionBadge },
                    { data: 'description' },
                    { data: 'ip_address', render: (ip) => ip || '<span class="text-gray-500">&mdash;</span>' },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-end',
                        render: function () {
                            return '<button type="button" class="btn btn-sm btn-outline-secondary" data-view-details><i class="bi bi-eye"></i></button>';
                        },
                    },
                ],
                language: {
                    emptyTable: 'No activity recorded yet.',
                },
            });

            $('#activityLogTable tbody').on('click', '[data-view-details]', function () {
                var table = $('#activityLogTable').DataTable();
                var row = table.row($(this).closest('tr')).data();

                detailsBody.innerHTML = '' +
                    '<dl class="row mb-3">' +
                    '<dt class="col-sm-3">Date/Time</dt><dd class="col-sm-9">' + escapeHtml(row.created_at) + '</dd>' +
                    '<dt class="col-sm-3">User</dt><dd class="col-sm-9">' + escapeHtml(row.causer) + '</dd>' +
                    '<dt class="col-sm-3">Action</dt><dd class="col-sm-9">' + actionBadge(row.action) + '</dd>' +
                    '<dt class="col-sm-3">Description</dt><dd class="col-sm-9">' + escapeHtml(row.description) + '</dd>' +
                    '<dt class="col-sm-3">IP Address</dt><dd class="col-sm-9">' + escapeHtml(row.ip_address) + '</dd>' +
                    '</dl>' +
                    buildDiffTable(row.old_values, row.new_values);

                detailsModal.show();
            });
        })();
    </script>
@endpush
