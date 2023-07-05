<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceOrderRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\Stock;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    
    public function products()
    {
        
        $data = [

            'page_head' => 'Products',
            'categories' => Category::all()

        ];

        return view('website.products',$data);

    }

    public function getAllProducts(Request $request)
    {

        $title = $request->title;
        $cat_id = $request->cat_id;
        
        $products = Products::with('category')
            ->when($title, function ($query) use ($title) {
                return $query->where('title', 'LIKE', '%' . $title . '%');
            })
            ->when($cat_id, function ($query) use ($cat_id) {
                return $query->where('cat_id', $cat_id);
            })
            ->whereHas('category')
            ->get();

        $html = view('website.products_list',compact('products'))->render();

        return response()->json(['html' => $html]);
        

    }

    public function add_to_cart_product(Request $request)
    {

        $product = Products::find($request->product_id);

        $arr = [

            'id' => $product->id,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => 1
            
        ];
        
        \Cart::add($arr);

        return response()->json(['status' => true]);
        
    }

    public function getAllCartProducts()
    {

        $cartProducts = \Cart::getContent();
        
        $total_products = count($cartProducts);
        
        $html = view('website.cart_products',compact('cartProducts','total_products'))->render();

        return response()->json(['products' => $html,'total_products' => $total_products]);
        
    }
    public function updateCart(Request $request)
    {
        
        if($request->qty > 0)
        {
            $update_qty_arr =  [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->qty
                ],
            ];
            
            \Cart::update(
                $request->product_id,
                $update_qty_arr
            );
        }
        else
        {
            \Cart::remove($request->product_id);
        }

        return response()->json(['status' => true]);
        
    }

    public function removeProduct(Request $request)
    {
        
        \Cart::remove($request->product_id);

        return response()->json(['status' => true]);
        
    }

    public function clearAllCart()
    {

        \Cart::clear();
        return response()->json(['status' => true]);
    }

    public function checkout()
    {

        $cartProducts = \Cart::getContent();

        $total_amount = \Cart::getTotal();
        $total_products = count($cartProducts);

        if($total_products <= 0)
        {
            return redirect()->route('products')->with('_error','Cart is empty');
        }

        $data = [

            'page_head' => 'Checkout',
            'cartProducts' => $cartProducts,
            'total_products' => $total_products,
            'total_amount' => $total_amount

        ];

        return view('website.checkout',$data);

    }
    public function placeOrder(PlaceOrderRequest $request)
    {
        $cartProducts = \Cart::getContent();

        $total_products = count($cartProducts);

        if($total_products <= 0)
        {
            return redirect()->route('products')->with('_error','Cart is empty');
        }

        $stock_products = [];
        foreach($cartProducts as $cart_product)
        {

            $product = Products::find($cart_product->id);

            if($cart_product->quantity > $product->available_qty)
            {
                $stock_products[] = [
                    'title' => $product->title,
                    'available' => $product->available_qty,
                    'order_qty' => $cart_product->quantity,
                    'type' => 'out of stock'
                ];
            }
        }

        $order_arr = [
            'order_no' => rand(10000,99999),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'total_price' => $request->total_price,
            'address' => $request->address,
        ];

        $order = Order::create($order_arr);

        if($order)
        {

            $order_details = [];
            $remove_stock = [];
            foreach($cartProducts as $cart_product)
            {
                $product = Products::find($cart_product->id);
    
                if($cart_product->quantity <= $product->available_qty)
                {

                    $amount = $cart_product->quantity *$cart_product->price;
                    
                    $order_details[] = [
                        'order_id' => $order->id,
                        'product_id' => $cart_product->id,
                        'qty' => $cart_product->quantity,
                        'price' => $cart_product->price,
                        'amount' => $amount,
                    ];

                    $remove_stock[] = [
                        'product_id' => $cart_product->id,
                        'type' => 'remove',
                        'qty' => $cart_product->quantity,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    $stock_products[] = [
                        'title' => $product->title,
                        'order_qty' => $cart_product->quantity,
                        'type' => 'order'
                    ];

                }

            }

            if($order_details)
            {
                
                $is_order_details = OrderDetail::insert($order_details);
                
                if($is_order_details)
                {
                    Stock::insert($remove_stock);
                }
                
                // clear cart
                \Cart::clear();

                $data = [

                    'page_head' => 'Order products',
                    'stock_products' => $stock_products,
                    
                ];

                return view('website.order_products',$data);
                
            }

        }
        else
        {
            return redirect()->back()->with('_error','Connection error..');
        }
        
    }

}