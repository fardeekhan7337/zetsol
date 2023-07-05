

@extends('layouts.website')
@section('css')
<style>
    .product_card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      max-width: 300px;
      margin: auto;
      text-align: center;
      font-family: arial;
      margin-bottom: 15px;
    }
    
    .product_info {
      color: grey;
      font-size: 15px;
    }

    .product-card-img
    {
        width : 100%;
        height: 200px;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        padding:10px;
    }
    
    .product-card-img img
    {
        width : 100%;
        height: 200px;
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
                        <div class="col-sm-6">

                            <div class="row">
                                <div class="col-sm-12">
                                    
                                    <form action="javascript:void(0)" method="post" id="filter_products_">

                                        <div class="row">
                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label for="title">Product Title:</label>
                                                    <input type="text" class="form-control" id="title" name="title" />
                                            
                                                </div>
                                            </div>
                                            <div class="col-sm-6">

                                                <div class="form-group">
                                                    <label for="title">Category</label>
                                                    <select name="cat_id" id="cat_id" class="form-control">
                                                        <option value="">select</option>
                                                        @foreach ($categories as $cat)
                                                            
                                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                            
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </form>

                                </div>
                                <hr />
                                <div class="col-sm-12" >
                                    
                                    <div class="row" id="show_products_">
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6" >

                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="mt-2">Total Cart Items : <span id="total_cart_items">0</span></h4>
                                </div>
                                <hr />
                                <div class="col-sm-12 mt-2" id="cart_products_">


                                   
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
@section('script')
    
<script>

    $(function(){

        // get products
        getAllProducts()

        // get carts products
        getAllCartProducts()

    })

    $('#filter_products_').submit(function (e) {
        
        e.preventDefault()

        getAllProducts()

    })

    function getAllProducts()
    {   

        let data = $('#filter_products_').serialize()

        $.ajax({
            type : "post",
            url : "{{ route('getAllProducts')}}",
            data : data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                $('#show_products_').html(response.html)
            }
        })

    }


    // add to cart

    function getAllCartProducts()
    {

        $.ajax({
            type : "get",
            url : "{{ route('getAllCartProducts')}}",
            dataType: 'json',
            success: function (response) {
                
                $('#cart_products_').html(response.products)

                $('#total_cart_items').text(response.total_products)
                
            }
        })

    }

    $(document).on('click','.add_to_cart',function () {

        let product_id = $(this).attr('data-id')

        add_product_in_cart(product_id)

    })


    function add_product_in_cart(product_id)
    {

        $.ajax({
            type : "post",
            url : "{{ route('add_to_cart_product')}}",
            data : {product_id : product_id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                
                if(response.status == true)
                {

                    getAllCartProducts()

                }
            }
        })

    }

    // update_cart_product

    $(document).on('click','.update_cart_product',function () {
        
        let product_id = $(this).attr('data-row-id')
        let qty = $(this).closest('tr').find('.item_qty').val()

        $.ajax({
            type : "post",
            url : "{{ route('cart.update')}}",
            data : {product_id : product_id, qty : qty},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                
                if(response.status == true)
                {

                    getAllCartProducts()

                }
            }
        })


    })

    // remove cart product

    $(document).on('click','.remove_cart_product_',function () {
        
        let row_id = $(this).attr('data-row-id')

        $.ajax({
            type : "post",
            url : "{{ route('cart.remove')}}",
            data : {product_id : row_id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                if(response.status == true)
                {

                    getAllCartProducts()

                }

            }
        })

    })


    // clear cart
    
    $(document).on('click','#clear_all_cart',function () {

   
        $.ajax({
            type : "post",
            url : "{{ route('cart.clear')}}",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                if(response.status == true)
                {

                    getAllCartProducts()

                }

            }
        })

    })
    
</script>

@endsection
