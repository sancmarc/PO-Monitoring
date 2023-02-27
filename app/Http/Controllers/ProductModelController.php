<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.add-model');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'modelProduct' => 'required|unique:product_models',
        ]);
        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $model = new ProductModel();
            $model->modelProduct = strtoupper($request->modelProduct);
            $model->save();
            if ($model) {
                return response()->json(['code' => 1, 'msg' => 'Model Successfully Added']);
            } else {
                return response()->json(['code' => 2, 'msg' => 'Model Error']);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductModel  $productModel
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $model = ProductModel::all();
        return DataTables::of($model)
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                    <button class="btn btn-sm btn-success" data-id="' . $row['id'] . '" id="editBtn">Edit</button>
                    <button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deleteBtn">Delete</button>
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function edit(Request $request)
    {
        $model_id = $request->model_id;
        $modelDetails = ProductModel::find($model_id);
        return response()->json(['details'=>$modelDetails]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductModel  $productModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $model_id = $request->mod_id;
        $validator = \Validator::make($request->all(),[
            'modelProduct'=>'required|unique:product_models,modelProduct,'.$model_id,
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $model = ProductModel::find($model_id);
            $model->modelProduct = $request->modelProduct;
            $query = $model->save();
            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Something went wrong']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Model has been updated']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductModel  $productModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model_id = $request->model_id;
        $productDetails = ProductModel::where('id', $model_id);
        $query_delete = $productDetails->delete();

        if (!$query_delete) {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'Model has been deleted']);
        }
    }
}
