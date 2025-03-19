@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="mb-3">
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

<div class="row">
  @foreach ($viewData["products"] as $product)
    <div class="col-md-4 col-lg-3 mb-2">
      <div class="card">
        <img src="{{ Storage::url('images/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top">
        <div class="card-body text-center">
          <a href="{{ route('product.show', ['id'=> $product->getId()]) }}" class="btn bg-primary text-white">
            {{ $product->getName() }}
          </a>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
