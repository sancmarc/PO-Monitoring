<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'product_name' => 'required|unique:products',
        ]);
        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $product = new Product();
            $product->product_name = strtoupper($request->product_name);
            $product->save();
            if ($product) {
                return response()->json(['code' => 1, 'msg' => 'Product Successfully Added']);
            } else {
                return response()->json(['code' => 2, 'msg' => 'Product Error']);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $product = Product::all();
        return DataTables::of($product)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                        <button class="btn btn-sm btn-success" data-id="' . $row['id'] . '" id="editBtn">Edit</button>
                        <button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deleteBtn">Delete</button>
                    </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $product_id = $request->product_id;
        $productDetails = Product::find($product_id);
        return response()->json(['details'=>$productDetails]);
    }

    public function updateProduct(Request $request)
    {
        $product_id = $request->prod_id;

        $validator = \Validator::make($request->all(),[
            'product_name'=>'required|unique:products,product_name,'.$product_id,
        ]);
       
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $product = Product::find($product_id);
            $product->product_name = $request->product_name;
            $query = $product->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Something went wrong']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Product has been updated']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product_id = $request->product_id;
        $productDetails = Product::where('id', $product_id);
        $query_delete = $productDetails->delete();

        if (!$query_delete) {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'Product has been deleted']);
        }
    }
}
