<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;

use Image;
use Storage;
use Validator;

use App\Mode;
use App\Option;
use App\Comment;
use App\Company;
use App\Product;
use App\Category;
use App\ImageTrait;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $products = Product::orderBy('updated_at','desc')->paginate(50);
        $categories = Category::get()->toTree();
        $modes = Mode::all();

        // $categories_part = Category::whereIn('slug', ['gadjets', 'life-style'])->orderBy('sort_id')->get();

        // $ids = collect();
        // $ids = $categories_part->descendants()->pluck('id');

        // dd($ids);
        // foreach ($categories_part as $key => $category_item) {

        //     if ($category_item->children && count($category_item->children) > 0) {

        //         $ids[$key] = $category_item->children->pluck('id');
        //     }
        // }

        // $group_ids = $ids->collapse();
        // dd($group_ids);


        return view('joystick-admin.products.index', ['categories' => $categories, 'products' => $products, 'modes' => $modes]);
    }

    public function search(Request $request)
    {
        $text = trim(strip_tags($request->text));

        $products = Product::search($text)->paginate(50);
        $modes = Mode::all();

        $products->appends([
            'text' => $request->text,
        ]);

        return view('joystick-admin.products.found', compact('text', 'modes', 'products'));
    }

    public function priceForm()
    {
        $categories = Category::get()->toTree();

        return view('joystick-admin.products.price-edit', ['categories' => $categories]);
    }

    public function categoryProducts($id)
    {
        $categories = Category::get()->toTree();
        $category = Category::find($id);

        if ($category->children && count($category->children) > 0) {
            $ids = $category->children->pluck('id');
        }

        $ids[] = $category->id;

        $products = Product::whereIn('category_id', $ids)->orderBy('created_at')->paginate(50);
        $modes = Mode::all();

        return view('joystick-admin.products.index', ['category' => $category, 'categories' => $categories, 'products' => $products, 'modes' => $modes]);
    }

    public function actionProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        if (is_numeric($request->action)) {
            Product::whereIn('id', $request->products_id)->update(['status' => $request->action]);
        }
        else {
            $mode = Mode::where('slug', $request->action)->first();
            $products = Product::whereIn('id', $request->products_id)->get();

            foreach ($products as $product) {
                $product->modes()->toggle($mode->id);
            }
        }

        return response()->json(['status' => true]);
    }

    public function create()
    {
        $categories = Category::get()->toTree();
        $companies = Company::get();
        $options = Option::orderBy('sort_id')->get();
        $grouped = $options->groupBy('data');
        $modes = Mode::all();

        return view('joystick-admin.products.create', ['modes' => $modes, 'categories' => $categories, 'companies' => $companies, 'options' => $options, 'grouped' => $grouped]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80|unique:products',
            'category_id' => 'required|numeric',
            // 'images' => 'mimes:jpeg,jpg,png,svg,svgs,bmp,gif',
        ]);

        $category = Category::findOrFail($request->category_id);
        $introImage = null;
        $images = [];
        $dirName = $category->id.'/'.time();
        Storage::makeDirectory('img/products/'.$dirName);

        if ($request->hasFile('images')) {

            $order = 0;

            foreach ($request->file('images') as $key => $image)
            {
                $imageName = 'image-'.$order.'-'.str_slug($request->title).'.'.$image->getClientOriginalExtension();

                // Creating preview image
                if ($key == 0) {
                    $this->resizeOptimalImage($image, 350, 424, '/img/products/'.$dirName.'/preview-'.$imageName, 90);
                    $introImage = 'preview-'.$imageName;
                }

                $watermark = Image::make('img/watermark.png');

                // Creating present images
                $this->resizeOptimalImage($image, 350, 424, '/img/products/'.$dirName.'/present-'.$imageName, 90);

                // Storing original images
                // $image->storeAs('/img/products/'.$dirName, $imageName);
                $this->resizeOptimalImage($image, 700, 850, '/img/products/'.$dirName.'/'.$imageName, 90, $watermark);

                $images[$key]['image'] = $imageName;
                $images[$key]['present_image'] = 'present-'.$imageName;
                $order++;
            }
        }

        // Saving Background
        if ($request->hasFile('background')) {

            $backgroundName = $request->background->getClientOriginalName();

            $request->background->storeAs('img/products/'.$dirName, $backgroundName);
        }

        $product = new Product;
        $product->sort_id = ($request->sort_id > 0) ? $request->sort_id : $product->count() + 1;
        $product->category_id = $request->category_id;
        $product->slug = str_slug($request->title);
        $product->title = $request->title;
        // $product->title_extra = $request->title_extra;
        // $product->direction = $request->direction;
        // $product->color = $request->color;
        // $product->background = (isset($backgroundName)) ? $backgroundName : '';
        $product->company_id = $request->company_id;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->days = $request->days;
        $product->count = $request->count;
        $product->condition = $request->condition;
        $product->presense = $request->presense;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->description = $request->description;
        $product->characteristic = $request->characteristic;
        $product->image = $introImage;
        $product->images = serialize($images);
        $product->path = $dirName;
        $product->lang = $request->lang;
        $product->mode = (isset($request->mode)) ? $request->mode : 0;
        $product->status = $request->status;
        $product->save();

        if ( ! is_null($request->modes_id)) {
            $product->modes()->attach($request->modes_id);
        }

        if ( ! is_null($request->options_id)) {
            $product->options()->attach($request->options_id);
        }

        return redirect('admin/products')->with('status', 'Товар добавлен!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::get()->toTree();
        $companies = Company::get();
        $options = Option::orderBy('sort_id')->get();
        $grouped = $options->groupBy('data');
        $modes = Mode::all();

        return view('joystick-admin.products.edit', ['modes' => $modes, 'product' => $product, 'categories' => $categories, 'companies' => $companies, 'options' => $options, 'grouped' => $grouped]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:2|max:80',
            'category_id' => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);

        $backgroundName = $product->background;
        $images = unserialize($product->images);
        $dirName = $product->path;

        if (!file_exists('img/products/'.$product->category_id) OR empty($product->path)) {
            $dirName = $product->category->id.'/'.time();
            Storage::makeDirectory('img/products/'.$dirName);
            $product->path = $dirName;
        }

        if ($request->hasFile('images')) {

            $order = (!empty($images)) ? count($images) : 1;
            $introImage = null;

            foreach ($request->file('images') as $key => $image)
            {
                $imageName = 'image-'.$order.'-'.str_slug($request->title).'.'.$image->getClientOriginalExtension();

                // Creating preview image
                if ($key == 0) {

                    if ($product->image != 'no-image-middle.png' AND file_exists('img/products/'.$product->path.'/'.$product->image)) {
                        Storage::delete('img/products/'.$product->path.'/'.$product->image);
                        Storage::delete('img/products/'.$product->path.'/preview-'.$product->image);
                    }

                    $this->resizeOptimalImage($image, 350, 424, '/img/products/'.$dirName.'/preview-'.$imageName, 90);
                    $introImage = 'preview-'.$imageName;
                }

                $watermark = Image::make('img/watermark.png');

                // Creating present images
                $this->resizeOptimalImage($image, 350, 424, '/img/products/'.$dirName.'/present-'.$imageName, 90);

                // Storing original images
                $this->resizeOptimalImage($image, 700, 850, '/img/products/'.$dirName.'/'.$imageName, 90, $watermark);

                if (isset($images[$key])) {

                    Storage::delete([
                        'img/products/'.$product->path.'/'.$images[$key]['image'],
                        'img/products/'.$product->path.'/'.$images[$key]['present_image']
                    ]);
                }

                $images[$key]['image'] = $imageName;
                $images[$key]['present_image'] = 'present-'.$imageName;
                $order++;
            }

            ksort($images);
        }

        // Resave background
        if ($request->hasFile('background')) {

            if (file_exists('img/products/'.$product->path.'/'.$product->background)) {
                Storage::delete('img/products/'.$product->path.'/'.$product->background);
            }

            $backgroundName = $request->background->getClientOriginalName();
            $request->background->storeAs('img/products/'.$product->path, $backgroundName);
        }

        // Change directory for new category
        if ($product->category_id != $request->category_id AND file_exists('img/products/'.$product->path)) {

            $dirName = $request->category_id.'/'.time();
            Storage::move('img/products/'.$product->path, 'img/products/'.$dirName);
            $product->path = $dirName;
        }

        // Remove images
        if (isset($request->remove_images)) {

            foreach ($request->remove_images as $kvalue) {

                if (!isset($request->images[$kvalue])) {

                    if ($product->image === 'preview-'.$images[$kvalue]['image']) {

                        Storage::delete('img/products/'.$product->path.'/'.$product->image);
                        $introImage = 'no-image-middle.png';
                    }

                    Storage::delete([
                        'img/products/'.$product->path.'/'.$images[$kvalue]['image'],
                        'img/products/'.$product->path.'/'.$images[$kvalue]['present_image']
                    ]);

                    unset($images[$kvalue]);
                }
            }

            ksort($images);
        }

        $product->sort_id = ($request->sort_id > 0) ? $request->sort_id : $product->count() + 1;
        $product->category_id = $request->category_id;
        $product->slug = str_slug($request->title);
        $product->title = $request->title;
        // $product->title_extra = $request->title_extra;
        // $product->direction = $request->direction;
        // $product->color = $request->color;
        // $product->background = $backgroundName;
        $product->company_id = $request->company_id;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->days = $request->days;
        $product->count = $request->count;
        $product->condition = $request->condition;
        $product->presense = $request->presense;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->description = $request->description;
        $product->characteristic = (isset($request->characteristic)) ? $request->characteristic : '';
        if (isset($introImage)) $product->image = $introImage;
        $product->images = serialize($images);
        $product->lang = $request->lang;
        $product->mode = (isset($request->mode)) ? $request->mode : 0;
        $product->status = $request->status;
        $product->save();

        if ( ! is_null($request->modes_id)) {
            $product->modes()->sync($request->modes_id);
        }

        if ( ! is_null($request->options_id)) {
            $product->options()->sync($request->options_id);
        }

        return redirect('admin/products')->with('status', 'Товар обновлен!');
    }

    public function editHtml($id)
    {
        $product = Product::findOrFail($id);

        return view('joystick-admin.products.page', ['product' => $product]);
    }

    public function saveHtml($id)
    {
        $product = Product::find($id);
        $product->description = $_GET['html'];
        $product->save();

        return response()->json($product->title);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (! empty($product->images)) {

            $images = unserialize($product->images);

            foreach ($images as $image)
            {
                if ($product->image != NULL AND $product->image != 'no-image-middle.png' AND file_exists('img/products/'.$product->path.'/'.$product->image)) {
                    Storage::delete('img/products/'.$product->path.'/'.$product->image);
                }

                if ($image['image'] != 'no-image-middle.png') {
                    Storage::delete([
                        'img/products/'.$product->path.'/'.$image['image'],
                        'img/products/'.$product->path.'/'.$image['present_image']
                    ]);
                }
            }

            Storage::deleteDirectory('img/products/'.$product->path);
        }

        $product->delete();

        return redirect('/admin/products');
    }

    public function comments($id)
    {
        $product = Product::findOrFail($id);

        return view('joystick-admin.products.comments', ['product' => $product]);
    }

    public function destroyComment($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect('/admin/products/'.$comment->parent_id.'/comments')->with('status', 'Запись удалена!');
    }
}