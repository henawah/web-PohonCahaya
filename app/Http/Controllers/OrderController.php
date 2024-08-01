<?php



// namespace App\Http\Controllers;

// use App\Models\Address;
// use App\Models\Order;
// use App\Models\Post;
// // use Illuminate\Contracts\Session\Session;
// use Illuminate\Support\Facades\Session;
// use Midtrans\Snap;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Cache;

// class OrderController extends Controller
// {
//     public function index()
//     {
//         $address = Address::all();
//         $responseProvince = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->get('https://api.rajaongkir.com/starter/province');
//         $provinces = $responseProvince['rajaongkir']['results'];

//         $responseCity = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->get('https://api.rajaongkir.com/starter/city');
//         $cities = $responseCity['rajaongkir']['results'];

//         $cart = Cache::get('cart');
//         $primaryAddress = Address::where('user_id', auth()->id())->where('is_primary', true)->first();
        
//         // Set $snapToken to null initially
//         $snapToken = null;

//         return view('orders.checkout', [
//             'provinces' => $provinces, 
//             'cities' => $cities, 
//             'address' => $address,
//             'ongkir' => '',
//             'cart' => $cart,
//             'primaryAddress' => $primaryAddress,
//             'snapToken' => $snapToken // Pass $snapToken even if it's null
//         ]);
//     }

//     public function deleteCartItem($postId)
//     {
//         $cart = Cache()->get('cart');

//         if (isset($cart[$postId])) {
//             unset($cart[$postId]);
//             Cache()->put('cart', $cart);
//             return response()->json(['success' => true]);
//         }

//         return response()->json(['success' => false]);
//     }

//     public function checkOngkir(Request $request)
//     {
//         $responseProvince = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->get('https://api.rajaongkir.com/starter/province');
//         $provinces = $responseProvince['rajaongkir']['results'];

//         $responseCity = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->get('https://api.rajaongkir.com/starter/city');
//         $cities = $responseCity['rajaongkir']['results'];

//         $primaryAddress = Address::where('user_id', auth()->id())->where('is_primary', true)->first();

//         $originCityId = 501;
//         $destination = $primaryAddress->city;

//         $responseCost = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->post('https://api.rajaongkir.com/starter/cost', [
//             'origin' => $originCityId,
//             'destination'=> $destination,
//             'weight'=> $request->weight,
//             'courier'=> $request->courier,
//         ]);
        
//         $ongkir = $responseCost['rajaongkir'];

//         $cart = Cache::get('cart', []);
//         $postsIds = array_keys($cart);
//         $posts = Post::whereIn('id', $postsIds)->get();

//         $totalPrice = 0;
//         $totalWeight = 0;
//         foreach ($posts as $post) {
//             $totalPrice += $post->price * $cart[$post->id]['quantity'];
//             $totalWeight += $post->weight * $cart[$post->id]['quantity'];
//         }
//         $totalBayar = $totalPrice + $ongkir['results'][0]['costs'][0]['cost'][0]['value'];

//         \Midtrans\Config::$serverKey = config('midtrans.serverKey');
//         \Midtrans\Config::$isProduction = false;
//         \Midtrans\Config::$isSanitized = true;
//         \Midtrans\Config::$is3ds = true;

//         $transaction_details = [
//             'order_id' => uniqid(),
//             'gross_amount' => (int)$totalBayar,
//         ];

//         $customer_details = [
//             'first_name' => $primaryAddress->full_name,
//             'email' => $primaryAddress->email,
//             'phone' => $primaryAddress->phone_number,
//         ];
//         $shipping_address = [
//             'address' => $request->address,
//             'city' => $request->city,
//             'province' => $request->province,
//             'country_code' => 'ID',
//         ];
//         $params = [
//             'transaction_details' => $transaction_details,
//             'shipping_address'=> $shipping_address,
//             'customer_details' => $customer_details,
//         ];

//         $snapToken = \Midtrans\Snap::getSnapToken($params);

//         return view('orders.checkout', [
//             'title' => 'Cek Ongkir',
//             'snapToken' => $snapToken,
//             'provinces' => $provinces, 
//             'cities' => $cities, 
//             'cart' => $cart,
//             'posts' => $posts,
//             'totalPrice' => $totalPrice,
//             'totalWeight' => $totalWeight,
//             'ongkir' => $ongkir,
//             'primaryAddress' => $primaryAddress,
//         ]);
//     }

//     public function checkout()
//     {
//         $cart = Cache::get('cart', []);
//         $postsIds = array_keys($cart);
//         $posts = Post::whereIn('id', $postsIds)->get();

//         $responseProvince = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->get('https://api.rajaongkir.com/starter/province');
//         $provinces = $responseProvince['rajaongkir']['results'];

//         $responseCity = Http::withHeaders([
//             'key' => 'acbba820fb1f76d8adff38610a3a253d'
//         ])->get('https://api.rajaongkir.com/starter/city');
//         $cities = $responseCity['rajaongkir']['results'];

//         $totalPrice = 0;
//         $totalWeight = 0;
//         foreach ($posts as $post) {
//             $totalPrice += $post->price * $cart[$post->id]['quantity'];
//             $totalWeight += $post->weight * $cart[$post->id]['quantity'];
//         }

//         $primaryAddress = Address::where('user_id', auth()->id())->where('is_primary', true)->first();

//         // Set $snapToken to null initially
//         $snapToken = null;

//         return view('orders.checkout', [
//             'title' => 'Checkout',
//             'provinces' => $provinces,
//             'cities' => $cities,
//             'cart' => $cart,
//             'totalPrice' => $totalPrice,
//             'totalWeight' => $totalWeight,
//             'posts' => $posts,
//             'ongkir' => '',
//             'primaryAddress' => $primaryAddress,
//             'snapToken' => $snapToken // Pass $snapToken even if it's null
//         ]);
//     }
    
//     public function store(Request $request)
// {
//     $validatedData = $request->validate([
//         'name' => 'required|string|max:255',
//         'address' => 'required|string|max:255',
//         'total_price' => 'required|numeric',
//     ]);

//     $order = new Order();
//     $order->name = $validatedData['name'];
//     $order->address = $validatedData['address'];
//     $order->total_price = $validatedData['total_price'];
//     $order->save();

//     // Simpan rincian pesanan
//     $cart = Cache::get('cart', []);
//     $postsIds = array_keys($cart);
//     $posts = Post::whereIn('id', $postsIds)->get();

//     foreach ($posts as $post) {
//         // Kurangi stok
//         $post->stock -= $cart[$post->id]['quantity'];
//         $post->save();

//         // Simpan rincian pesanan
//         Order::create([
//             'order_id' => $order->id,
//             'post_id' => $post->id,
//             'quantity' => $cart[$post->id]['quantity'],
//             'price' => $post->price,
//         ]);
//     }

//     // Kosongkan keranjang setelah checkout
//     Cache::forget('cart');

//     return redirect()->route('/post')->with('success', 'Order berhasil dibuat!');
// }

// }


namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Post;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;
use Midtrans\Snap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    public function index()
    {
        $address = Address::all();
        $responseProvince = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->get('https://api.rajaongkir.com/starter/province');
        $provinces = $responseProvince['rajaongkir']['results'];

        $responseCity = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->get('https://api.rajaongkir.com/starter/city');
        $cities = $responseCity['rajaongkir']['results'];

        // $cart = Cache::get('cart');
        $cart = Cache::get('cart_' . auth()->id(), []);

        $primaryAddress = Address::where('user_id', auth()->id())->where('is_primary', true)->first();
        
        // Set $snapToken to null initially
        $snapToken = null;

        return view('orders.checkout', [
            'provinces' => $provinces, 
            'cities' => $cities, 
            'address' => $address,
            'ongkir' => '',
            'cart' => $cart,
            'primaryAddress' => $primaryAddress,
            'snapToken' => $snapToken // Pass $snapToken even if it's null
        ]);
    }

    public function deleteCartItem($postId)
    {
        $cart = Cache()->get('cart');

        if (isset($cart[$postId])) {
            unset($cart[$postId]);
            Cache()->put('cart', $cart);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function checkOngkir(Request $request)
    {
        $responseProvince = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->get('https://api.rajaongkir.com/starter/province');
        $provinces = $responseProvince['rajaongkir']['results'];

        $responseCity = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->get('https://api.rajaongkir.com/starter/city');
        $cities = $responseCity['rajaongkir']['results'];

        $primaryAddress = Address::where('user_id', auth()->id())->where('is_primary', true)->first();

        $originCityId = 501;
        $destination = $primaryAddress->city;

        $responseCost = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $originCityId,
            'destination'=> $destination,
            'weight'=> $request->weight,
            'courier'=> $request->courier,
        ]);
        
        $ongkir = $responseCost['rajaongkir'];

        // $cart = Cache::get('cart', []);
        $cart = Cache::get('cart_' . auth()->id(), []);
        $postsIds = array_keys($cart);
        $posts = Post::whereIn('id', $postsIds)->get();

        $totalPrice = 0;
        $totalWeight = 0;
        foreach ($posts as $post) {
            $totalPrice += $post->price * $cart[$post->id]['quantity'];
            $totalWeight += $post->weight * $cart[$post->id]['quantity'];
        }
        $totalBayar = $totalPrice + $ongkir['results'][0]['costs'][0]['cost'][0]['value'];

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $transaction_details = [
            'order_id' => uniqid(),
            'gross_amount' => (int)$totalBayar,
        ];

        $customer_details = [
            'first_name' => $primaryAddress->full_name,
            'email' => $primaryAddress->email,
            'phone' => $primaryAddress->phone_number,
        ];
        $shipping_address = [
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'country_code' => 'ID',
        ];
        $params = [
            'transaction_details' => $transaction_details,
            'shipping_address'=> $shipping_address,
            'customer_details' => $customer_details,
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('orders.checkout', [
            'title' => 'Cek Ongkir',
            'snapToken' => $snapToken,
            'provinces' => $provinces, 
            'cities' => $cities, 
            'cart' => $cart,
            'posts' => $posts,
            'totalPrice' => $totalPrice,
            'totalWeight' => $totalWeight,
            'ongkir' => $ongkir,
            'primaryAddress' => $primaryAddress,
        ]);

        session()->forget('cart');
        return redirect('/')->with('success', 'Pembayaran berhasil! Anda akan diarahkan ke halaman home.');

    }

    public function checkout()
    {
        // $cart = Cache::get('cart', []);
        $cart = Cache::get('cart_' . auth()->id(), []);

        // $postsIds = array_keys($cart);
        // $posts = Post::whereIn('id', $postsIds)->get();
        $posts = Post::whereIn('id', array_keys($cart))->get();
        $totalPrice = array_sum(array_map(function ($postId) use ($cart) {
            return $cart[$postId]['quantity'] * Post::find($postId)->price;
        }, array_keys($cart)));

        $responseProvince = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->get('https://api.rajaongkir.com/starter/province');
        $provinces = $responseProvince['rajaongkir']['results'];

        $responseCity = Http::withHeaders([
            'key' => 'acbba820fb1f76d8adff38610a3a253d'
        ])->get('https://api.rajaongkir.com/starter/city');
        $cities = $responseCity['rajaongkir']['results'];

        $totalPrice = 0;
        $totalWeight = 0;
        foreach ($posts as $post) {
            $totalPrice += $post->price * $cart[$post->id]['quantity'];
            $totalWeight += $post->weight * $cart[$post->id]['quantity'];
        }

        $primaryAddress = Address::where('user_id', auth()->id())->where('is_primary', true)->first();

        // Set $snapToken to null initially
        $snapToken = null;

        return view('orders.checkout', [
            'title' => 'Checkout',
            'provinces' => $provinces,
            'cities' => $cities,
            'cart' => $cart,
            'totalPrice' => $totalPrice,
            'totalWeight' => $totalWeight,
            'posts' => $posts,
            'ongkir' => '',
            'primaryAddress' => $primaryAddress,
            'snapToken' => $snapToken // Pass $snapToken even if it's null
        ]);

        session()->forget('cart');

    return redirect('/')->with('success', 'Pembayaran berhasil! Anda akan diarahkan ke halaman home.');
    }

    // public function handleCallback(Request $request)
    // {
    //     // $request->request->add(['total_price' => $request->total_price, 'status'=> 'Unpaid']);
    //     // Ambil order ID dari parameter URL
    //     $orderId = $request->query('order_id');

        
    //     // Lakukan sesuatu dengan order ID, misalnya perbarui status order di database
        
    //     // Redirect ke halaman home dengan pesan sukses
    //     return redirect('/')->with('success', 'Pembayaran berhasil! Anda akan diarahkan ke halaman home.');
    // }

    public function handleCallback(Request $request)
    {
        $orderId = $request->query('order_id');
        $status = 'success'; // Assuming payment was successful

        // Fetch order details from the database and update the status
        $order = Order::where('order_id', $orderId)->first();
        if ($order) {
            $order->status = $status;
            $order->save();
        }

        // Clear the cart from the session
        session()->forget('cart');

        return redirect('/')->with('success', 'Pembayaran berhasil! Anda akan diarahkan ke halaman home.');
    }

    public function storeOrder(Request $request)
    {
        // $cart = Cache::get('cart', []);
        $cart = Cache::get('cart_' . auth()->id(), []);

        $postsIds = array_keys($cart);
        $posts = Post::whereIn('id', $postsIds)->get();

        $totalPrice = 0;
        foreach ($posts as $post) {
            $totalPrice += $post->price * $cart[$post->id]['quantity'];
        }

        $order = new Order();
        $order->user_id = auth()->id();
        $order->total_price = $totalPrice;
        $order->status = 'Pending'; // Initial status
        $order->address = $request->address;
        $order->qty = array_sum(array_column($cart, 'quantity'));
        $order->item_name = implode(', ', array_column($posts->toArray(), 'title'));
        $order->save();

        // Clear the cart from the session
        session()->forget('cart');

        return redirect('/')->with('success', 'Order placed successfully!');
    }

}
