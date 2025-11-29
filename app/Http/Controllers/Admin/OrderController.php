<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pathau;
use App\Models\Product;
use App\Models\Redx;
use App\Models\Setting;
use App\Models\StredFast;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view order')->only('index');
        $this->middleware('permission:create order')->only(['create', 'store']);
        $this->middleware('permission:edit order')->only(['edit', 'update']);
        $this->middleware('permission:delete order')->only('destroy');

        $this->middleware('permission:view pending-order')->only('index');
        $this->middleware('permission:create pending-order')->only(['create', 'store']);
        $this->middleware('permission:edit pending-order')->only(['edit', 'update']);
        $this->middleware('permission:delete pending-order')->only('destroy');

        $this->middleware('permission:view processing-order')->only('index');
        $this->middleware('permission:create processing-order')->only(['create', 'store']);
        $this->middleware('permission:edit processing-order')->only(['edit', 'update']);
        $this->middleware('permission:delete processing-order')->only('destroy');

        $this->middleware('permission:view on-the-way')->only('index');
        $this->middleware('permission:create on-the-way')->only(['create', 'store']);
        $this->middleware('permission:edit on-the-way')->only(['edit', 'update']);
        $this->middleware('permission:delete on-the-way')->only('destroy');

        $this->middleware('permission:view hold')->only('index');
        $this->middleware('permission:create hold')->only(['create', 'store']);
        $this->middleware('permission:edit hold')->only(['edit', 'update']);
        $this->middleware('permission:delete hold')->only('destroy');

        $this->middleware('permission:view couriers')->only('index');
        $this->middleware('permission:create couriers')->only(['create', 'store']);
        $this->middleware('permission:edit couriers')->only(['edit', 'update']);
        $this->middleware('permission:delete couriers')->only('destroy');

        $this->middleware('permission:view complete')->only('index');
        $this->middleware('permission:create complete')->only(['create', 'store']);
        $this->middleware('permission:edit complete')->only(['edit', 'update']);
        $this->middleware('permission:delete complete')->only('destroy');

        $this->middleware('permission:view cancelled')->only('index');
        $this->middleware('permission:create cancelled')->only(['create', 'store']);
        $this->middleware('permission:edit cancelled')->only(['edit', 'update']);
        $this->middleware('permission:delete cancelled')->only('destroy');
    }


    public function allOrders()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.all', compact('orders'));
    }

    // SteadFast

    public function sendToSteadfast($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        
        $sf = StredFast::first();

        if (!$order->user) {
            return back()->with('error', 'Order user not found!');
        }

        if ($order->orderItems->isEmpty()) {
            return back()->with('error', 'Order has no items!');
        }

        $item_description = $order->orderItems->map(function ($item) {
            $productName = $item->product->name ?? 'N/A';
            return $productName . ' x ' . $item->quantity;
        })->implode(', ');

        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' => $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->post($sf->url . '/create_order', [
            'invoice'           => $order->order_id,
            'recipient_name'    => $order->user->name,
            'recipient_phone'   => $order->user->phone,
            'recipient_address' => $order->address ?? 'N/A',
            'cod_amount'        => $order->total,
            'note'              => $order->note ?? '',
            'item_description'  => $item_description,
            'delivery_type'     => 0,
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['consignment']['tracking_code'])) {
            $order->update([
                'steadfast_tracking' => $data['consignment']['tracking_code'],
                'steadfast_cid'     => $data['consignment']['consignment_id'],
                'status'     => 'steadfast',
            ]);

            return back()->with('success', 'Order sent to Steadfast successfully!');
        }

        return back()->with('error', 'Steadfast Error: ' . ($data['message'] ?? 'Invalid API response'));
    }


    public function steadfastStatus($invoice)
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' => $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->get( $sf->url . '/status_by_invoice/' . $invoice);

        return $response->json();
    }

    public function steadfastBalance()
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' =>  $sf->secret_key,
        ])->get( $sf->url . '/get_balance');

        return $response->json();
    }

    public function steadfastReturn($consignment_id)
    {
        $sf = StredFast::first();
        $response = Http::withHeaders([
            'Api-Key'    => $sf->api_key,
            'Secret-Key' =>  $sf->secret_key,
            'Content-Type' => 'application/json'
        ])->post( $sf->url . '/create_return_request', [
            'consignment_id' => $consignment_id,
            'reason' => 'Customer Requested Return'
        ]);

        return $response->json();
    }

    // Pathao

    public function sendToPathao($id)
    {
        $order = Order::with('user')->findOrFail($id);

        $Pathau= Pathau::first();

        // Step 1: Issue Token
        $tokenResponse = Http::post($Pathau->api_key.'/aladdin/api/v1/issue-token', [
            "client_id" => $Pathau->client_id,
            "client_secret" => $Pathau->secret_key,
            "grant_type" => "password",
            "username" => $Pathau->client_email,
            "password" => $Pathau->client_password,
        ]);

        if (!$tokenResponse->successful()) {
            return back()->with('error', 'Pathao Auth failed!');
        }

        $accessToken = $tokenResponse->json()['access_token'];



        // Step 2: Create Order
        $orderResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post($Pathau->api_key.'/aladdin/api/v1/orders', [
            "store_id" => $Pathau->store_id, // Your sandbox store_id
            "merchant_order_id" => $order->order_id,
            "recipient_name" => $order->user->name ?? 'Guest',
            "recipient_phone" => $order->user->phone ?? '01700000000',
            "recipient_address" => $order->user->address ?? 'N/A',
            "delivery_type" => 48,
            "item_type" => 2,
            "special_instruction" => $order->notes ?? '',
            "item_quantity" => $order->orderItems->sum('quantity'), // total quantity
            "item_weight" => "0.5", // demo weight
            "item_description" => $order->orderItems->map(fn($item) => $item->product->name . ' x ' . $item->quantity)->implode(', '),
            "amount_to_collect" => (int) round($order->total),

        ]);

        $data = $orderResponse->json();
        // dd($data);

        if ($orderResponse->successful() && isset($data['tracking_code'])) {
            $order->update([
                'pathao_tracking' => $data['tracking_code'],
                'pathao_order_id' => $data['id'] ?? null,
                'status' => 'pathao',
            ]);
            return back()->with('success', 'Order sent to Pathao successfully!');
        }

        return back()->with('error', 'Pathao Error: ' . ($data['message'] ?? 'Unknown error'));
    }

    // Redx
    public function sendToRedX($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        $redx = Redx::first();

        $jwtToken = $redx->api_token; // JWT token from RedX
        $storeId = $redx->store_id; // Pickup store id

        $parcelDetails = $order->orderItems->map(function ($item) {
            return [
                'name' => $item->product->name ?? 'N/A',
                'qty' => $item->quantity ?? 'N/A',
                'value' => (float) $item->price,
            ];
        });

        $payload = [
            'customer_name' => $order->user->name ?? 'Guest',
            'customer_phone' => $order->user->phone,
            'delivery_area' => $order->address ?? 'N/A',
            'delivery_area_id' => 1,
            'customer_address' => $order->address ?? 'N/A',
            'merchant_invoice_id' => $order->order_id,
            'cash_collection_amount' => (int) round($order->total),
            'parcel_weight' => 0.5,
            'instruction' => $order->notes ?? '',
            'value' => (float) $order->total,
            'is_closed_box' => true, // boolean type now
            'pickup_store_id' => $storeId,
            'parcel_details_json' => $parcelDetails,
        ];


        $response = Http::withHeaders([
            'API-ACCESS-TOKEN' => 'Bearer ' . $jwtToken,
            'Content-Type' => 'application/json'
        ])->post('https://sandbox.redx.com.bd/v1.0.0-beta/parcel', $payload);

        $data = $response->json();
        // dd($data);

        if ($response->successful() && isset($data['tracking_id'])) {
            $order->update([
                'redx_tracking' => $data['tracking_id'] ?? null,
                'status' => 'redx'
            ]);

            return back()->with('success', 'Order sent to RedX successfully! Tracking ID: ' . ($data['tracking_id'] ?? 'N/A'));
        } else {
            return back()->with('error', 'RedX Error: ' . ($data['message'] ?? 'Unknown error'));
        }
    }








    public function show($id)
    {
        $order = Order::with('orderItems.product', 'user')->findOrFail($id);
        $setting = Setting::first();
        return view('admin.orders.show', compact('order', 'setting'));
    }
    
    public function updateStatus(Request $request, Order $order)
    {
        $field = $request->field;
        $value = $request->value;

        if (in_array($field, ['status', 'payment_status'])) {

            // যদি payment_status paid হয়
            if ($field === 'payment_status' && $value === 'paid') {
                $order->paid = $order->total; // total amount automatically paid হবে
            }

            $order->$field = $value;
            $order->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }



    public function pendingOrders()
    {
        $orders = Order::where('status', 'pending')->latest()->get();
        return view('admin.orders.pending', compact('orders'));
    }

    public function processingOrders()
    {
        $orders = Order::where('status', 'processing')->latest()->get();
        return view('admin.orders.processing', compact('orders'));
    }

    public function onTheWayOrders()
    {
        $orders = Order::where('status', 'on the way')->latest()->get();
        return view('admin.orders.on-the-way', compact('orders'));
    }

    public function holdOrders()
    {
        $orders = Order::where('status', 'on hold')->latest()->get();
        return view('admin.orders.hold', compact('orders'));
    }

    public function courierOrders()
    {
        $orders = Order::where('status', 'pathao')->orWhere('status','redx')->orWhere('status','steadfast')->latest()->get();
        return view('admin.orders.courier', compact('orders'));
    }

    public function completeOrders()
    {
        $orders = Order::where('status', 'completed')->latest()->get();
        return view('admin.orders.complete', compact('orders'));
    }

    public function cancelledOrders()
    {
        $orders = Order::where('status', 'cancelled')->latest()->get();
        return view('admin.orders.cancelled', compact('orders'));
    }

    // Report
    public function stock_report(Request $request)
    {
        $products = Product::select('id', 'name', 'sale_price', 'stock')
            ->where('status', 1);
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category_id) {
            $products = $products->where('category_id', $request->category_id);
        }
        if ($request->start_date && $request->end_date) {
            $products = $products->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }
        $total_purchase = $products->sum(\DB::raw('purchase_price * stock'));
        $total_stock = $products->sum('stock');
        $total_price = $products->sum(\DB::raw('sale_price * stock'));
        $products = $products->paginate(10);
        $categories = Category::where('status', 1)->get();
        return view('admin.reports.stock', compact('products', 'categories', 'total_purchase', 'total_stock', 'total_price'));
    }


    public function order_report(Request $request)
    {
        $users = User::where('status', 1)->get();

        // Base query
        $ordersQuery = OrderItem::with(['order', 'order.user', 'product'])
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            });

        // Filter by keyword
        if ($request->keyword) {
            $ordersQuery->where('order_id', 'LIKE', '%' . $request->keyword . '%');
        }

        // Filter by assigned user
        if ($request->user_id) {
            $ordersQuery->whereHas('order', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            });
        }

        // Filter by date range
        if ($request->start_date && $request->end_date) {
            $ordersQuery->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }

        // Clone query to calculate totals before pagination
        $allOrders = (clone $ordersQuery)->get();

        // Product থেকে purchase_price দিয়ে total_purchase হিসাব
        $total_purchase = 0;
        foreach ($allOrders as $item) {
            $total_purchase += ($item->product->purchase_price ?? 0) * $item->quantity;
        }

        // Total quantity ও sales হিসাব
        $total_item = $allOrders->sum('quantity');
        $total_sales = $allOrders->sum(function ($item) {
            return ($item->price ?? 0) * $item->quantity;
        });

        // Pagination for table
        $orders = $ordersQuery->paginate(10);

        return view('admin.reports.order', compact('orders', 'users', 'total_purchase', 'total_item', 'total_sales'));
    }
}
