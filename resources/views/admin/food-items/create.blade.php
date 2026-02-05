@extends('layouts.master')

@section('content')
<div class="card" style="max-width: 750px; margin: 0 auto;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Add New Food Item</h3>
        <a href="{{ route('admin.food-items.index') }}" class="btn btn-primary" style="padding: 0.4rem 0.9rem; font-size: 0.85rem;">← Back to Food Items</a>
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

        <form method="POST" action="{{ route('admin.food-items.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Category -->
            <div class="form-group">
                <label for="category_id">Category <span style="color: #e74c3c;">*</span></label>
                <select id="category_id" name="category_id" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Name -->
            <div class="form-group">
                <label for="name">Food Item Name <span style="color: #e74c3c;">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Margherita Pizza, Chicken Burger" required>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Describe this food item...">{{ old('description') }}</textarea>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="price">Price (TZS) <span style="color: #e74c3c;">*</span></label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" placeholder="0.00" required>
            </div>

            <!-- Image Upload -->
            <div class="form-group">
                <label for="image">Food Item Image</label>
                <input type="file" id="image" name="image" accept="image/*" style="padding: 0.5rem 0;">
                <span style="color: #999; font-size: 0.85rem;">Accepted: JPG, PNG, GIF (max 2MB)</span>

                <!-- Image Preview -->
                <div id="imagePreview" style="margin-top: 1rem; display: none;">
                    <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 6px; border: 1px solid #ddd;">
                </div>
            </div>

            <!-- Checkboxes Row -->
            <div style="display: flex; gap: 2rem; margin-bottom: 1.5rem;">
                <!-- Available Toggle -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label style="display: flex; align-items: center; font-weight: normal; cursor: pointer;">
                        <input type="checkbox" name="is_available" checked style="width: auto; margin-right: 0.75rem; cursor: pointer;">
                        <span>Available for ordering</span>
                    </label>
                </div>

                <!-- Featured Toggle -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label style="display: flex; align-items: center; font-weight: normal; cursor: pointer;">
                        <input type="checkbox" name="is_featured" style="width: auto; margin-right: 0.75rem; cursor: pointer;">
                        <span>⭐ Featured item</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group" style="margin-top: 2rem;">
                <button type="submit" class="btn btn-success" style="padding: 0.75rem 2rem;">Create Food Item</button>
                <a href="{{ route('admin.food-items.index') }}" class="btn btn-primary" style="padding: 0.75rem 2rem; margin-left: 0.5rem;">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
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
@endpush