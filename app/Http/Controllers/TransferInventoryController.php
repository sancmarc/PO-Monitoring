<?php

namespace App\Http\Controllers;

use App\Models\billingMonitoring;
use App\Models\TransferInventory;
use Illuminate\Http\Request;

class TransferInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'date_delivered' => 'required',
            'out_delivered' => 'required',
        ]);
        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $transfer = new TransferInventory();
            $transfer->billed_id = $request->transferID;
            $transfer->date_delivery = $request->date_delivered;
            $transferOut = $request->out_delivered;
            $transfer->out_delivered = $transferOut;

            $getBilled = billingMonitoring::find($request->transferID);
            $fetchbilled = $getBilled->billed_qty;

            $out = $fetchbilled - $transferOut;

            if ($out >= 0) {

                $transfer->save();
                $getBilled->billed_qty = $out;
                $query = $getBilled->save();
                if (!$query) {
                    return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
                } else {
                    return response()->json(['code' => 1, 'msg' => 'Transfer Inventory has been saved']);
                }
            } else {
                return response()->json(['code'=>2,'msg'=>'Transfer Inventory Error']);
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
     * @param  \App\Models\TransferInventory  $transferInventory
     * @return \Illuminate\Http\Response
     */
    public function show(TransferInventory $transferInventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransferInventory  $transferInventory
     * @return \Illuminate\Http\Response
     */
    public function edit(TransferInventory $transferInventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransferInventory  $transferInventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransferInventory $transferInventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransferInventory  $transferInventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransferInventory $transferInventory)
    {
        //
    }
}
