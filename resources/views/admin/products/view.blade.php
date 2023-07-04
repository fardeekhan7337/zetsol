

@extends('layouts.app')

@section('css')

    <style>
        
        .product-img
        {
            width : 150px;
            height: 150px;
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
        
        .product-img img
        {
            width : 150px;
            height: 150px;
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

    </style>
@endsection
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
                  
                        <div class="row">

                            <div class="col-sm-3">
                                
                                <div class="product-img">
                                    <img src="{{ asset('storage/uploads/'.$product->image) }}" alt="product_image"
                                         onerror="this.onerror=null;this.src='{{ asset('default.png') }}';" />
                                </div>
                                
                            </div>
                            <div class="col-sm-9">
                                
                                <div class="row">
                                    <div class="col-sm-12">

                                        <label for="title">Product Title: <span> {{ $product->title ?? ''}}</span></label>
                                    </div>
                                    <div class="col-sm-12">

                                        <label for="category">Category: <span> {{ $product->category->name ?? ''}}</span></label>
                                    </div>
                                    <div class="col-sm-12">

                                        <label for="Price">Price: <span> {{ $product->price ?? ''}}</span></label>
                                    </div>
                                    <div class="col-sm-12">

                                        <label for="Stock">Stock: <span> {{ $available_qty ?? ''}}</span></label>
                                    </div>
                                    <div class="col-sm-12">

                                        <label for="Description">Description: <span> {{ $product->description ?? ''}}</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                      </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
