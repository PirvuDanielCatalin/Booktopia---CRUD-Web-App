<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Mail;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin'])->only(['control-panel']);
        //$this->middleware('CountPeople')->except('contactemail');
    }

    public function index()
    {
        $books = Book::where('inShop', '1')->inRandomOrder()->paginate(10);
        $categories = Category::all();
        return view('general.shop-products', ['books' => $books, 'categories' => $categories]);
    }

    public function filters(Request $request)
    {
        $books = Book::where('inShop', '1');
        $categories = Category::all();

        $price_filters_panel = $request->price_filters_panel;
        $category_filters_panel = $request->category_filters_panel;

        if ($price_filters_panel) {
            $price_filter = "";
            if (sizeof($price_filters_panel) == 1) {
                $price_filter = $price_filter . "books.price " . $price_filters_panel[0];
            } else {
                for ($i = 0; $i < sizeof($price_filters_panel) - 1; $i++) {
                    $price_filter = $price_filter . "books.price " . $price_filters_panel[$i] . " OR ";
                }
                $price_filter = $price_filter . "books.price " . $price_filters_panel[$i];
            }
        }

        if ($category_filters_panel) {
            $category_filter = "";
            if (sizeof($category_filters_panel) == 1) {
                $category_filter = $category_filter . "categories.name = '" . $category_filters_panel[0] . "'";
            } else {
                for ($i = 0; $i < sizeof($category_filters_panel) - 1; $i++) {
                    $category_filter = $category_filter . "categories.name = '" . $category_filters_panel[$i] . "' OR ";
                }
                $category_filter = $category_filter . "categories.name = '" . $category_filters_panel[$i] . "'";
            }
        }

        if (isset($price_filter) && $price_filter != "")
            $books = $books->whereRaw($price_filter);

        if (isset($category_filter) && $category_filter != "")
            $books = $books
                ->join('books_categories', 'books.id', '=', 'books_categories.book_id')
                ->join('categories', 'books_categories.category_id', '=', 'categories.id')
                ->whereRaw($category_filter);

        $books = $books->inRandomOrder()->paginate(10);

        return view('general.shop-products',
            ['books' => $books,
                'categories' => $categories,
                'price_filters' => $price_filters_panel,
                'category_filters' => $category_filters_panel]);
    }

    public function control_panel()
    {
        return view('general.control-panel');
    }

    public function shopping_cart(Request $request)
    {
        $session = get_object_vars(json_decode(base64_decode($request->input('session'))));
        $products = [];
        foreach (array_keys($session) as $product) {
            $id = preg_replace('/\D/', '', $product); // Extract the book id from session key
            $products[$id]['book'] = Book::find($id);
            $products[$id]['quantity'] = intval($session[$product]);
        }
        return view('general.shopping-cart', ['products' => $products]);
    }

    public function contactemail(Request $request)
    {
        $subject = (isset($request->subject)) ? $request->subject : '';
        $email = (isset($request->email)) ? $request->email : '';
        $text = (isset($request->text)) ? $request->text : '';

        Mail::send('helpers.email_format', ['text' => $text], function ($message) use ($subject, $email) {
            $message->subject($subject)
                ->from($email)
                ->to('booktopia.contact@gmail.com', 'Booktopia');
        });
        return back();
    }
}
