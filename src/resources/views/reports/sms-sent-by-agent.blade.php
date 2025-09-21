@extends('layouts.main')

@section('head-links')
  @include('layouts.common.meta-data')
  <title>{{ config('app.name', 'Laravel') }} - SMS Report</title>
  @include('layouts.common.css-links')
  <link rel="stylesheet" href='https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css' />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <style>
    .filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
    }
    .status-sent { background-color: #d4edda; color: #155724; }
    .status-failed { background-color: #f8d7da; color: #721c24; }
    .status-pending { background-color: #fff3cd; color: #856404; }
  </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">SMS Report - All Sent Messages</h5>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="filter-section">
                        <form method="GET" action="{{route($role_slug.'/reports/sms-sent-by-agent')}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="date_from" class="form-label">Date From</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" 
                                           value="{{ request('date_from') }}">
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="date_to" class="form-label">Date To</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" 
                                           value="{{ request('date_to') }}">
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="agent_id" class="form-label">Agent</label>
                                    <select class="form-control" id="agent_id" name="agent_id">
                                        <option value="">All Agents</option>
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}" 
                                                {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                                                {{ $agent->first_name }} {{ $agent->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="template_type" class="form-label">Template Type</label>
                                    <select class="form-control" id="template_type" name="template_type">
                                        <option value="">All Templates</option>
                                        <option value="policy-expiring" {{ request('template_type') == 'policy-expiring' ? 'selected' : '' }}>
                                            Policy Expiring
                                        </option>
                                        <option value="welcome" {{ request('template_type') == 'welcome' ? 'selected' : '' }}>
                                            Welcome
                                        </option>
                                        <option value="payment-reminder" {{ request('template_type') == 'payment-reminder' ? 'selected' : '' }}>
                                            Payment Reminder
                                        </option>
                                        <!-- Add more template types as needed -->
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">All Status</option>
                                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-9 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="{{ route($role_slug.'/reports/sms-sent-by-agent') }}" class="btn btn-secondary">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h4>{{ $summary['total'] }}</h4>
                                    <p class="mb-0">Total SMS</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h4>{{ $summary['sent'] }}</h4>
                                    <p class="mb-0">Sent</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h4>{{ $summary['failed'] }}</h4>
                                    <p class="mb-0">Failed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h4>{{ $summary['pending'] }}</h4>
                                    <p class="mb-0">Pending</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add this temporarily before the table -->
{{-- <div class="alert alert-info">
    Debug: Total logs count: {{ count($smsLogs ?? []) }}
</div> --}}

                    <!-- Data Table -->
                    <!-- Data Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="smsReportTable">
        <thead class="table-light fw-semibold">
            <tr class="align-middle">
                <th>Client Name</th>
                <th>Phone Number</th>
                <th>Template Type</th>
                <th>Status</th>
                <th>Sent By</th>
                <th>Date Sent</th>
                <th>Error Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($smsLogs ?? [] as $log)
            <tr class="align-middle">
                <td>
                    @if(isset($log->client) && $log->client)
                        {{ $log->client->first_name ?? '' }} {{ $log->client->last_name ?? '' }}
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>{{ $log->phone_number ?? '' }}</td>
                <td>
                    <span class="badge bg-info text-dark">
                        {{ ucfirst(str_replace('-', ' ', $log->template_type ?? '')) }}
                    </span>
                </td>
                <td>
                    <span class="status-badge status-{{ $log->status ?? 'unknown' }}">
                        {{ ucfirst($log->status ?? 'Unknown') }}
                    </span>
                </td>
                <td>
                    @if(isset($log->sentBy) && $log->sentBy)
                        {{ $log->sentBy->first_name ?? '' }} {{ $log->sentBy->last_name ?? '' }}
                    @else
                        <span class="text-muted">System</span>
                    @endif
                </td>
                <td>
                    @if(isset($log->created_at) && $log->created_at)
                        {{ $log->created_at->format('M d, Y H:i') }}
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>
                    @if(isset($log->error_message) && $log->error_message)
                        <span class="text-danger" title="{{ $log->error_message }}">
                            {{ Str::limit($log->error_message, 30) }}
                        </span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-transparent p-0" type="button" 
                                data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon">
                                <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                            </svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            @if(isset($log->status) && $log->status == 'failed')
                                <a class="dropdown-item" href="#" onclick="resendSms({{ $log->id ?? 0 }})">
                                    Resend SMS
                                </a>
                            @endif
                            <a class="dropdown-item" href="#" onclick="viewDetails({{ $log->id ?? 0 }})">
                                View Details
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            {{-- <tr>
                <td colspan="8" class="text-center">No SMS logs found.</td>
            </tr> --}}
            @endforelse
        </tbody>
    </table>
</div>

                    <!-- Pagination -->
                    @if($smsLogs && method_exists($smsLogs, 'links'))
                        <div class="mt-3">
                            {{ $smsLogs->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@include('layouts.common.scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="{{asset('vendors/chart.js/js/chart.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src='https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js'></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#smsReportTable').DataTable({
        "pageLength": 25,
        "order": [[ 5, "desc" ]], // Order by date sent descending
        "columnDefs": [
            { "orderable": false, "targets": 7 } // Disable sorting on Actions column
        ],
        "language": {
            "emptyTable": "No SMS logs found for the selected criteria",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "search": "Search:",
            "zeroRecords": "No matching records found"
        }
    });
    
    // Set today's date as default for date_to if not set
    if (!$('#date_to').val()) {
        $('#date_to').val(new Date().toISOString().split('T')[0]);
    }
});

function resendSms(logId) {
    if (confirm('Are you sure you want to resend this SMS?')) {
        $.ajax({
            url: '/{{ $role_slug }}/reports/resend-sms/' + logId,
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                alert('SMS resent successfully!');
                location.reload();
            },
            error: function() {
                alert('Error resending SMS.');
            }
        });
    }
}

function viewDetails(logId) {
    window.open('/{{ $role_slug }}/reports/sms-details/' + logId, '_blank');
}

function exportReport(format) {
    var params = new URLSearchParams(window.location.search);
    params.set('export', format);
    window.location.href = '{{ route($role_slug."/reports/sms-sent-by-agent") }}?' + params.toString();
}
</script>
@endsection