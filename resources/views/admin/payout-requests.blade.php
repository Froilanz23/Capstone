@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Payout Requests</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Payout Requests</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Artist</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Payment Details</th>
                            <th>Requested On</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payoutRequests as $payout)
                        <tr>
                            <td>{{ $payout->artist->user->name }}</td>
                            <td>₱{{ number_format($payout->amount, 2) }}</td>
                            <td>{{ ucfirst($payout->payment_method) }}</td>
                            <td>{{ $payout->payment_details }}</td>
                            <td>{{ $payout->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge 
                                    {{ $payout->status == 'pending' ? 'bg-warning' : ($payout->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($payout->status) }}
                                </span>
                            </td>
                            <td>
                                @if($payout->status == 'pending')
                                <form action="{{ route('admin.payout.approve', $payout->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.payout.decline', $payout->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Decline</button>
                                </form>
                                @else
                                <button class="btn btn-secondary btn-sm" disabled>Processed</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No payout requests available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
