

@extends('layouts.website')
@section('css')
<style>


    .form-group 
    {
        padding:10px;
    }
    .error-message
    {
        color :#dc3545;
        margin-top: 6px;
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
                        <a href="{{ route('products') }}" style="float: right;">Dashboard</a>
                    </span>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-12">

                            <div class="row">
                                
                                <hr />
                                <div class="col-sm-12" >
                                    
                                            <div class="table-responsive">
                                    
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th  style="width:70%;">Product</th>
                                                        <th style="width:10%;">Qty</th>
                                                        <th>Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($stock_products as $product)
                                                    <tr>
                                                        
                                                        <td>{{ $product['title'] }}</td>
                                                        <td>
                                                            {{ $product['order_qty'] }}
                                                        </td>
                                                        <td>{{ $product['type'] }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <th colspan="3">No product added...</th>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                               
                                            </table>
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
