@extends('layouts.artist') 
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Payout Request</h3>
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
                    <a href="{{ route('artist.payout') }}">
                        <div class="text-tiny">Payout</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Payout</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <h4>Edit Payout Request</h4>
            <form action="{{ route('artist.payout.update', ['id' => $payoutRequest->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="amount">Payout Amount:</label>
                    <input 
                        type="number" 
                        name="amount" 
                        id="amount" 
                        class="form-control" 
                        value="{{ old('amount', $payoutRequest->amount) }}" 
                        max="{{ $availableBalance ?? 0 }}" 
                        required
                        placeholder="Enter payout amount"
                        step="0.01">
                </div>
                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="Bank" {{ $payoutRequest->payment_method == 'Bank' ? 'selected' : '' }}>Bank</option>
                        <option value="GCash" {{ $payoutRequest->payment_method == 'GCash' ? 'selected' : '' }}>GCash</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="payment_details">Payment Details:</label>
                    <input 
                        type="text" 
                        name="payment_details" 
                        id="payment_details" 
                        class="form-control" 
                        value="{{ $payoutRequest->payment_details }}" 
                        required
                        placeholder="Enter payment details">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Update Payout Request</button>
                <a href="{{ route('artist.payout') }}" class="btn btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
