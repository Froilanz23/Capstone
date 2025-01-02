@extends('layouts.admin')

@section('content')

<div class="main-content-inner">                            
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Users</h3>
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
                    <div class="text-tiny">All Users</div>
                </li>
            </ul>
        </div>

        <!-- User Search Form -->
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="{{ route('admin.users') }}">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." name="name" value="{{ request('name') }}" required>
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Admins Table -->
            <h4>Admins</h4>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>User</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Total Orders</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if ($user->role == 1) <!-- Admin -->
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="pname">
                                            <div class="name">
                                                <a href="{{ route('admin.user.edit', $user->id) }}" class="body-title-2">{{ $user->name }}</a>
                                                <div class="text-tiny mt-3">Admin</div>
                                            </div>
                                        </td>
                                        <td>{{ $user->mobile ?? 'Not Provided' }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">{{ $user->orders_count }}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ route('admin.user.edit', $user->id) }}">
                                                    <div class="item edit"><i class="icon-edit-3"></i></div>
                                                </a>
                                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')">
                                                        <div class="item delete"><i class="icon-trash-2"></i></div>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>                    
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Artists Table -->
            <h4>Artists</h4>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>User</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Uploaded Products</th> <!-- New Column -->
                                <th>Total Orders</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if ($user->role == 2) <!-- Artist -->
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="pname">
                                            <div class="name">
                                                <a href="{{ route('admin.user.edit', $user->id) }}" class="body-title-2">{{ $user->name }}</a>
                                                <div class="text-tiny mt-3">Artist</div>
                                            </div>
                                        </td>
                                        <td>{{ $user->artist_mobile ?? $user->mobile ?? 'Not Provided' }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">{{ $user->artist?->products_count ?? 0 }}</td> <!-- Uploaded Products Count -->
                                        <td class="text-center">{{ $user->orders_count }}</td> <!-- Total Orders Count -->
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ route('admin.user.edit', $user->id) }}">
                                                    <div class="item edit"><i class="icon-edit-3"></i></div>
                                                </a>
                                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')">
                                                        <div class="item delete"><i class="icon-trash-2"></i></div>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        <!-- Customers Table -->
        <h4>Customers</h4>
        <div class="wg-table table-all-user">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>User</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Total Orders</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if ($user->role == 3) <!-- Customer -->
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="pname">
                                        <div class="name">
                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="body-title-2">{{ $user->name }}</a>
                                            <div class="text-tiny mt-3">Customer</div>
                                        </div>
                                    </td>
                                    <td>{{ $user->mobile ?? 'Not Provided' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">{{ $user->orders_count }}</td> <!-- Total Orders Count -->
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{ route('admin.user.edit', $user->id) }}">
                                                <div class="item edit"><i class="icon-edit-3"></i></div>
                                            </a>
                                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')">
                                                    <div class="item delete"><i class="icon-trash-2"></i></div>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
