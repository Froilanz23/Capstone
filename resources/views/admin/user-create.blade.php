@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <h3>Add User</h3>

        <div class="wg-box">
            <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.user.store') }}">
                @csrf
                <div class="form-group">
                    <label  class="body-title" for="name">Name <span class="tf-color-1">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
                </div>

                <div class="form-group">
                    <label class="body-title" for="email">Email <span class="tf-color-1">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="form-group">
                    <label class="body-title" for="role">Role <span class="tf-color-1">*</span></label>
                        <select name="role" id="role" class="form-control-grow" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="1">Admin</option>
                            <option value="2">Artist</option>
                            <option value="3">Customer</option>
                        </select>
                </div>

                <div class="form-group">
                    <label class="body-title" for="password">Password <span class="tf-color-1">*</span></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                </div>

                <div class="form-group">
                    <label class="body-title" for="password_confirmation">Confirm Password <span class="tf-color-1">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" required>
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
