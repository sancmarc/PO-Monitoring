<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class BiphController extends Controller
{
    public function index()
    {
        return view('admins.biph');
    }

    public function fetchBIPH()
    {
        $billBIPH = DB::Table('billing_monitorings')
            ->leftJoin('pomonitors', 'billing_monitorings.billing_po_no', '=', 'pomonitors.id')
            ->leftJoin('products', 'pomonitors.p_n', '=', 'products.id')
            ->leftJoin('transfer_inventories', 'billing_monitorings.id', 'transfer_inventories.billed_id')
            ->select('billing_monitorings.id as billId', 'billing_monitorings.billing_months as billMonths', 'billing_monitorings.billing_invoice as invoice', 'billing_monitorings.billed_qty as billQty', 'pomonitors.po_no as poNo', 'pomonitors.po_qty as poQty', 'pomonitors.balance_po as balance', 'products.product_name as productName', 'transfer_inventories.date_delivery as delivery', 'transfer_inventories.out_delivered as out')
            ->where('pomonitors.model', '=', '1')
            ->get();
        return DataTables::of($billBIPH)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                <button class="btn btn-sm btn-success" data-id="' . $row->billId . '" id="transfer" title="transfer inventory">Transfer</button>
                            </div>';
                
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function biphPo()
    {
        return view('admins.biph-po');
    }
}
