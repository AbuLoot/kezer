<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

use App\Page;
use App\Mode;
use App\Product;
use App\Category;

class PageController extends Controller
{
    public function main()
    {
        $page = Page::where('slug', '/')->first();
        $page_about = Page::where('slug', 'o-kompanii')->first();
        $page_services = Page::where('parent_id', 2)->get();
        $products = Product::where('status', 1)->get();

        return view('main', ['page' => $page, 'page_about' => $page_about, 'page_services' => $page_services, 'products' => $products]);
    }

    public function services($slug)
    {
        $main = Page::where('slug', '/')->first();
        $page = Page::where('slug', $slug)->first();
        $page_services = Page::where('parent_id', 2)->whereNotIn('id', [$page->id])->get();

        if (View::exists('service-'.$page->id)) {
            return view('service-'.$page->id, ['page' => $page, 'page_services' => $page_services, 'main' => $main]);
        }
        else {
            return view('page', ['page' => $page]);
        }
    }

    public function projects()
    {
        $page = Page::where('slug', 'proekty')->firstOrFail();
        $category = Category::where('slug', $page->slug)->first();

        return view('projects', ['page' => $page, 'category' => $category]);
    }

    public function showProject($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('show-project')->with('product', $product);
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('page')->with('page', $page);
    }

    public function contacts()
    {
        $page = Page::where('slug', 'contacts')->firstOrFail();

        return view('contacts')->with('page', $page);
    }
}
