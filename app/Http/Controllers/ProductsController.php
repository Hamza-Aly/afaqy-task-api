<?php

namespace App\Http\Controllers;
use App\Products;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        $response = [
            'products' => $products
        ];
        return response()->json($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'product_code' => 'required',
            'product_price' => 'required'
            
        ]);
        
        $product_name = $request->input('product_name');
        $product_code = $request->input('product_code');
        $product_price = $request->input('product_price');
        
        $products = new Products([
          'product_name' => $product_name, 
          'product_code' => $product_code,
          'product_price' => $product_price, 
        ]);
        if($products->save()){
            $products->view_products = [
              'href' => 'api/v1/products/' .$products->id,
              'method' => 'GET'
            ];
            $response = [
            'msg' => 'Product Added',
            'products' => $products
        ];
        return response()->json($response, 201);
       }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Products::where('id',$id)->firstOrFail();
        $products->view_products = [
              'href' => 'api/v1/products',
              'method' => 'GET'
            ];
        $response = [
            'products' => $products
        ];
        return response()->json($response, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'product_code' => 'required',
            'product_price' => 'required'
            
        ]);
        
        $product_name = $request->input('product_name');
        $product_code = $request->input('product_code');
        $product_price = $request->input('product_price');
        
        $products = [
          'product_name' => $product_name, 
          'product_code' => $product_code,
          'product_price' => $product_price,
          'view_products' => [
              'href' => 'api/v1/products/1',
              'method' => 'GET'
          ]
        ];
        $products = Products::findOrFail($id);
        $products->product_name = $product_name;
        $products->product_code = $product_code;
        $products->product_price = $product_price;
        
        if(!$products->update()){
             return response()->json(['msg' => 'Error during updating'], 404);
        }
        $products->view_products = [
              'href' => 'api/v1/products/' .$products->id,
              'method' => 'GET'
            ];
        
        $response = [
            'msg' => 'Product updated',
            'products' => $products
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Products::findOrFail($id);
        if(!$products->delete()){
             return response()->json(['msg' => 'Deletion failed'], 404);
        }
        $response = [
            'msg' => 'Product Deleted'
        ];
        return response()->json($response, 200);
    }
}
