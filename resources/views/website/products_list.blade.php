@forelse ($products as $product)
    
<div class="col-sm-6">
    <div class="card product_card">

        <div class="product-card-img">
            <img src="{{ asset('storage/uploads/'.$product->image) }}" alt="product_image"
                 onerror="this.onerror=null;this.src='{{ asset('default.png') }}';" />
        </div>
        <h3 class="mt-3">{{ $product->title }}</h3 >
        <div class="row product_info">

            <div class="col-sm-12">
                <span>
                    Category: {{ $product->category->name }}
                </span>
            </div>
            <div class="col-sm-12">
                <span>
                    Price: {{ $product->price }}
                </span>
            </div>
            <div class="col-sm-12">
                <p>{{ $product->description }} </p>
                
            </div>
        </div>
        <p>
            <button class="btn btn-sm btn-dark add_to_cart" data-id="{{ $product->id }}">Add to Cart</button>
        </p>
    </div>
    
</div>
@empty
<div class="col-sm-12">
    <h4>No product found...</h4>
</div>
    
@endforelse