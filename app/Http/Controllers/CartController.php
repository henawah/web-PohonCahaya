<?php


namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        // Ambil data produk berdasarkan id yang ada di keranjang
        $posts = Post::whereIn('id', array_keys($cart))->get();
        $message = empty($cart) ? 'Keranjang belanja masih kosong. Silakan tambahkan produk.' : '';

        return view('cart', compact('cart', 'posts', 'message'),[
            'title' => 'cart'
        ]);
    }

    public function addToCart(Request $request, $postId)
{
    // Validasi bahwa $postId adalah integer yang valid
    if (!is_numeric($postId)) {
        return redirect()->back()->with('error', 'Invalid product ID.');
    }

    // Cek apakah produk dengan $postId ada di database
    $post = Post::find($postId);
    if (!$post) {
        return redirect()->back()->with('error', 'Product not found.');
    }

    // Logika untuk menambahkan item ke keranjang
    $quantity = $request->input('quantity', 1);

    // Simpan ke session
    $cart = Session::get('cart', []);
    if (isset($cart[$postId])) {
        $cart[$postId]['quantity'] += $quantity;
    } else {
        $cart[$postId] = ['quantity' => $quantity];
    }
    Session::put('cart', $cart);

    return redirect()->back()->with('success', 'Item added to cart successfully.');
}


    public function destroy(Request $request)
    {
        $postId = $request->input('post_id');

        // Pastikan $postId adalah integer yang valid
        if (!is_numeric($postId)) {
            return redirect()->back()->with('error', 'Invalid product ID.');
        }

        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        // Hapus item dari keranjang berdasarkan ID
        if (array_key_exists($postId, $cart)) {
            unset($cart[$postId]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item has been deleted from cart successfully.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }
}
