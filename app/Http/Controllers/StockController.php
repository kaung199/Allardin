<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Stock;

class StockController extends Controller
{
    public function index()
    {
        $inStocks = Product::all();
        $products = Stock::where('date', date('Y-m-d'))->latest()->get();

        $p_id = $products->pluck('product_id');        

        $inComplete = Product::whereNotin('id', $p_id)->get();
        $completed = Product::whereIn('id', $p_id)->get();

        $count_inC = count($inComplete);
        $count_c = count($completed);

        return view('stock.index', \compact('products', 'inStocks', 'count_inC', 'count_c', 'inComplete', 'completed'));
    }
    
    public function search(Request $request)
    {
        // dd($request->all());
        $inStocks = Product::all();
        $products = Stock::whereBetween('date', [$request->start_date, $request->end_date])->get();

        $p_id = $products->pluck('product_id');        

        $inComplete = Product::whereNotin('id', $p_id)->get();
        $completed = Product::whereIn('id', $p_id)->get();

        $count_inC = count($inComplete);
        $count_c = count($completed);

        return view('stock.index', \compact('products', 'inStocks', 'count_inC', 'count_c', 'inComplete', 'completed'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'product_id' => 'required',
            'qty' => 'required',
            'date' => 'required',
        ]);
        $stock =  Stock::create($request->all());
        $stock->r_qty  = $request->qty;
        $stock->save();
        return redirect()->back()->with('success', 'Successfully Created!');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'product_id' => 'required',
            'qty' => 'required'
        ]);
        $stock = Stock::find($id)->update([
            'qty' => $request->qty,
            'r_qty' => $request->qty
        ]);

        return redirect()->back()->with('success', 'Successfully Created!');
    }
}
