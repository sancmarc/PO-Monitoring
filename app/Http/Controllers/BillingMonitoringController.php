<?php

namespace App\Http\Controllers;

use App\Models\billingMonitoring;
use Illuminate\Http\Request;
use App\Models\pomonitor;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class BillingMonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //$po_no = pomonitor::all();
        
        
        $fetch = DB::Table('pomonitors')
        ->leftJoin('product_models', 'pomonitors.model','=','product_models.id')
        ->leftJoin('products', 'pomonitors.p_n','=','products.id')
        ->select('pomonitors.id AS pid','pomonitors.received_date as receiveddate','products.product_name as pn','pomonitors.po_no as pono','pomonitors.unit_price as unitprice','pomonitors.po_qty as poqty','pomonitors.balance_po as balancepo','product_models.modelProduct as modelProduct',)
        ->get();
        return view('admins.billed-po',['pono'=>$fetch]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'months'=>'required',
            'billInvoice'=>'required',
            'po_no'=>'required',
            'billQty'=>'required|numeric',
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $pono = $request->po_no;
            $billed_Qty = $request->billQty;
            $billing = new billingMonitoring();
            $billing->billing_months = $request->months;
            $billing->billing_invoice = $request->billInvoice;
            $billing->billing_po_no = $pono;
            $billing->billed_qty = $billed_Qty; 
            
            $update_balance = pomonitor::find($pono);
            $balance = $update_balance->balance_po;
            $total = $balance - $billed_Qty;
            if($total >= 0){
                $billing->save();
                $update_balance->balance_po = $total;
                $query_update = $update_balance->save();
                if($query_update){
                    return response()->json(['code'=>1,'msg'=>'Invoice Successfully Added']);
                }else{
                    return response()->json(['code'=>2,'msg'=>'Update balance Error']);
                }
            }else{
                return response()->json(['code'=>2,'msg'=>'Update balance Error']);
            }

        }
    }

     // list of bill invoice
     public function show()
     {
        //  $billingMonitoring = billingMonitoring::all();
        //  return DataTables::of($billingMonitoring)
        //                      ->addIndexColumn()
        //                      ->make(true);
        $billingMonitoring = DB::Table('billing_monitorings')
        ->leftJoin('pomonitors','billing_monitorings.billing_po_no','=','pomonitors.id')
        ->leftJoin('transfer_inventories','billing_monitorings.id','transfer_inventories.billed_id')

        ->select('billing_monitorings.id as billId','billing_monitorings.billing_months as billMonths','billing_monitorings.billing_invoice as invoice','billing_monitorings.billed_qty as billQty','pomonitors.po_no as poNo','pomonitors.po_qty as poQty','pomonitors.balance_po as balance','transfer_inventories.date_delivery as delivery','transfer_inventories.out_delivered as out')
        ->get();
        return DataTables::of($billingMonitoring)
                              ->addIndexColumn()
                              ->addColumn('actions', function($row){
                                return '<div class="btn-group">
                                <button class="btn btn-sm btn-success" data-id="' . $row->billId . '" id="editBtn">Edit</button>
                                </div>';
                                 })
                              ->rawColumns(['actions'])
                              ->make(true);
        //return $billingMonitoring;
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\billingMonitoring  $billingMonitoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $billId = $request->billId;
        $details = billingMonitoring::find($billId);
        return response()->json(['details' =>$details]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\billingMonitoring  $billingMonitoring
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'months'=>'required',
            'billInvoice'=>'required',
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $billId = $request->billId;
            $update_billing = billingMonitoring::find($billId);
            $update_billing->billing_months = $request->months;
            $update_billing->billing_invoice = $request->billInvoice;

            $query = $update_billing->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Update Billing Successfully']);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\billingMonitoring  $billingMonitoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(billingMonitoring $billingMonitoring)
    {
        //
    }
}
