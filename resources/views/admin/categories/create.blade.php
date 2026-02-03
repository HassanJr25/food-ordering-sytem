@extends('layouts.master')

@section('content')
<div class="card" style="max-width: 750px; margin: 0 auto;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Add New Category</h3>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">← Back to Categories</a>
    </div>

    <div class="card-body">
        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the following errors:</strong>
                <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Category Name <span style="color: #e74c3c;">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Pizza, Burgers, Drinks" required>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Describe this category...">{{ old('description') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div class="form-group">
                <label for="image">Category Image</label>
                <input type="file" id="image" name="image" accept="image/*" style="padding: 0.5rem 0;">
                <span style="color: #999; font-size: 0.85rem;">Accepted: JPG, PNG, GIF (max 2MB)</span>

                <!-- Image Preview -->
                <div id="imagePreview" style="margin-top: 1rem; display: none;">
                    <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 6px; border: 1px solid #ddd;">
                </div>
            </div>

            <!-- Active Toggle -->
            <div class="form-group">
                <label style="display: flex; align-items: center; font-weight: normal; cursor: pointer;">
                    <input type="checkbox" name="is_active" checked style="width: auto; margin-right: 0.75rem; cursor: pointer;">
                    <span>Active (visible to customers)</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="form-group" style="margin-top: 2rem;">
                <button type="submit" class="btn btn-success" style="padding: 0.75rem 2rem;">Create Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary" style="padding: 0.75rem 2rem; margin-left: 0.5rem;">Cancel</a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    // Image Preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endSection