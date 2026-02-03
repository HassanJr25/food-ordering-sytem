@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Manage Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">+ Add New Category</a>
    </div>

    <div class="card-body">
        <!-- Success or Error Alert -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Check if categories exist -->
        @if($categories->isEmpty())
            <div style="text-align: center; padding: 3rem; color: #666;">
                <h4>No categories yet.</h4>
                <p>Click the button above to add your first category!</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">Create Category</a>
            </div>
        @else
            <!-- Categories Table -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Food Items</th>
                            <th>Created At</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($category->image)
                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    @else
                                        <span style="color: #999; font-size: 0.85rem;">No image</span>
                                    @endif
                                </td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>{{ $category->description ?? 'No description' }}</td>
                                <td>
                                    @if($category->is_active)
                                        <span style="background: #d4edda; color: #155724; padding: 0.3rem 0.75rem; border-radius: 12px; font-size: 0.85rem;">Active</span>
                                    @else
                                        <span style="background: #f8d7da; color: #721c24; padding: 0.3rem 0.75rem; border-radius: 12px; font-size: 0.85rem;">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $category->foodItems->count() }}</td>
                                <td style="font-size: 0.85rem; color: #666;">{{ $category->created_at->format('d M Y') }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning" style="padding: 0.4rem 0.9rem; font-size: 0.85rem; margin-right: 0.5rem;">Edit</a>
                                    <button onclick="confirmDelete('{{ $category->name }}', '{{ route('admin.categories.destroy', $category) }}')" class="btn btn-danger" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: #fff; border-radius: 10px; padding: 2rem; max-width: 450px; width: 90%; text-align: center;">
        <h3 style="color: #e74c3c; margin-bottom: 1rem;">Delete Category</h3>
        <p style="color: #333; margin-bottom: 1.5rem;" id="deleteMessage">Are you sure you want to delete this category?</p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button onclick="closeModal()" class="btn btn-primary">Cancel</button>
            <button id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</button>
        </div>
    </div>
</div>

@section('scripts')
<script>
    let deleteUrl = '';

    function confirmDelete(name, url) {
        deleteUrl = url;
        document.getElementById('deleteMessage').textContent = 'Are you sure you want to delete "' + name + '"? This action cannot be undone.';
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        // Create a form to submit DELETE request with CSRF token
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;

        // CSRF token
        var csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Method override for DELETE
        var methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);

        document.body.appendChild(form);
        form.submit();
    });

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endSection