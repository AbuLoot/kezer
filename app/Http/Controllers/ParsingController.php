<?php

namespace App\Http\Controllers;
use Storage;
use PhpQuery\PhpQuery as phpQuery;
PhpQuery::use_function(__NAMESPACE__);

use App\Product;
use App\Company;
use App\Category;
use App\ImageTrait;

use Illuminate\Http\Request;

class ParsingController extends Controller
{
    use ImageTrait;

    public $categories = '';
    public $companies = '';
    public $cookiefile = '/tmp/cookie.txt';

    public function __construct()
    {
        $this->categories = Category::all();
        $this->companies = Company::all();
    }

    public function index()
    {
    	$ch = curl_init('http://baitun.kz');

    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_HEADER, true);
    	curl_setopt($ch, CURLOPT_NOBODY, true);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/60.0.3112.113 Chrome/60.0.3112.113 Safari/537.36');

    	$html = curl_exec($ch);

    	curl_close($ch);

    	dd($html);
    }

    public function request()
    {
        set_time_limit(0);

        $domen = 'https://www.malkocbebe.com';
        $url = 'https://www.malkocbebe.com/uye/giris';
        $postdata = 'kullaniciadi=globus&sifre=turktorg1&SubmitLogin=';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36');
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookiefile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookiefile);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

        $html = curl_exec($ch);
        curl_close($ch);

        $dom = phpQuery::newDocument($html);

        foreach ($dom->find('.wsmenu>.wsmenu-list>li>.wsmegamenu .link-list li a') as $category) {
            $category_item = pq($category);
            $category_href = $category_item->attr('href');
            $this->recursive_get_category($category_href);
            // usleep(300000);
        }

        echo '<h1>The end!</h1>';
    }

    public function recursive_get_category($url)
    {
        $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $html = curl_exec($ch);
        curl_close($ch);

        $dom = phpQuery::newDocument($html);

        foreach ($dom->find('.pnlurun .urunkutu-detay .isim a') as $product) {
            $product_item = pq($product);
            $product_href = $product_item->attr('href');
            echo $product_href.'<br>';
            // $this->recursive_get_product($product_href);
            // usleep(300000);
        }

        exit();

        $active_page = $dom->find('div.jshop_pagination > div > ul > li.active.hidden-phone')->next();
        $next_page = $active_page->find('a')->attr('title');

        if ( ! empty($next_page)) {
            $sf_start += 12;
            $this->recursive_get_page($domen, $url, $types, $id, $type_name, $sf_start);

            echo $sf_start. ' - '. $next_page . '<hr>';
        }

        phpQuery::unloadDocuments($html);
    }

    public function recursive_get_product($url, $type_name)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $html = curl_exec($ch);
        curl_close($ch);

        $dom = phpQuery::newDocument($html);

        $product_item = $dom->find('#comjshop')->html();
        $page = pq($product_item);

        $category = $this->categories->where('slug', str_slug($type_name))->first();

        $title = $page->find('h1')->text();
        $description = $page->find('div.jshop_prod_description')->html();
        $company = $page->find('div.manufacturer_name > span')->text();
        $company = explode(' (', strtolower($company));
        $company = $this->companies->where('slug', str_slug($company[0]))->first();
        $barcode = $page->find('#product_code')->text();
        $param   = $page->find('.block_efg:last')->html();

        // Creating images folder
        $dirName = $category->id.'/'.time();

        if ( ! file_exists('img/products/'.$dirName)) {
            Storage::makeDirectory('img/products/'.$dirName);
        }

        foreach ($page->find('#list_product_image_middle a') as $key => $elem)
        {
            $image_data = pq($elem);

            $image_src = $image_data->attr('href');
            $headers = get_headers($image_src);
            $response = substr($headers[0], 9, 3);

            if ($response == "200") {
                $image_org = file_get_contents($image_src);

                if (!$image_org) {
                    $image_org = Storage::get('img/no-image-big.png');             
                }
            }
            else {
                $image_org = Storage::get('img/no-image-big.png');
            }

            $image_ext = pathinfo($image_src, PATHINFO_EXTENSION);
            $imageName = 'image-'.$key.uniqid().'-'.str_slug($title).'.'.$image_ext;

            // Creating preview image
            if ($key == 0) {
                $this->resizeImage($image_org, 260, 260, 'img/products/'.$dirName.'/preview-'.$imageName, 100);
                $introImage = 'preview-'.$imageName;
            }

            // Storing original images
            Storage::put('img/products/'.$dirName.'/'.$imageName, $image_org);

            // Creating present images
            $this->resizeImage($image_org, 260, 260, 'img/products/'.$dirName.'/present-'.$imageName, 100);

            // Creating mini images
            $this->resizeImage($image_org, 70, 70, 'img/products/'.$dirName.'/mini-'.$imageName, 100);

            $images[$key]['image'] = $imageName;
            $images[$key]['present_image'] = 'present-'.$imageName;
            $images[$key]['mini_image'] = 'mini-'.$imageName;
        }

        $product = new Product;
        $product->sort_id = $product->count() + 1;
        $product->category_id = $category->id;
        $product->slug = str_slug($title);
        $product->title = $title;
        $product->company_id = (isset($company->id)) ? $company->id : 0;
        $product->barcode = $barcode;
        $product->price = 0;
        $product->days = 1;
        $product->count = 1;
        // $product->condition = $request->condition;
        // $product->presense = $request->presense;
        // $product->meta_description = $request->meta_description;
        $product->description = $description;
        $product->characteristic = $param;
        $product->image = $introImage;
        $product->images = serialize($images);
        $product->path = $dirName;
        $product->lang = 'ru';
        // $product->status = 1;
        $product->save();

        return true;

        phpQuery::unloadDocuments($html);
    }
}
?>