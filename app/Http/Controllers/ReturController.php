<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Retur;
use App\Models\Product;

class ReturController extends Controller
{
    public function index()
    {
        $returns = Retur::all();
        return view('Inventory_Apps.inven.tableReturnData', compact('returns'));
    }

    public function create()
    {
        $returns = Product::all();
        return view('Inventory_Apps.inven.createReturn', compact('returns'));
    }

    public function store(Request $request)
    {
        // $returns = Retur::create($request->all());

        $rt = json_decode($request->product_id);
        $product = Product::where('id', $rt->id)->first();

        if ($request->quantity > $product->product_quantity) {
            return redirect()->back();
        } else {
            $data = Retur::create([
                'product_id'    => $rt->id,
                'product_code'  => $rt->product_code,
                'return'        => $request->return,
                'price'         => $request->price,
                'quantity'      => $request->quantity,
                'desc'          => $request->desc,
                'date'          => $request->date,
            ]);
     
            $data->save();
    
            $product->update([       
                'product_quantity'         => ($product->product_quantity + $request->quantity) 
            ]);
        }

        return redirect('supplier/retur')->with('Success', 'Successful Data added!');
    }

    public function show($id)
    {
        $returns = Retur::findOrFail($id);
        return view('Inventory_Apps.inven.createReturn', ['createReturn' => $returns]);
    }

    public function edit($id)
    {
        $returns = Retur::findOrFail($id);
        return view('Inventory_Apps.inven.editReturn', ['returns' =>$returns]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'return'              => 'required',
            'price'          => 'required',
            'quantity'          =>'required',
            'date'             => 'required',
            'desc'              => 'required'
        ]);
        $returns = Retur::findOrFail($id);
        $returns->update([
            'return'              => $request->return,
            'price'          => $request->price,
            'quantity'      =>$request->quantity,
            'date'             => $request->date,
            'desc'              => $request->desc
        ]);

        return redirect('supplier/retur');

    }

    public function destroy($id)
    {
        $returns = Retur::findOrFail($id);
        $returns->delete();

        return redirect('supplier/retur');
    }
}