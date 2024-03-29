<?php

namespace App\Http\Controllers\API;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\File;
use File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index()
    {
        $product = Products::all();

        return response()->json([
            'status' => 200,
            'products' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',

            'meta_title' => 'required|max:191',

            'brand' => 'required|max:20',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'qty' => 'required|max:4',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $product                    = new Products();
            $product->category_id       = $request->input('category_id');
            $product->slug              = $request->input('slug');
            $product->name              = $request->input('name');
            $product->description       = $request->input('description');

            $product->meta_title        = $request->input('meta_title');
            $product->meta_keyword      = $request->input('meta_keyword');
            $product->meta_descrip      = $request->input('meta_descrip');

            $product->brand             = $request->input('brand');
            $product->selling_price     = $request->input('selling_price');
            $product->original_price    = $request->input('original_price');
            $product->qty               = $request->input('qty');

            if ($request->hasFile('image')) {
                $file                   = $request->file('image');
                $extension              = $file->getClientOriginalExtension();
                $filename               = time() . '.' . $extension;
                $path                   = $file->move('uploads/product/', $filename);

                $product->image         = $filename;;
            }

            $product->featured          = $request->input('featured') == true ? '1' : '0';
            $product->popular           = $request->input('popular') == true ? '1' : '0';
            $product->status            = $request->input('status') == true ? '1' : '0';
            $product->save();

            return response()->json([
                'status' => 200,
                'message' => 'Product Added Successfuly',
            ]);
        }
    }

    public function edit($id)
    {
        $product = Products::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Product Found',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|max:191',
            'slug' => 'required|max:191',
            'name' => 'required|max:191',

            'meta_title' => 'required|max:191',

            'brand' => 'required|max:20',
            'selling_price' => 'required|max:20',
            'original_price' => 'required|max:20',
            'qty' => 'required|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        } else {
            $product                        = Products::find($id);
            if ($product) {

                $product->category_id       = $request->input('category_id');
                $product->slug              = $request->input('slug');
                $product->name              = $request->input('name');
                $product->description       = $request->input('description');

                $product->meta_title        = $request->input('meta_title');
                $product->meta_keyword      = $request->input('meta_keyword');
                $product->meta_descrip      = $request->input('meta_descrip');

                $product->brand             = $request->input('brand');
                $product->selling_price     = $request->input('selling_price');
                $product->original_price    = $request->input('original_price');
                $product->qty               = $request->input('qty');

                if ($request->hasFile('image')) {

                    $product                = Products::find($id);
                    $pathimage              = public_path('/uploads/product/', $product->image);
                    if (File::exists($pathimage)) {
                        File::delete($pathimage);
                    }
                    $file                   = $request->file('image');
                    $extension              = $file->getClientOriginalExtension();
                    $filename               = time() . '.' . $extension;
                    $path                   = $file->move('uploads/product/', $filename);

                    $product->image         = $filename;
                }

                $product->featured          = $request->input('featured');
                $product->popular           = $request->input('popular');
                $product->status            = $request->input('status');
                $product->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Product Updated Successfuly',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product Not Found',
                ]);
            }
        }
    }
}
