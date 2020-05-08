<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Product;
use Illuminate\Http\Request;
use App\Sale;
use App\SaleDetail;
use Auth;
use App\Stock;
use DB;

class PosSaleReportController extends Controller
{
    public function report(Request $request)
    {
        $today = Carbon::now()->toDateString();
        $sales = Sale::where('date', $today)->latest()->get();
        return view('pos.report', \compact('sales'));
    }
    public function salesearch(Request $request)
    {
        $sales = Sale::whereBetween('date', [$request->from, $request->to])->get();
        return view('pos.report', \compact('sales'));
    }
    public function detail($id)
    {
        $sale = Sale::find($id);
        return view('pos.detail', \compact('sale'));
    }

    public function dailytotal(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $saleDetails = SaleDetail::whereBetween(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), [$from, $to])
                                ->select('product_id', DB::raw("SUM(qty) as tqty"), DB::raw("SUM(total_price) as tp"))
                                ->groupBy('product_id')->get();
                            
        return view('pos.totalsale', compact('saleDetails'));
    }
}
