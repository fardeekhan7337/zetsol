<div class="row">
    @if ($total_products > 0)
    <div class="col-sm-12">
        <a href="{{ route('checkout') }}" class="btn btn-sm btn-primary" style="float:right;">Proceed to checkout</a>
        <button class="btn btn-sm btn-dark" id="clear_all_cart" style="float:right;margin-right:10px;">Clear Cart</button>
    </div>
    @endif
    <div class="col-sm-12">

        <div class="table-responsive">

            <table class="table">
                <thead>
                <tr>
                    <th  style="width:40%;">Product</th>
                    <th style="width:10%;">Qty</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cartProducts as $product)
                    
                <tr>
                    
                    <td>{{ $product->name }}</td>
                    <td>
                        <input type="number" class="form-control item_qty" name="quantity" value="{{ $product->quantity }}" /> 
                        <button class="btn btn-sm btn-outline-secondary update_cart_product" data-row-id="{{ $product->id }}">Update</button>
                    </td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity * $product->price }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove_cart_product_" data-row-id="{{ $product->id }}">
                            X
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <th colspan="5">No product added...</th>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
        
    </div>
   
</div>
