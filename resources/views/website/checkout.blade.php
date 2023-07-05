

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

                    @if (Session::has('_error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('_error') }}
                    </div>
                    @endif
                    @if (Session::has('_success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('_success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-12">

                            <div class="row">
                                <div class="col-sm-12">
                                    
                                    <form action="{{ route('placeOrder') }}" method="post">

                                        @csrf
                                        <input type="hidden" name="total_price" value="{{ $total_amount }}">
                                        <div class="row">
                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label for="Full Name">Full name:</label>
                                                    <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}"/>
                                                    @error('full_name')
                                                        <div class="error-message">{{ $message }}</div>
                                                    @enderror
                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label for="Email">Email:</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"/>
                                                    @error('email')
                                                        <div class="error-message">{{ $message }}</div>
                                                    @enderror
                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label for="Contact No">Contact No:</label>
                                                    <input type="number" class="form-control" id="contact_no" name="contact_no" value="{{ old('contact_no') }}"/>
                                                    @error('contact_no')
                                                        <div class="error-message">{{ $message }}</div>
                                                    @enderror
                                        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">

                                                <div class="form-group">
                                                    <label for="address">Address:</label>
                                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                                    @error('address')
                                                        <div class="error-message">{{ $message }}</div>
                                                    @enderror
                                            
                                                </div>
                                            </div>
                                           
                                            <div class="col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Place Order</button>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </form>

                                </div>
                                <hr />
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
                                                    @forelse ($cartProducts as $product)
                                                    @php
                                                        $amount = $product->quantity * $product->price;
                                                    @endphp
                                                    <tr>
                                                        
                                                        <td>{{ $product->name }}</td>
                                                        <td>
                                                            {{ $product->quantity }}
                                                        </td>
                                                        <td>{{ $product->price }}</td>
                                                        <td>{{ $amount }}</td>
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
                                                        <th>{{ $total_amount }}</th>
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
</div>
@endsection
