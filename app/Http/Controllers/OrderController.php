<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ReturnForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    public function index()
    {
        if (Auth::user()->authorization_level == 2) {
            $order = Order::orderBy('order_date', 'desc')
                ->get();

            return view('Sales_Apps.pages.order.index', compact('order'));
        } else {
            $order = Order::where('user_id', Auth::user()->id)->orderBy('order_date', 'desc')
                ->get();

            return view('Sales_Apps.pages.order.index', compact('order'));
        }
    }

    public function addOrderpage()
    {
        return view('Sales_Apps.pages.order.addOrder');
    }

    public function addOrder(Request $request)
    {
        $validation = $request->validate([
            'date' => 'required',
        ]);

        $invoice = 'INV-' . mt_rand(000000, 999999);

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'order_date' => $validation['date'],
            'invoice' => $invoice
        ]);
        $order->save();

        OrderStatus::create([
            'order_id' => $order->id,
        ])->save();

        return redirect()->route('order.index');
    }

    public function orderEdit($id)
    {
        $order = Order::find($id);
        $customer = Customer::all();
        $product = Product::where('user_id', Auth::user()->id)->get();
        $orderDetail = OrderDetail::where('order_id', $id)->first();

        return view('Sales_Apps.pages.order.editOrder', compact('order', 'orderDetail', 'customer', 'product'));
    }

    public function orderUpdate(Request $request, $id)
    {
        $order = Order::find($id);
        $orderDetail1 = OrderDetail::where('order_id', $id)->get();
        $orderDetail2 = OrderDetail::where('order_id', $id)->first();

        // Update order date 
        $order->update([
            'order_date' => $request->date,
            'delivery_number' => $request->delivery_number,
        ]);

        // Update payment proof
        $orderDetail2->update([
            'payment_proof' => $request->file('file')->store('paymentProof', 'public'),
        ]);

        foreach ($orderDetail1 as $item) {
            $item->update([
                "customer_id" => $request->customer,
                'payment_proof' => $orderDetail2->payment_proof,
            ]);
        }

        // Update order status
        $orderStatus = OrderStatus::where('order_id', $orderDetail2->order_id)->first();
        $orderStatus->update([
            'order_status' => "Pending",
        ]);

        return redirect()->route('order.index');
    }

    public function orderDetailpage($id)
    {
        $orderDetail1 = OrderDetail::where('order_id', $id)->get();
        $orderDetail2 = OrderDetail::where('order_id', $id)->first();

        return view('Sales_Apps.pages.order.detailOrder', compact('orderDetail1', 'orderDetail2'));
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        $orderDetail1 = OrderDetail::where('order_id', $id)->get();

        if ($order->orderStatus->order_status == "Pending") {
            foreach ($orderDetail1 as $item) {
                $product = Product::find($item->product_id);

                // Update product quantity in product
                $product->update([
                    'product_quantity' => ($product->product_quantity + 1),
                ]);
            }
        }

        $path = 'storage/' . $order->orderDetail->first()->payment_proof;
        if (OrderDetail::exists($path)) {
            File::delete($path);
        }

        OrderDetail::where('order_id', $id)->delete();
        OrderStatus::where('order_id', $id)->delete();
        $order->delete();

        return redirect()->back();
    }

    public function updateStatuspage()
    {
        $orderStatuses = ['Pending', 'Sukses', 'Gagal', 'Refund', 'Cancel'];
        
        $order = Order::where('user_id', Auth::user()->id, function ($query) use ($orderStatuses) {
            $query->select('id')
                ->from('order_statuses')
                ->whereIn('order_status', $orderStatuses);
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Sales_Apps.pages.order.editStatus', compact('order'));
    }

    public function updateStatusSuccess($id)
    {
        $orderStatus = OrderStatus::where('order_id', $id)->first();
        $orderStatus->update([
            'order_status' => "Sukses",
        ]);

        return redirect()->back();
    }

    public function updateStatusFailed($id)
    {
        $orderStatus = OrderStatus::where('order_id', $id)->first();
        $orderStatus->update([
            'order_status' => "Gagal",
        ]);

        return redirect()->back();
    }

    public function orderRefund(Request $request)
    {
        $order = Order::find($request->orderId);

        ReturnForm::create([
            'order_status_id' => $order->orderStatus->id,
            'isi_form' => $request->desc,
            'return_status' => "Pending",
        ])->save();

        return redirect()->back();
    }

    public function updateRefundStatusSuccess($id)
    {
        $orderStatus = OrderStatus::where('order_id', $id)->first();
        $orderStatus->update([
            'order_status' => "Refund",
        ]);

        $refund = ReturnForm::where('order_status_id', $orderStatus->order_id)->first();
        $refund->update([
            'return_status' => "Sukses",
        ]);

        return redirect()->back();
    }

    public function updateRefundStatusFailed($id)
    {
        $orderStatus = OrderStatus::where('order_id', $id)->first();
        $orderStatus->update([
            'order_status' => "Cancel",
        ]);

        $refund = ReturnForm::where('order_status_id', $orderStatus->order_id)->first();
        $refund->update([
            'return_status' => "Sukses",
        ]);

        foreach ($orderStatus->order->orderDetail as $item) {
            $product = Product::find($item->product_id);

            // Update product quantity in product
            $product->update([
                'product_quantity' => ($product->product_quantity + 1),
            ]);
        }

        return redirect()->back();
    }

    public function getOrderDetail($id)
    {
        // Load all product
        $orderProduct = OrderDetail::where('order_id', $id)->first();

        if ($orderProduct) {
            $html = $this->getOrderProductDetail($orderProduct->order_id);
        } else {
            $html = '';
            $html .= '
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Quantitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data produk.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';
        }

        return $html;
    }

    public function getAllProduct()
    {
        $product = Product::where('user_id', Auth::user()->id)->get();
        $html = '';

        foreach ($product as $item) {
            $html .= '
                <a class="btn btn-outline-secondary btn-product w-100 mb-2" data-id="' . $item->id . '">
                    ' . $item->product_name . '
                </a>
            ';
        }

        return $html;
    }

    public function orderProduct(Request $request)
    {
        $orderDetail = OrderDetail::where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();
        $html = $this->getOrderProductDetail($request->order_id);

        //Check if the item has been added
        if ($orderDetail) {
            $html .= '
                <script>
                    alert("Produk sudah ditambahkan sebelumnya!");
                </script>
            ';
        } else {
            $product = Product::find($request->product_id);

            // Create order detail
            OrderDetail::create([
                'order_id' => $request->order_id,
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'product_quantity' => 1,
                'total_price' => $product->product_price,
            ])->save();

            // Update product quantity
            $product->update([
                'product_quantity' => ($product->product_quantity - 1)
            ]);

            $html = $this->getOrderProductDetail($request->order_id);
        }

        return $html;
    }

    public function increaseQuantity($id)
    {
        $orderDetail = OrderDetail::find($id);
        $product = Product::find($orderDetail->product_id);
        $totalPrice = ($orderDetail->total_price + $product->product_price);

        // Update order detail
        $orderDetail->update([
            'product_quantity' => ($orderDetail->product_quantity + 1),
            'total_price' => $totalPrice,
        ]);

        // Update product quantity in product
        $product->update([
            'product_quantity' => ($product->product_quantity - 1),
        ]);

        $html = $this->getOrderProductDetail($orderDetail->order_id);

        return $html;
    }

    public function decreaseQuantity($id)
    {
        $orderDetail = OrderDetail::find($id);
        $product = Product::find($orderDetail->product_id);
        $totalPrice = ($orderDetail->total_price - $product->product_price);

        // Update order detail
        $orderDetail->update([
            'product_quantity' => ($orderDetail->product_quantity - 1),
            'total_price' => $totalPrice,
        ]);

        // Update product quantity in product
        $product->update([
            'product_quantity' => ($product->product_quantity + 1),
        ]);

        $html = $this->getOrderProductDetail($orderDetail->order_id);

        return $html;
    }

    public function deleteProductOrder($id)
    {
        $orderDetail = OrderDetail::find($id);
        $orderProduct = OrderDetail::where('order_id', $orderDetail->order_id)->first();

        // Update product quantity
        $product = Product::find($orderDetail->product_id);
        $product->update([
            'product_quantity' => ($product->product_quantity + $orderDetail->product_quantity)
        ]);

        // Delete order detail
        $orderDetail->delete();

        // Check product order
        if ($orderProduct) {
            $html = $this->getOrderProductDetail($orderProduct->order_id);
        } else {
            $html = '';
            $html .= '
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data produk.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';
        }

        return $html;
    }

    private function getOrderProductDetail($id)
    {
        // Load all product
        $orderProduct = OrderDetail::where('order_id', $id)->get();
        $totalPrice = 0;
        $html = '';
        $html .= '
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Quantitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        foreach ($orderProduct as $data) {
            $totalPrice += $data->total_price;
            $html .= '
                <tr>
                    <td>' . $data->product->product_name . '</td>
                    <td>Rp ' . number_format(($data->product_quantity * $data->product->product_price), 0, ".", ".") . '</td>
                    <td>';
            if ($data->product->product_quantity <= 0) {
                $html .= '
                            <button class="btn btn-success btn-increase btn-sm mr-2" data-id="' . $data->id . '" disabled>
                                <i class="fas fa-plus fa-sm text-white"></i>
                            </button>';
            } else {
                $html .= '
                            <a class="btn btn-success btn-increase btn-sm mr-2" data-id="' . $data->id . '">
                                <i class="fas fa-plus fa-sm text-white"></i>
                            </a>';
            }
            $html .= '' . $data->product_quantity . '';
            if ($data->product_quantity == 1) {
                $html .= '
                            <button class="btn btn-danger btn-decrease btn-sm ml-2" data-id="' . $data->id . '" disabled>
                                <i class="fas fa-minus fa-sm text-white"></i>
                            </button>';
            } else {
                $html .= '
                            <a class="btn btn-danger btn-decrease btn-sm ml-2" data-id="' . $data->id . '">
                                <i class="fas fa-minus fa-sm text-white"></i>
                            </a>';
            }
            $html .= '
                    </td>
                    <td><a class="btn btn-danger btn-delete-product-order btn-sm" data-id="' . $data->id . '">
                            <span class="icon text-white">
                                <i class="fas fa-trash"></i>
                            </span>
                        </a>
                    </td>
                </tr>
            ';
        }

        $html .= '
                        <tr>
                            <th>Total Harga</th>
                            <th colspan="3">Rp ' . number_format($totalPrice, 0, ".", ".") . '</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';

        return $html;
    }
}
