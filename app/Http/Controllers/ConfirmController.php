<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Confirm;
use App\Models\Product;
use App\Models\Good;

class ConfirmController extends Controller
{
    public function index()
    {
        $confirms = Confirm::all();

        $products = Product::all();
        $total_products = 0;
        foreach($products as $tot){
            $total_products += $tot->quantity; 
        }

        $goods = Good::all();
        $total_goods = 0;
        foreach($goods as $goo){
            $total_goods += $goo->quan; 
        }

        $goods = Good::all();
        $total_assets_goods = 0;
        foreach($goods as $goo){
            $total_assets_goods += $goo->price; 
        }

        $products = Product::all();
        $total_assets_products = 0;
        foreach($products as $tot){
            $total_assets_products += $tot->price; 
        }

        $total = $total_assets_goods + $total_assets_products;

        return view('Inventory_Apps.website.dashboardInven', compact('confirms', 'total_products', 'total_goods', 'total'));
    }

    public function create()
    {
        return view('Inventory_Apps.website.dashboardInven');
    }

    public function store(Request $request)
    {
        $confirms = Confirm::create($request->all());
        $confirms->save();
        return redirect('supplier/confirm')->with('Success', 'Successful Data added!');
        
    }

    public function destroy(Confirm $confirm)
    {
        Confirm::destroy($confirm->id);

        return redirect('supplier/confirm');
    }
}