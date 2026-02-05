@extends('layouts.master')

@section('content')
<div style="margin-bottom: 3rem;">
    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 3rem 0; text-align: center; margin-bottom: 3rem;">
        <div class="container">
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Our Menu</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">Discover delicious food delivered to your door</p>
        </div>
    </div>

    <div class="container">
        <!-- Search & Filter Bar -->
        <div class="card" style="margin-bottom: 2rem; padding: 1.5rem;">
            <form method="GET" action="{{ route('menu.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <!-- Search Input -->
                <div style="flex: 1; min-width: 250px;">
                    <input type="text" name="search" placeholder="Search for food..." value="{{ request('search') }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                
                <!-- Category Filter -->
                <div style="min-width: 200px;">
                    <select name="category" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Search Button -->
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Search</button>
                
                @if(request('search') || request('category'))
                    <a href="{{ route('menu.index') }}" class="btn btn-danger" style="padding: 0.75rem 1.5rem;">Clear</a>
                @endif
            </form>
        </div>

        <!-- Featured Items Section -->
        @if($featuredItems->isNotEmpty() && !request('search') && !request('category'))
            <div style="margin-bottom: 3rem;">
                <h2 style="color: #2c3e50; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    ⭐ Featured Items
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                    @foreach($featuredItems as $item)
                        <div class="card" style="overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                            <a href="{{ route('menu.show', $item) }}" style="text-decoration: none; color: inherit;">
                                @if($item->image)
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 3rem;">🍽️</div>
                                @endif
                                
                                <div style="padding: 1.5rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                        <h3 style="color: #2c3e50; margin: 0; font-size: 1.2rem;">{{ $item->name }}</h3>
                                        <span style="background: #fff3cd; color: #856404; padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem;">⭐</span>
                                    </div>
                                    <p style="color: #999; font-size: 0.85rem; margin-bottom: 0.75rem;">{{ $item->category->name }}</p>
                                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.4;">{{ Str::limit($item->description, 80) }}</p>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #27ae60; font-size: 1.3rem; font-weight: bold;">TZS {{ number_format($item->price, 2) }}</span>
                                        <span class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.9rem;">View Details</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Items Section -->
        <div>
            <h2 style="color: #2c3e50; margin-bottom: 1.5rem;">
                @if(request('search'))
                    Search Results for "{{ request('search') }}"
                @elseif(request('category'))
                    {{ $categories->firstWhere('id', request('category'))->name ?? 'Category' }}
                @else
                    All Items
                @endif
                <span style="color: #999; font-size: 1rem; font-weight: normal;">({{ $foodItems->count() }} items)</span>
            </h2>

            @if($foodItems->isEmpty())
                <div class="card" style="padding: 3rem; text-align: center;">
                    <h3 style="color: #999; margin-bottom: 0.5rem;">No items found</h3>
                    <p style="color: #666;">Try adjusting your search or filters</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-primary" style="margin-top: 1rem;">View All Items</a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                    @foreach($foodItems as $item)
                        <div class="card" style="overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                            <a href="{{ route('menu.show', $item) }}" style="text-decoration: none; color: inherit;">
                                @if($item->image)
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 3rem;">🍽️</div>
                                @endif
                                
                                <div style="padding: 1.5rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                        <h3 style="color: #2c3e50; margin: 0; font-size: 1.2rem;">{{ $item->name }}</h3>
                                        @if($item->is_featured)
                                            <span style="background: #fff3cd; color: #856404; padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem;">⭐</span>
                                        @endif
                                    </div>
                                    <p style="color: #999; font-size: 0.85rem; margin-bottom: 0.75rem;">{{ $item->category->name }}</p>
                                    <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.4;">{{ Str::limit($item->description, 80) }}</p>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #27ae60; font-size: 1.3rem; font-weight: bold;">TZS {{ number_format($item->price, 2) }}</span>
                                        <span class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.9rem;">View Details</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection