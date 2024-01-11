<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use PDF;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('Inventory_Apps.inven.tableProductData', compact('products'));
    }


    public function create()
    {
        $staff_sales = User::where('position', "Staff Sales")->get();
        $product_type = ProductType::all();
        return view('Inventory_Apps.inven.createProduct', compact('staff_sales', 'product_type'));
    }

    public function store(Request $request)
    {
        $products = Product::create($request->all());
        return redirect('supplier/product')->with('Success', 'Successful Data added!');
        $products->save();
    }

    public function show($id)
    {
        $products = Product::findOrFail($id);
        return view('Inventory_Apps.inven.createPr', ['createProduct' => $products]);
    }

    public function edit($id)
    {
        $products = Product::findOrFail($id);
        $staff_sales = User::where('position', "Staff Sales")->get();
        $product_type = ProductType::all();
        return view('Inventory_Apps.inven.editProduct', compact('products', 'staff_sales', 'product_type'));
    }

    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'product_name'      => 'required',
            'user_id'           => 'required',
            'type_id'           => 'required',
            'product_price'     => 'required',
            'product_quantity'  => 'required',
            'desc'              => 'required',
        ]);
        $products = Product::findOrFail($id);
        $products->update([
            'product_name'      => $request->product_name,
            'user_id'           => $request->user_id,
            'type_id'           => $request->type_id,
            'product_price'     => $request->product_price,
            'product_quantity'  => $request->product_quantity,
            'desc'              => $request->desc
        ]);

        return redirect('supplier/product');
    }

    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        $products->delete();

        return redirect('supplier/product');
    }

}