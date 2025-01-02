@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <h3>Pending Transactions</h3>

        <div class="wg-box">
            @if($transactions->isEmpty())
            <p>No pending transactions.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Mode</th>
                        <th>Transaction Number</th>
                        <th>Total Price</th> <!-- New Column -->
                        <th>Receipt</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->order->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ ucfirst($transaction->mode) }}</td>
                        <td>{{ $transaction->transaction_number }}</td>
                        <td>₱{{ number_format($transaction->order->total, 2) }}</td> <!-- Total Price -->
                        <td>
                            @if ($transaction->receipt)
                                <a href="{{ asset('storage/' . $transaction->receipt) }}" target="_blank">View Receipt</a>
                            @else
                                No Receipt Uploaded
                            @endif
                        </td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>
                            <form action="{{ route('admin.transactions.approve', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('admin.transactions.decline', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        </div>
   
    </div>
    
</div>
@endsection
