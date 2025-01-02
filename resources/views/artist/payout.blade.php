@extends('layouts.artist')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Payout</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('artist.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Payout</div>
                </li>
            </ul>
        </div>
        <div class="wg-box">
            <h4>Total Available Balance: ₱{{ number_format($availableBalance, 2) }}</h4>
            <form class="form-new-product form-style-1" action="{{ route('artist.payout.request') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="body-title" for="amount">Payout Amount:</label>
                    <input type="number" name="amount" placeholder="Payout Amount" id="amount" class="form-control" max="{{ $availableBalance }}" required>
                </div>
                <div class="form-group">
                    <label class="body-title" for="payment_method">Payment Method:</label>
                    <select name="payment_method" placeholder="Payment Method" id="payment_method" class="form-control-grow" required>
                        <option value="">Select</option>
                        <option value="Bank">Bank</option>
                        <option value="GCash">GCash</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="body-title" for="payment_details">Payment Details:</label>
                    <input type="text" name="payment_details" placeholder="Payment Details" id="payment_details" class="form-control" required>
                </div>

              <div class="bot">
                  <div></div>
                  <button class="tf-button w208" type="submit">Request Payout</button>
              </div>
            </form>
        </div>

        <div class="wg-box mt-5">
            <h4>Previous Payout Requests</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payoutRequests as $request)
                    <tr>
                        <td>{{ $request->created_at }}</td>
                        <td>₱{{ number_format($request->amount, 2) }}</td>
                        <td>{{ $request->payment_method }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td class="text-center">
                            @if ($request->status == 'pending')
                                <a href="{{ route('artist.payout.edit', ['id' => $request->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('artist.payout.delete', ['id' => $request->id]) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this request?')">Delete</button>
                                </form>
                            @else
                                <span class="text-muted">No Actions Available</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
