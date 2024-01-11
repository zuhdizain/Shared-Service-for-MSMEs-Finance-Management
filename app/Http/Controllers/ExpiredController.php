<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Expired;
use App\Models\Product;
use PDF;

class ExpiredController extends Controller
{
    public function index()
    {
        $expireds = Expired::all();
        return view('Inventory_Apps.inven.tableExpiredData', compact('expireds'));
    }

    public function create()
    {
        $expireds = Product::all();
        return view('Inventory_Apps.inven.createExpired', compact('expireds'));
    }

    public function store(Request $request)
    {
        // $expireds = Expired::create($request->all());

        $rt = json_decode($request->product_id);
        $product = Product::where('id', $rt->id)->first();

        if ($request->quantity > $product->product_quantity) {
            return redirect()->back();
        } else {
            $data = Expired::create([
                'product_id'    => $rt->id,
                'product_code'  => $rt->product_code,
                'expired'        => $request->expired,
                'price'         => $request->price,
                'quantity'      => $request->quantity,
                'desc'          => $request->desc,
            ]);
    
            $data->save();

            $product->update([
                'product_quantity'         => ($product->product_quantity - $request->quantity) 
            ]);
        }

        return redirect('supplier/expired')->with('Success', 'Successful Data added!');
    }

    public function show($id)
    {
        $expireds = Expired::findOrFail($id);
        return view('Inventory_Apps.inven.createExpired', ['createExpired' => $expireds]);
    }

    public function edit($id)
    {
        $expireds = Expired::findOrFail($id);
        return view('Inventory_Apps.inven.editExpired', ['expireds' =>$expireds]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'expired'              => 'required',
            'price'          => 'required',
            'quantity'          => 'required',
            'desc'              => 'required'
        ]);
        $expireds = Expired::findOrFail($id);
        $expireds->update([
            'expired'              => $request->expired,
            'price'          => $request->price,
            'quantity'          => $request->quantity,
            'desc'              => $request->desc
        ]);

        return redirect('supplier/expired');
    }

    public function destroy($id)
    {
        $expireds = Expired::findOrFail($id);
        $expireds->delete();

        return redirect('supplier/expired');
    }
}