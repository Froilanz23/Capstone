@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Payout History</h3>
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
                    <div class="text-tiny">Payout History</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Artist Name</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Payment Details</th>
                            <th>Status</th>
                            {{-- <th>Processed At</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payoutHistory as $payout)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payout->artist->user->name }}</td>
                            <td>₱{{ number_format($payout->amount, 2) }}</td>
                            <td>{{ ucfirst($payout->payment_method) }}</td>
                            <td>{{ $payout->payment_details }}</td>
                            <td>
                                @if($payout->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($payout->status == 'declined')
                                    <span class="badge bg-danger">Declined</span>
                                @endif
                            </td>
                            {{-- <td>{{ $payout->processed_at ? $payout->processed_at->format('Y-m-d H:i') : 'N/A' }}</td> --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No payout history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
