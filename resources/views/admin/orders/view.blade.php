

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
                        <a href="{{ route('admin:orders') }}" style="float: right;">Orders</a>
                    </span>
                </div>

                <div class="card-body">
                    
                    <div class="container">
                  
                        <div class="row">
                            <div class="col-sm-12">
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3>Order # {{ $order->order_no }}</h3>
                                        </div>
                                        <div class="col-sm-12">

                                            <label for="full_name">Full Name: <span> {{ $order->full_name ?? ''}}</span></label>
                                        </div>
                                        <div class="col-sm-12">

                                            <label for="Email">Email: <span> {{ $order->email ?? ''}}</span></label>
                                        </div>
                                        <div class="col-sm-12">

                                            <label for="Contact No">Contact No#: <span> {{ $order->contact_no ?? ''}}</span></label>
                                        </div>
                                        <div class="col-sm-12">

                                            <label for="Address">Address: <span> {{ $order->address ?? ''}}</span></label>
                                        </div>
                                       
                                    </div>
                            </div>
                            <hr />
                            <div class="col-sm-12">
                                <h4>Order Products</h4>
                            </div>
                            <div class="col-sm-12" >
                                
                                        <div class="table-responsive">
                                
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th  style="width:70%;">Product</th>
                                                    <th style="width:10%;">Qty</th>
                                                    <th>Price</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($order->orderDetails as $od)
                                                <tr>
                                                    
                                                    <td>{{ $od->product->title ?? '' }}</td>
                                                    <td>
                                                        {{ $od->qty }}
                                                    </td>
                                                    <td>{{ $od->price }}</td>
                                                    <td>{{ $od->amount }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <th colspan="4">No product added...</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" style="text-align:right;">Total: </th>
                                                    <th>{{ $order->total_price }}</th>
                                                </tr>
                                            </tfoot>
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
@endsection
