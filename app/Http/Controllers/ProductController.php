<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    //

    public function getProduct()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'ProductName' => 'required|string|max:255',
            'ProductPrice' => 'required|numeric',
            'ProductQuantity' => 'required|integer',
        ]);

        $product = new Product;
        $product->name = $request->ProductName;
        $product->price = $request->ProductPrice;
        $product->quantity = $request->ProductQuantity;
        $product->save();

        return response()->json(['success' => 'Product added successfully!', 'product' => $product]);
    }

    public function getProductByPrice($price){
        $products=Product::where('price','>',$price)->get();

        return response()->json($products);

    }

    public function index(Request $request) 

    {  
        $products = Product::paginate(3);   
        return response()->json($products);
        // $perPage = $request->get('perPage', 2);
        // $products = Product::paginate($perPage);
        // return response()->json($products);
    } 


    public function update(Request $request, Product $product)  
{  
    $this->authorize('update', $product);   

      
}

public function destroy(Product $product)  
{  
    $this->authorize('delete', $product);   

    
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'quantity' => 'nullable|integer',
        'price' => 'required|numeric',
    ]);

    $product = Product::create($validatedData);

    return response()->json($product, 201);
}
}
