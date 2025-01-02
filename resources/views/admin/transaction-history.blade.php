@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <h3>Transaction History</h3>
    
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <!-- Username Search Form -->
                <div class="wg-filter flex-grow">
                    <form method="GET" action="{{ route('admin.transaction-history') }}" class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search Username here..." class="" name="user_name"
                                tabindex="2" value="{{ request('user_name') }}" aria-required="true">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>

                    <!-- Status Filter Form -->
                    <form method="GET" action="{{ route('admin.transaction-history') }}" class="form-history-status">
                        <div class="row align-items-center g-3">
                            <div class="col-auto">
                                <label for="status" class="form-label fw-bold" style="font-size: 1.25rem;">Status:</label>
                            </div>
                            <div class="col-auto">
                                <select name="status" id="status" class="form-grow">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button class="tf-button w108" type="submit">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th style="font-size: 1.25rem;">Transaction ID</th>
                            <th style="font-size: 1.25rem;">User</th>
                            <th style="font-size: 1.25rem;">Order ID</th>
                            <th style="font-size: 1.25rem;">Mode</th>
                            <th style="font-size: 1.25rem;">Status</th>
                            <th style="font-size: 1.25rem;">Total Price</th>
                            <th style="font-size: 1.25rem;">Transaction Number</th>
                            <th style="font-size: 1.25rem;">Receipt</th>
                            <th style="font-size: 1.25rem;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                <td>{{ $transaction->order_id }}</td>
                                <td>{{ ucfirst($transaction->mode) }}</td>
                                <td>{{ ucfirst($transaction->status) }}</td>
                                <td>₱{{ number_format($transaction->order->orderItems->sum(fn($item) => $item->price * $item->quantity), 2) }}</td>
                                <td>{{ $transaction->transaction_number }}</td>
                                <td>
                                    @if ($transaction->receipt)
                                        <a href="{{ asset('storage/' . $transaction->receipt) }}" target="_blank" style="font-weight: bold;">View Receipt</a>
                                    @else
                                        <span style="color: gray;">No Receipt Uploaded</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center" style="font-size: 1.25rem;">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-4" style="font-size: 1.25rem;">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
