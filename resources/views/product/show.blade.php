@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="card mb-3">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="{{ Storage::url('images/' . $viewData['product']->image) }}" alt="{{ $viewData['product']->name }}" class="img-fluid">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">
          {{ $viewData['product']->name }} (${{ $viewData['product']->price }})
        </h5>
        <p class="card-text">{{ $viewData['product']->description }}</p>

        <form method="GET" action="{{ route('product.index') }}">
          <select name="category_id" class="form-select" onchange="this.form.submit()">
            <option value="">Select Category</option>
            @foreach ($viewData['categories'] as $category)
              <option value="{{ $category->id }}" 
                @if(request('category_id') == $category->id) selected @endif>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
        </form>        
      </div>
    </div>
  </div>
</div>
@endsection
