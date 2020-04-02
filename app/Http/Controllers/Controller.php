<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Page;
use App\Mode;
use App\Company;
use App\Section;
use App\Category;
use App\Language;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $mode = Mode::where('slug', 'trend')->first();
        $languages = Language::orderBy('sort_id')->get();
        $contacts = Section::where('slug', 'contacts')->first();
        $pages = Page::where('status', 1)->whereNotIn('slug', ['/'])->orderBy('sort_id')->get()->toTree();
        $companies = Company::where('status', 1)->orderBy('sort_id')->take(5)->get();
        $categories = Category::orderBy('sort_id')->get()->toTree();

        view()->share([
            'mode' => $mode,
            'pages' => $pages,
            'contacts' => $contacts,
            'companies' => $companies,
            'categories' => $categories,
            'languages' => $languages,
        ]);
    }
}
