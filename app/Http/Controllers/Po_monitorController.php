<?php

namespace App\Http\Controllers;

use App\Models\billingMonitoring;
use Illuminate\Http\Request;
use App\Models\pomonitor;
use App\Models\Product;
use App\Models\ProductModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class Po_monitorController extends Controller
{
    public function samplefetch()
    {
        return view('admins.sample');
    }
    function addPO()
    {
        $modelProduct = ProductModel::all();
        $product_name = Product::all();
        return view('admins.add-po', ['modelProduct' => $modelProduct], ['product_name' => $product_name]);
    }

    function submitAddPO(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'received_date' => 'required',
            'model' => 'required',
            'p_n' => 'required',
            'po_no' => 'required',
            'unit_price' => 'required',
            'po_qty' => 'required|numeric',
        ]);
        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $pomonitor = new pomonitor();
            $pomonitor->received_date = $request->received_date;
            $pomonitor->model = $request->model;
            $pomonitor->p_n = $request->p_n;
            $pomonitor->po_no = $request->po_no;
            $pomonitor->unit_price = $request->unit_price;
            $pomonitor->po_qty = $request->po_qty;
            $pomonitor->balance_po = $request->po_qty;
            $query = $pomonitor->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'PO has been successfully saved']);
            }
        }
    }
    function getPOLIST()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->leftJoin('cancelleds', 'pomonitors.id', 'cancelleds.po_ID')
            ->select('pomonitors.id as pom_id', 'pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct','cancelleds.cancelled_qty as cancelled_qty', 'cancelleds.cancelled_date as cancelled_date')
           
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->addColumn('buttons', function ($row) {
                return '<div class="btn-group">
                                        <button class="btn btn-sm btn-warning" data-id="' . $row->pom_id . '" id="cancelBtn">Cancel</button>
                                        <button class="btn btn-sm btn-primary" data-id="' . $row->pom_id . '" id="billBtn">Bill</button>
                                        <button class="btn btn-sm btn-success" data-id="' . $row->pom_id . '" id="editBtn">Edit</button>
                                        <button class="btn btn-sm btn-danger" data-id="' . $row->pom_id . '" id="deleteBtn">Delete</button>
                                    </div>';
            })
            ->rawColumns(['buttons'])
            ->make(true);
    }
    public function edit(Request $request)
    {
        $po_id = $request->po_id;
        $details = pomonitor::find($po_id);
        return response()->json(['details' => $details]);
    }
    public function update(Request $request)
    {
        $po_id = $request->po_id;
        $validator = \Validator::make($request->all(), [
            'received_date' => 'required',
            'model' => 'required',
            'p_n' => 'required',
            'po_no' => 'required',
            'unit_price' => 'required',
            'po_qty' => 'required|numeric',
        ]);
        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $pomonitor = pomonitor::find($po_id);

            $billed_po = billingMonitoring::where('billing_po_no', $po_id)->count();
            if ($billed_po > 0) {
                return response()->json(['code' => 2, 'msg' => 'PO have a billed Please Contact MIS for update Request']);
            } else {
                $pomonitor->received_date = $request->received_date;
                $pomonitor->model = $request->model;
                $pomonitor->p_n = $request->p_n;
                $pomonitor->po_no = $request->po_no;
                $pomonitor->unit_price = $request->unit_price;
                $pomonitor->po_qty = $request->po_qty;
                $pomonitor->balance_po = $request->po_qty;
                $query = $pomonitor->save();

                if (!$query) {
                    return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
                } else {
                    return response()->json(['code' => 1, 'msg' => 'PO has been successfully updated']);
                }
            }
        }
    }
    public function destroy(Request $request)
    {
        $po_id = $request->po_id;
        $check_billed = billingMonitoring::where('billing_po_no', $po_id)->count();
        if ($check_billed == 0) {
            $delete = pomonitor::find($po_id);
            $query = $delete->delete();
            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'PO has been deleted successfully']);
            }
        } else {
            return response()->json(['code' => 0, 'msg' => 'PO have a billing']);
        }
    }
    function getPOBiph()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->select('pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct',)
            ->where('modelProduct', '=', 'BIPH')
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->make(true);
    }
    function getPOBivn()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->select('pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct',)
            ->where('modelProduct', '=', 'BIVN')
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->make(true);
    }
    function getPOPantum()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->select('pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct',)
            ->where('modelProduct', '=', 'PANTUM')
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->make(true);
    }
    function getPODccBc()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->select('pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct',)
            ->where('modelProduct', '=', 'DCC-BC')
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->make(true);
    }
    function getPODccBh()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->select('pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct',)
            ->where('modelProduct', '=', 'DCC-BH')
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->make(true);
    }
    function getPODccUhd()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->select('pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct',)
            ->where('modelProduct', '=', 'DCC-UHD')
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->make(true);
    }
    function getPOPsnm()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->select('pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct',)
            ->where('modelProduct', '=', 'PSNM')
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->make(true);
    }
    function getPOK1()
    {

        $pomonitorwithjoin = DB::Table('pomonitors')
            ->leftJoin('product_models', 'pomonitors.model', '=', 'product_models.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->select('pomonitors.received_date as receiveddate', 'products.product_name as pn', 'pomonitors.po_no as pono', 'pomonitors.unit_price as unitprice', 'pomonitors.po_qty as poqty', 'pomonitors.balance_po as balancepo', 'product_models.modelProduct as modelProduct',)
            ->where('modelProduct', '=', 'K1')
            ->get();
        return DataTables::of($pomonitorwithjoin)
            ->addIndexColumn()
            ->make(true);
    }
}
