<?php

namespace App\Http\Controllers\Api;

use App\Constants\PostTypeConstant;
use App\Facades\PostTypeFacade;
use App\Http\Controllers\Controller;
use App\Http\Services\CategoryService;
use App\Http\Services\PostTypeService;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    use ApiResponseTrait;

    private $postTypeService;

    public function __construct (
        PostTypeService $postTypeService
    )
    {
        $this->postTypeService = $postTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->postTypeService->getDataByPostType(PostTypeConstant::BLOG_CODE);
        return $this->responseWithSuccess($data);
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
        $data = $this->postTypeService->getBySlug(PostTypeConstant::BLOG_CODE, $slug);

        return $this->responseWithSuccess($data);
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

    public function getBlogByCategorySlug ($slug) {
        $data = $this->postTypeService->getDataByCategorySlug(PostTypeConstant::BLOG_CODE, $slug);

        return $this->responseWithSuccess($data);
    }
}
