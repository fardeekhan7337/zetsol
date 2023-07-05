

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    {{ $page_head }}
                    <span>
                        <a href="{{ route('admin:stocks') }}" style="float: right;">Stock</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    @if (Session::has('_error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('_error') }}
                        </div>
                    @endif

                    <div class="container">
        
                        <form action="{{ route('admin:save_stock') }}" method="post" >
                            
                            @csrf

                            <input type="hidden" name="type" value="remove">
                        <div class="row">

                          
                            <div class="col-sm-4">
                                
                                <div class="form-group">
                                    <label for="title">Product</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">select</option>
                                        @foreach ($products as $product)
                                            
                                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                                            
                                        @endforeach
                                    </select>
                                    @error('product_id')
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
