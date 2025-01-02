@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Pending Artworks</h3>
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
                    <div class="text-tiny">Pending Artworks</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search artworks..." name="name" tabindex="2" required>
                        </fieldset>
                        <div class="button-submit">
                            <button type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width:150px" class="text-center">Name</th>
                                <th class="text-center">Artist</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">COA</th>
                                <th class="text-center">Signature</th>
                                <th class="text-center">Date Uploaded</th>
                                <th class="text-center" style="width:250px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingProducts as $product)
                                <tr>
                                    <td class="text-center">{{ $product->name }}</td>
                                    <td class="text-center">{{ $product->artist->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $product->COA ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $product->signature ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $product->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.product.view', $product->id) }}" class="btn btn-info">View</a>
                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('admin.product.approve', $product->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn btn-success">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.product.reject', $product->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn btn-danger">Reject</button>
                                        </form>
                                    </td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $pendingProducts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
