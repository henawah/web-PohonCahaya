<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan daftar pesanan atau halaman awal pesanan
        return view('orders.checkout',[
            'title' => 'checkout'
        ]);
    }
    public function deleteCartItem($postId)
{
    // Contoh implementasi: Hapus item dari session atau database
    // Misalnya, jika Anda menggunakan session:
    $cart = session()->get('cart');

    if (isset($cart[$postId])) {
        unset($cart[$postId]);
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}

public function checkout()
    {
        // Mendapatkan data cart dari session
        $cart = session()->get('cart', []);

        // Periksa apakah cart tidak kosong
        if (!empty($cart)) {
            // Mendapatkan data produk dari database berdasarkan id produk yang ada di cart
            $postsIds = array_keys($cart);
            $posts = Post::whereIn('id', $postsIds)->get();

            return view('orders.checkout', compact('cart', 'posts'), [
                'title' => 'Checkout'
            ]);
        } else {
            // Jika cart kosong, berikan pesan atau arahkan ke halaman lain
            return view('orders.checkout', [
                'title' => 'Checkout',
                'message' => 'Cart is empty'
            ]);
        }
    }


}
