<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use App\Http\Services\PostTypeService;
use App\Http\Services\StructionService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $structionService;
    private $categoryService;
    private $postTypeService;

    public function __construct(
        StructionService $structionService,
        CategoryService $categoryService,
        PostTypeService $postTypeService
    )
    {
        $this->structionService = $structionService;
        $this->categoryService = $categoryService;
        $this->postTypeService = $postTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $structionData = $this->structionService->getStructionData('home');
        $categoryProduct = $this->categoryService->getCategoryData('product');
        $productData = $this->postTypeService->getPosttypeData('product');

        return view('welcome', [
            'structionData' => $structionData,
            'categoryProduct' => $categoryProduct,
            'productData' => $productData
        ]);
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
    public function show(string $id)
    {
        //
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
