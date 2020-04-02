<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateController extends Controller
{
	public function categories()
	{
	    $tr = new GoogleTranslate('tr');
	    $tr->setTarget('ru');

	    $categories = \App\Category::all();
	    $text = '';

	    foreach ($categories as $category) {
	        $text .= ' | '.$category->id.'=='.$category->title;
	    }

	    $ru = $tr->translate($text);
	    echo '<br>'. $ru;

	    $categories2 = [];
	    $categories2 = explode(' | ', $ru);

	    unset($categories2[0]);

	    foreach ($categories2 as $category) {
	        list($id, $title) = explode('==', $category);
	        $category_data = $categories->firstWhere('id', $id);
	        $category_data->title = trim($title);
	        $category_data->slug = str_slug(trim($title));
	        $category_data->meta_title = trim($title);
	        $category_data->meta_description = trim($title);
	        $category_data->save();
	    }

	    echo 'The End!';
	}

	public function options()
	{
	    // UPDATE `options` SET `title` = CONCAT(UPPER(SUBSTRING(`title`,1,1)),LOWER(SUBSTRING(`title`,2)));

	    $tr = new GoogleTranslate('tr');
	    $tr->setTarget('ru');

	    $options = \App\Option::all();
	    $text = '';

	    foreach ($options as $option) {
	        $text .= ' | '.$option->id.'=='.$option->title;
	    }

	    $ru = $tr->translate($text);
	    $options2 = [];
	    $options2 = explode(' | ', $ru);
	    unset($options2[0]);

	    foreach ($options2 as $option2) {
	        list($id, $title) = explode('==', $option2);
	        $option_data = $options->firstWhere('id', $id);
	        $option_data->title = trim($title);
	        $option_data->slug = str_slug(trim($title));
	        $option_data->save();
	    }

	    echo 'The End!';
	}

	public function products()
	{
	    set_time_limit(0);

	    $tr = new GoogleTranslate('tr');
	    $tr->setTarget('ru');

	    // [2, 3, 4, 5, 6, 7, 8, 9, 10]
	    // [11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
	    // [21, 22, 23, 24, 25, 26, 27, 28, 29, 30]
	    // [31, 32, 33, 34, 35, 36, 37, 38, 39, 40]
	    // [41, 42, 43, 44, 45, 46, 48, 49, 50]
	    // [51, 52, 53, 54, 55, 56, 57, 59, 60]
	    // [61, 62, 63, 64, 65, 66, 67]

	    // $products = \App\Product::whereIn('category_id', [63, 64])->whereNotIn('id', [5845,5846,5847,5848,5849,5851,5852,5853,5854,5855,5856])->get();
	    $products = \App\Product::whereRaw('LENGTH(characteristic) > 1')->get();
	    // $products = \App\Product::whereIn('category_id', [60, 61, 62, 63])->get();
	    // $products = \App\Product::all();
	    // dd($products);

	    $text = '';
	    $count = 0;

	    foreach ($products as $product) {

	        echo  $product->category_id.' ===== '.$product->id .' == '.$product->characteristic.'<br>'; 
	        // $text .= ' | '.$product->id.'=='.$product->characteristic.'<br>';
	        // $count++;

	        if ($count == 70) {

	            $ru = $tr->translate($text);
	            $products2 = [];
	            $products2 = explode(' | ', $ru);
	            unset($products2[0]);

	            foreach ($products2 as $product2) {

	                list($id, $characteristic) = explode('==', $product2);
	                // $title2 = trim($title);
	                $product_data = $products->firstWhere('id', $id);
	                // $product_data->title = $title2;
	                // $product_data->slug = str_slug($title2);
	                // $product_data->meta_title = $title2;
	                // $product_data->meta_description = $title2;
	                $product_data->characteristic = trim($characteristic);
	                // $product_data->price = ($product_data->price * 69);
	                $product_data->save();
	            }

	            $text = '';
	            $count = 0;
	        }
	    }

	    echo 'The End!';
	}
}
