

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    {{ $page_head }}
                    <span>
                        <a href="{{ route('admin:products') }}" style="float: right;">Products</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="container">
        
                        <form action="{{ route('admin:save_product') }}" method="post" enctype="multipart/form-data">

                            @csrf
                        <div class="row">

                            <div class="col-sm-12">

                                <div class="form-group">
                                    <label for="image">Image File:</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    @error('image')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                
                                <div class="form-group">
                                    <label for="title">Product Title:</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" />
                                    @error('title')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                
                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <select name="cat_id" id="cat_id" class="form-control">
                                        <option value="">select</option>
                                        @foreach ($categories as $cat)
                                            
                                            <option value="{{ $cat->id }}" {{ old('cat_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            
                                        @endforeach
                                    </select>
                                    @error('cat_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">

                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <input type="number" class="form-control" id="price" step="any" name="price" value="{{ old('price') }}" />
                                    @error('price')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">

                                <div class="form-group">
                                    <label for="stock">Stock:</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" />
                                    @error('stock')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">

                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary mt-4">Submit</button>
                                </div>
                            </div>
                        </div>
                        </form>
                      </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
