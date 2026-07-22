@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'User Management')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">All Users</h4>
                <p class="text-muted mb-0">Manage user accounts and permissions</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-download me-1"></i> Download Reports
                </a>
                <a href="{{{ route('admin.users.create') }}}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New User
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge bg-danger">Admin</span>
                                        @else
                                            <span class="badge bg-primary">User</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{{ route('admin.users.show', $user) }}}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{{ route('admin.users.edit', $user) }}}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{{ route('admin.users.destroy', $user) }}}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p class="text-muted mb-0">No users found.</p>
                                        <a href="{{{ route('admin.users.create') }}}" class="btn btn-sm btn-primary mt-2">
                                            Create First User
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
                <div class="card-footer-pagination">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

