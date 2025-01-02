@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <h3>Edit User</h3>

        <div class="wg-box">
            <form class="form-edit-user form-style-1" method="POST" action="{{ route('admin.user.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="body-title" for="name">Name <span class="tf-color-1">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label class="body-title" for="email">Email <span class="tf-color-1">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                </div>

                <div class="form-group">
                    <label class="body-title" for="role">Role <span class="tf-color-1">*</span></label>
                    <select name="role" id="role" class="form-control-grow" required>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Artist</option>
                        <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
