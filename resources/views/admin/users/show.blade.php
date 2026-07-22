@extends('admin.layout')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="200">ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-primary">User</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $user->created_at->format('F d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $user->updated_at->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{{ route('admin.users.edit', $user) }}}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit User
                    </a>
                    <a href="{{{ route('admin.users.index') }}}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

