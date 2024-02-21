<?php

namespace App\Http\Controllers\Office;

use App\Constants\PostTypeConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Services\CategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $postType = $request->get('posttype');
        $data = $this->categoryService->getPaginationsByPostType($postType);
        return Inertia::render('Office/Category/CategoryList', [
            'data' => $data,
            'posttype' => $postType,
            'form' => PostTypeConstant::getForm($postType)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $postType = $request->get('posttype');
        $form = PostTypeConstant::getForm($postType);

        return Inertia::render('Office/Category/FormAdd', [
            'dataForm' => [],
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryService->save($request->all());

        return redirect()->to(route('category.index', ['posttype' => $request->get('posttype')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        list($dataForm, $form, $postType) = $this->categoryService->getDataFormById($id);

        if (empty($dataForm)) {
            abort(404);
        }
        return Inertia::render('Office/Category/FormDetail', [
            'dataForm' => $dataForm,
            'form' => $form,
            'posttype' => $postType,
            'id' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        list($dataForm, $form, $postType) = $this->categoryService->getDataFormById($id);
        if (empty($dataForm)) {
            abort(404);
        }
        return Inertia::render('Office/Category/FormAdd', [
            'dataForm' => $dataForm,
            'form' => $form,
            'posttype' => $postType,
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->categoryService->save($request->all(), $id);

        return redirect()->to(route('category.index', ['posttype' => $request->get('posttype')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postType = $this->categoryService->deleteCategoryById($id);

        if ($postType) {
            return redirect()->to(route('category.index', ['posttype' => $postType]));
        }
        return redirect()->to(route('dashboard'));
    }
}
