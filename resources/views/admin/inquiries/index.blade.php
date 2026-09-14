@extends('layouts.admin')

@section('page_title', 'Contact Inquiries')

@section('content')
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" action="{{ route('admin.inquiries.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="small text-muted fw-bold">Name</label>
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Search name..."
                        value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-bold">Email</label>
                    <input type="text" name="email" class="form-control form-control-sm" placeholder="Search email..."
                        value="{{ request('email') }}">
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-bold">Date</label>
                    <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold"><i class="fas fa-filter"></i>
                            Filter</button>
                        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-secondary"><i
                                class="fas fa-redo"></i></a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0 border shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $inquiry)
                            <tr>
                                <td>#{{ $inquiry->id }}</td>
                                <td class="fw-bold">{{ $inquiry->name }}</td>
                                <td>{{ $inquiry->email }}</td>
                                <td>{{ $inquiry->subject ?? 'No Subject' }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'Pending' => 'text-bg-warning',
                                            'Read' => 'text-bg-info',
                                            'Replied' => 'text-bg-success',
                                        ];
                                        $color = $statusColors[$inquiry->status] ?? 'text-bg-light';
                                    @endphp
                                    <span class="badge {{ $color }}">{{ $inquiry->status }}</span>
                                </td>
                                <td>{{ $inquiry->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No inquiries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix bg-white">
            {{ $inquiries->links() }}
        </div>
    </div>
@endsection
