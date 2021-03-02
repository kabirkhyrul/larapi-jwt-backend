<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Product::limit(1000)->get(),
            Response::HTTP_OK
        );
    }

    /**
     * Store a newly created, updated resource in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            if (!$request->has('id')) {
                if ($request->hasFile('image')) {
                    $validated['image'] = $request->file('image')->store('public');
                }
                $product = Product::create($validated);
                return \response()->json($product, Response::HTTP_CREATED);
            } else {
                $product = Product::find($request->id);
                if ($request->hasFile('image')) {
                    if ($product->image) {
                        Storage::delete($product->image);
                    }

                    $validated['image'] = $request->file('image')->store('public');
                }
                $product->update($validated);
                return \response()->json($product, Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        try {
            return \response()->json($product, Response::HTTP_FOUND);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        try {

            if ($product->photo) {
                Storage::delete($product->photo);
            }

            $product->delete();
            return response()->json($product->title . " removed!", Response::HTTP_FOUND);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
