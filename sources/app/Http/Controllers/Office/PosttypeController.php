<?php

namespace App\Http\Controllers\Office;

use App\Constants\PostTypeConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostTypeRequest;
use App\Http\Services\PostTypeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PosttypeController extends Controller
{
    private $postTypeService;

    public function __construct(PostTypeService $postTypeService)
    {
        $this->postTypeService = $postTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $postType = $request->get('posttype');
        $data = $this->postTypeService->getPaginationByPostType($postType);
        return Inertia::render('Office/Posttype/PosttypeList', [
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

        return Inertia::render('Office/Posttype/FormAdd', [
            'dataForm' => [],
            'form' => $form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostTypeRequest $request)
    {
        $this->postTypeService->save($request->all());

        return redirect()->to(route('posttype.index', ['posttype' => $request->get('posttype')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        list($dataForm, $form, $postType) = $this->postTypeService->getDataFormById($id);

        return Inertia::render('Office/Posttype/FormDetail', [
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
        list($dataForm, $form, $postType) = $this->postTypeService->getDataFormById($id);

        return Inertia::render('Office/Posttype/FormAdd', [
            'dataForm' => $dataForm,
            'form' => $form,
            'posttype' => $postType,
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostTypeRequest $request, string $id)
    {
        $this->postTypeService->save($request->all(), $id);

        return redirect()->to(route('posttype.index', ['posttype' => $request->get('posttype')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postType = $this->postTypeService->deletePostDetailById($id);

        return redirect()->to(route('posttype.index', ['posttype' => $postType]));
    }
}
