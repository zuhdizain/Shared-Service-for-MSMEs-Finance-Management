<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Good;

class GoodController extends Controller
{
    public function index()
    {
        $goods = Good::all();
        return view('Inventory_Apps.inven.tableGoodsData', compact('goods'));
    }

    public function create()
    {
        return view('Inventory_Apps.inven.createGoods');
    }

    public function store(Request $request)
    {
        $goods = Good::create($request->all());
        return redirect('supplier/good')->with('Success', 'Successful Data added!');
    }

    public function show($id)
    {
        $goods = Good::findOrFail($id);
        return view('Inventory_Apps.inven.createGoods', ['createGoods' => $goods]);
    }

    public function edit($id)
    {
        $goods = Good::findOrFail($id);
        return view('Inventory_Apps.inven.editGoods', ['goods' =>$goods]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'good'              => 'required',
            'supplier'          => 'required',
            'price'             => 'required',
            'quan'              => 'required',
            'desc'              => 'required'
        ]);
        $goods = Good::findOrFail($id);
        $goods->update([
            'good'              => $request->good,
            'supplier'          => $request->supplier,
            'price'             => $request->price,
            'quan'              => $request->quan,
            'desc'              => $request->desc
        ]);

        return redirect('supplier/good');

    }

    public function destroy($id)
    {
        $goods = Good::findOrFail($id);
        $goods->delete();

        return redirect('supplier/good');
    }
}