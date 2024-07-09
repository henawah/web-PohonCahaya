<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::with('posts')->get();
        $articles = Article::all();

        return view('posts', [
            "title" => "All Posts",
            "active" => 'posts',
            "categories" => $categories,
            "articles" => $articles,
            "posts" => Post::latest()->filter(request(['search','category','author']))->paginate(10)
        ]);
    }


    public function show(Post $post)
    {
        $categories = Category::all();
        $articles = Article::all();

        return view('post', [
            "title" => "Single Post",
            "active" => "posts",
            "post" => $post,
            "articles" => $articles,
            "articles" => Article::latest()->get(),
            "posts" => Post::latest()->get(),
            "categories" => $categories
        ]);
    } 
}

