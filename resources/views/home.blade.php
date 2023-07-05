@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{ route('admin:products') }}">Products</a>
                        </div>
                        <div class="col-sm-12">
                            
                            <a href="{{ route('admin:stocks') }}">Stocks</a>
                        </div>
                        <div class="col-sm-12">

                            <a href="{{ route('admin:orders') }}">Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
