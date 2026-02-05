@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Manage Food Items</h3>
        <a href="{{ route('admin.food-items.create') }}" class="btn btn-success">+ Add New Food Item</a>
    </div>

    <div class="card-body">
        <!-- Success or Error Alert -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Check if food items exist -->
        @if($foodItems->isEmpty())
            <div style="text-align: center; padding: 3rem; color: #666;">
                <h4>No food items yet.</h4>
                <p>Click the button above to add your first food item!</p>
                <a href="{{ route('admin.food-items.create') }}" class="btn btn-primary mt-2">Create Food Item</a>
            </div>
        @else
            <!-- Food Items Table -->
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Created At</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($foodItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    @else
                                        <span style="color: #999; font-size: 0.85rem;">No image</span>
                                    @endif
                                </td>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>
                                    <span style="background: #e3f2fd; color: #1976d2; padding: 0.3rem 0.75rem; border-radius: 12px; font-size: 0.85rem;">
                                        {{ $item->category->name }}
                                    </span>
                                </td>
                                <td><strong style="color: #27ae60;">TZS {{ number_format($item->price, 2) }}</strong></td>
                                <td>
                                    @if($item->is_available)
                                        <span style="background: #d4edda; color: #155724; padding: 0.3rem 0.75rem; border-radius: 12px; font-size: 0.85rem;">Available</span>
                                    @else
                                        <span style="background: #f8d7da; color: #721c24; padding: 0.3rem 0.75rem; border-radius: 12px; font-size: 0.85rem;">Unavailable</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_featured)
                                        <span style="background: #fff3cd; color: #856404; padding: 0.3rem 0.75rem; border-radius: 12px; font-size: 0.85rem;">⭐ Featured</span>
                                    @else
                                        <span style="color: #999; font-size: 0.85rem;">-</span>
                                    @endif
                                </td>
                                <td style="font-size: 0.85rem; color: #666;">{{ $item->created_at->format('d M Y') }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.food-items.edit', $item) }}" class="btn btn-warning" style="padding: 0.4rem 0.9rem; font-size: 0.85rem; margin-right: 0.5rem;">Edit</a>
                                    <button onclick="confirmDelete('{{ $item->name }}', '{{ route('admin.food-items.destroy', $item) }}')" class="btn btn-danger" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">Delete</button>
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
        <h3 style="color: #e74c3c; margin-bottom: 1rem;">Delete Food Item</h3>
        <p style="color: #333; margin-bottom: 1.5rem;" id="deleteMessage">Are you sure you want to delete this item?</p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button onclick="closeModal()" class="btn btn-primary">Cancel</button>
            <button id="confirmDeleteBtn" class="btn btn-danger">Yes, Delete</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
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
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;

        var csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        var methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);

        document.body.appendChild(form);
        form.submit();
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endpush