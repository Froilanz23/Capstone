@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <h3>Payment Methods</h3>

        <div class="wg-box">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($methods as $method)
                        <tr>
                            <td>{{ $method->name }}</td>
                            <td>{{ $method->account_name }}</td>
                            <td>{{ $method->account_number }}</td>
                            <td>{{ $method->details }}</td>
                            <td>
                                <a href="{{ route('payment_methods.edit', $method->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('payment_methods.destroy', $method->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a class="tf-button style-1 w208" href="{{ route('payment_methods.create') }}"><i
                class="icon-plus"></i>Add Payment</a>

        </div>
        
    </div>
</div>
   
@endsection
