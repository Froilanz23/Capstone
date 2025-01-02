@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <h3>Add Payment Method</h3>

        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('payment_methods.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name" class="body-title">Name <span class="tf-color-1">*</span></label>
                    <input type="text" name="name" placeholder="Name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="account_name" class="body-title">Account Name <span class="tf-color-1">*</span></label>
                    <input type="text" name="account_name" placeholder="Account Name" id="account_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="account_number" class="body-title">Account Number <span class="tf-color-1">*</span></label>
                    <input type="text" name="account_number" placeholder="Account Number" id="account_number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="details" class="body-title">Details <span class="tf-color-1">*</span></label>
                    <textarea name="details" placeholder="Details" id="details" class="form-control"></textarea>
                </div>
                
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
        
    </div>
</div>
   
@endsection
