<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use App\Http\Services\PostTypeService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private $categoryService;
    private $postTypeService;

    public function __construct(CategoryService $categoryService, PostTypeService $postTypeService)
    {
        $this->categoryService = $categoryService;
        $this->postTypeService = $postTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->categoryService->getCategoryAndPostTypeData('product');
        return view('product', ['data' => $data]);
    }


    public function index2 () {
        $data = $this->postTypeService->getPosttypeData('booking');
        return view('booking', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        if (empty($slug)) {
            return view('404');
        }

        $data = $this->postTypeService->getBySlug('product', $slug);
        if (empty($data)) {
            return view('404');
        }

        return view('product_detail', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
