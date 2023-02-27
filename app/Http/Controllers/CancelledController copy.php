<?php

namespace App\Http\Controllers;

use App\Models\billingMonitoring;
use App\Models\Cancelled;
use App\Models\pomonitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CancelledController extends Controller
{
 
    public function create(Request $request){
        $validator = \Validator::make($request->all(),[
            'cancelled_date'=>'required',
            'cancelled_qty'=>'required|numeric',
        ]);
        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            
            $po_id = $request->billed_id;
           
            $get_balance_qty = pomonitor::where('po_no',$po_id)->first();

            $po_balance_qty = $get_balance_qty->balance_po;

            // dd($po_balance_qty);

            if($request->cancelled_qty > $po_balance_qty){
                $message = "You only have ". $po_balance_qty." billed quantity";
                return response()->json(['code' => 0, 'msg' => $message]);
            }else{
                
            
                $total_billed = $po_balance_qty - $request->cancelled_qty;

                $get_balance_qty->balance_po = $total_billed;
                $save = $get_balance_qty->save();
                if($save){
                    $cancel = New Cancelled();
                    $cancel->po_ID = $po_id;
                    $cancel->cancelled_date = $request->cancelled_date;
                    $cancel->cancelled_qty = $request->cancelled_qty;
                    $cancel->insert_by = Auth::user()->id;
        
                    $query = $cancel->save();
        
                    if (!$query) {
                        
                        return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
                    } else {
                        return response()->json(['code' => 1, 'msg' => 'Cancelled Billing has been successfully saved!']);
                    }
                }else{
                    return response()->json(['code' => 0, 'msg' => 'Error']);
                }
                
            }

            

        }
        
    }
}
