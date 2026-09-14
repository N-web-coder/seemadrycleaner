@extends('layouts.admin')

@section('page_title', 'Stores')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manage Stores</h3>
            <div class="card-tools">
                <a href="{{ route('admin.stores.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                    New</a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Locality</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                        <tr>
                            <td>{{ $store->id }}</td>
                            <td>{{ $store->name }}</td>
                            <td>{{ $store->locality->name ?? 'N/A' }}</td>
                            <td>{{ \Str::limit($store->address, 30) }}</td>
                            <td>{{ $store->phone }}</td>
                            <td>
                                <span class="badge {{ $store->is_active ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ $store->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-sm btn-info"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.stores.destroy', $store) }}" method="POST"
                                    style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No stores found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $stores->links() }}
        </div>
    </div>
@endsection