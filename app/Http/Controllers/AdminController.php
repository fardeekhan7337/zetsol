<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
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

        $product = Products::findOrFail($product_id);
        
        $product->delete();
        
        return redirect()->route('admin:products')->with('_success', 'Product deleted successfully');        

    } 
    function view_product($pro_id)
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

}