<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\StockRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Products;
use App\Models\Stock;
use Illuminate\Http\Request;
use DataTables;
class AdminController extends Controller
{
    
    public function products(Request $request)
    {
        
        if($request->ajax())
        {
            $data = Products::with('category','stocks')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('available_qty',function($row){
                        
                        $qty = $row->available_qty;
                        return $qty;
                        
                    })
                    ->addColumn('action', function($row){

                        $btn = '<span class="action-buttons">';
                        
                           $btn .= '<a href="'. route('admin:edit_product',$row->id) .'" class="edit btn btn-primary btn-sm">Edit</a>';
                           $btn .= '<a href="javascript:void(0)" data-id="'. $row->id .'" class="delete_row btn btn-danger btn-sm">Delete</a>';
                           $btn .= '<a href="'. route('admin:view_product',$row->id) .'" class="edit btn btn-secondary btn-sm">View</a>';

                        $btn .= '<span>';

                        return $btn;
                            
                    })
                    ->rawColumns(['available_qty','action'])
                    ->make(true);
        }
        
        $data = [

            'page_head' => 'Products',

        ];

        return view('admin.products.list',$data);
        
    }

    public function add_product()
    {
        
        $data = [

            'page_head' => 'Add New Product',
            'categories' => Category::all()

        ];

        return view('admin.products.create',$data);

    }

    public function save_product(ProductRequest $request)
    {

        $fileName = '';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');
        }
    
        $arr = [
            'image' => $fileName,
            'title' => $request->title,
            'price' => $request->price,
            'cat_id' => $request->cat_id,
            'description' => $request->description,
        ];

        $product = Products::create($arr);
        
        if($product)
        {
            
            $stock_arr = [
                'product_id' => $product->id,
                'qty' => $request->stock,
                'type' => 'add',
            ];

            Stock::create($stock_arr);
            return redirect()->route('admin:products')->with('_success','Product added successfully');

        }
        else
        {
            return redirect()->back()->with('_error','Connection error');
        }

    }

    function edit_product($pro_id)
    {

        $product = Products::find($pro_id);
        
        if($product)
        {

            $data = [

                'page_head' => 'Edit Product',
                'categories' => Category::all(),
                'product' => $product,
    
            ];
    
            return view('admin.products.edit',$data);
            
        }
        else
        {
            return redirect()->back()->with('_error','Product not found');
        }
        
    }

    public function update_product(ProductRequest $request,$product_id)
    {
        
        $product = Products::find($product_id);

        $product->title = $request->title;
        $product->price = $request->price;
        $product->cat_id = $request->cat_id;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            // Delete the previous image file if it exists
            Storage::disk('public')->delete('uploads/' . $product->image);
        
            // Upload the new image file
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');
        
            $product->image = $fileName;
        }

        // update product
        $product->save();

        return redirect()->route('admin:products')->with('success', 'Product updated successfully');
        
    }

    public function delete_product($product_id)
    {

        // delete all stock of product
        Stock::where('product_id',$product_id)->delete();
        $product = Products::findOrFail($product_id);
        
        $product->delete();
        
        return redirect()->route('admin:products')->with('_success', 'Product deleted successfully');        

    } 
    public function view_product($pro_id)
    {

        $product = Products::with('category','stocks')->find($pro_id);
        
        if($product)
        {

   
            $data = [

                'page_head' => 'View Product',
                'product' => $product,
                'available_qty' => $product->available_qty,
    
            ];
    
            return view('admin.products.view',$data);
            
        }
        else
        {
            return redirect()->back()->with('_error','Product not found');
        }
        
    }

    //stock start
    public function stocks(Request $request)
    {
        
        if($request->ajax())
        {
            $data = Stock::with('product')->whereHas('product')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    // ->addColumn('action', function($row){

                    //     $btn = '<span class="action-buttons">';
                        
                   
                    //        $btn .= '<a href="javascript:void(0)" data-id="'. $row->id .'" class="delete_row btn btn-danger btn-sm">Delete</a>';
                  

                    //     $btn .= '<span>';

                    //     return $btn;
                            
                    // })
                    // ->rawColumns(['action'])
                    ->make(true);
        }
        
        $data = [

            'page_head' => 'Stocks',

        ];

        return view('admin.stock.list',$data);
        
    }

    public function add_stock()
    {
        
        $data = [

            'page_head' => 'Add Stock',
            'products' => Products::all()

        ];

        return view('admin.stock.add',$data);

    }

    public function remove_stock()
    {
        
        $data = [

            'page_head' => 'Remove Stock',
            'products' => Products::all()

        ];

        return view('admin.stock.remove',$data);

    }

    public function save_stock(StockRequest $request)
    {
        
        if($request->type != 'add')
        {

            $product = Products::find($request->product_id);

            if($product->available_qty < $request->stock)
            {

                return redirect()->back()->with('_error','The product available stock is: '. $product->available_qty);
            }

        }

        $stock_arr = [
            'product_id' => $request->product_id,
            'qty' => $request->stock,
            'type' => $request->type,
        ];

        
        $stock = Stock::create($stock_arr);

        if($stock)
        {

            $stock_type = $request->type == 'add'?'added':'removed';
            return redirect()->route('admin:stocks')->with('_success','Stock '. $stock_type .' successfully');
            
        }
        else
        {
            return redirect()->back()->with('_error','Connection error');
        }

    }

    public function orders(Request $request)
    {
        
        if($request->ajax())
        {
            $data = Order::has('orderDetails')->with('orderDetails')->orderBy('id','desc')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('total_products',function($row){
                        
                        $total_products = $row->orderDetails()->count();
                        return $total_products;
                        
                    })
                    ->addColumn('order_status',function($row){
                        
                        $badge_color = 'secondary update_status';
                        if($row->status == 'accept')
                        {
                            $badge_color = 'success';
                        }
                        else if($row->status == 'reject')
                        {
                            $badge_color = 'danger';
                        }
                        
                        $html = '<button class="btn btn-sm btn-outline-'. $badge_color .' " data-id="'. $row->id .'">'. ucfirst($row->status) .'</button>';
                        return $html;
                    })
                    ->addColumn('action', function($row){

                        $btn = '<span class="action-buttons">';
                        
                           $btn .= '<a href="'. route('admin:view_order',$row->id) .'" class="btn btn-secondary btn-sm">View</a>';

                        $btn .= '<span>';

                        return $btn;
                            
                    })
                    ->rawColumns(['total_products','order_status','action'])
                    ->make(true);
        }
        
        $data = [

            'page_head' => 'Orders',

        ];

        return view('admin.orders.list',$data);
        
    }

    public function view_order($order_id)
    {

        $order = Order::has('orderDetails')->with('orderDetails','orderDetails.product')->find($order_id);

        if($order)
        {

            $data = [

                'page_head' => 'View Order',
                'order' => $order
            ];
    
            return view('admin.orders.view',$data);
            
        }
        else
        {
            return redirect()->back()->with('_error','Order not found');
        }
        
    }
    public function update_order_status(Request $request)
    {

        
        $order = Order::has('orderDetails')->with('orderDetails')->find($request->order_id);

        if($order)
        {

            $order_arr = [
                'status' => $request->status
            ];

            Order::where('id',$request->order_id)->update($order_arr);

            $stock_arr = [];
            foreach($order->orderDetails as $od)
            {
                
                $stock_arr[] = [

                    'product_id' => $od->product_id,
                    'qty' => $od->qty,
                    'type' => 'add',
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                    
                ];
            }
           

            if($stock_arr)
            {
                Stock::insert($stock_arr);
            }

            $output = [
                'status' => true,
                'redirect' => route('admin:orders'),
                'msg' => 'Order status updated',
            ];
            
        }
        else
        {

            $output = [
                'status' => false,
                'redirect' => route('admin:orders'),
                'msg' => 'Order not found',
            ];
            
        }


        return response()->json($output);

    }
    
}