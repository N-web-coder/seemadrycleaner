@extends('layouts.admin')

@section('page_title', 'Inquiry Details')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Inquiry #{{ $inquiry->id }}</h5>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase">Sender Name</label>
                            <p class="fs-5 fw-bold">{{ $inquiry->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase">Email Address</label>
                            <p class="fs-5">{{ $inquiry->email }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small fw-bold text-uppercase">Subject</label>
                        <p class="fs-5">{{ $inquiry->subject ?? 'No Subject' }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small fw-bold text-uppercase">Message</label>
                        <div class="p-3 bg-light rounded-3 border">
                            {!! nl2br(e($inquiry->message)) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small fw-bold text-uppercase">Received At</label>
                            <p>{{ $inquiry->created_at->format('d M Y, h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this inquiry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete Inquiry
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
