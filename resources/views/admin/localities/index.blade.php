@extends('layouts.admin')

@section('page_title', 'Localities')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage Localities</h3>
        <div class="card-tools">
            <a href="{{ route('admin.localities.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New</a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>City / State</th>
                    <th>Pincode</th>
                    <th>Status</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($localities as $locality)
                <tr>
                    <td>{{ $locality->id }}</td>
                    <td>{{ $locality->name }}</td>
                    <td>{{ $locality->city }}, {{ $locality->state }}</td>
                    <td>{{ $locality->pincode }}</td>
                    <td>
                        <span class="badge {{ $locality->is_active ? 'text-bg-success' : 'text-bg-danger' }}">
                            {{ $locality->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.localities.edit', $locality) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.localities.destroy', $locality) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No localities found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $localities->links() }}
    </div>
</div>
@endsection
