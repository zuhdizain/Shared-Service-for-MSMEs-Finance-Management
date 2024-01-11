<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Out;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OutExport;


class OutController extends Controller
{
    public function index()
    {
        $outs = Out::all();
        return view('Inventory_Apps.inven.tableOutData', ['outs' => $outs]);
    }

    public function create()
    {
        $outs = Product::all();
        return view('Inventory_Apps.inven.createOut', compact('outs'));
    }



    public function store(Request $request)
    {
        $pr = json_decode($request->product_id);
        $product = Product::where('id', $pr->id)->first();

        if ($request->quantity > $product->product_quantity) {
            return redirect()->back();
        } else {
            $data = Out::create([
                'product_id'    => $pr->id,
                'product_code'  => $pr->product_code,
                'out'           => $request->out,
                'customer'      => $request->customer,
                'price'         => $request->price,
                'quantity'      => $request->quantity,
                'desc'          => $request->desc,
                'date'          => $request->date,
            ]);

            $data->save();

            $product->update([
                'product_quantity' => ($product->product_quantity - $request->quantity)
            ]);
        }
        return redirect('supplier/out');
    }

    public function show($id)
    {
        $outs = Out::findOrFail($id);
        return view('Inventory_Apps.inven.createProduct', ['createProduct' => $outs]);
    }

    public function edit($id)
    {
        $outs = Out::findOrFail($id);
        return view('Inventory_Apps.inven.editOut', ['outs' => $outs]);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'out'       => 'required',
            'customer'  => 'required',
            'price'         => 'required',
            'quantity'         => 'required',
            'desc'         => 'required',
            'date'          => 'required',
        ]);
        $outs = Out::findOrFail($id);
        $outs->update([
            'out'       => $request->out,
            'customer'         => $request->customer,
            'price'         => $request->price,
            'quantity'         => $request->quantity,
            'desc'         => $request->desc,
            'date'          => $request->date
        ]);

        return redirect('supplier/out');
    }

    public function destroy($id)
    {

        $outs = Out::findOrFail($id);

        $product = Product::where('product_code', $outs->product_code)->first();
        $product->update([

            'product_quantity'         => ($product->product_quantity + $outs->quantity)

        ]);
        $outs->delete();

        return redirect('supplier/out');
    }
}
