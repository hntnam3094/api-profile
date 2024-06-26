<?php

namespace App\Http\Controllers\Office;

use App\Constants\StructionConstant;
use App\Http\Controllers\Controller;
use App\Http\Forms\StructionPage\StructionForm;
use App\Http\Requests\StructionRequest;
use App\Http\Services\StructionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StructionPagesController extends Controller
{
    private $structionService;
    private $structionForm;

    public function __construct(
        StructionService $structionService,
        StructionForm $structionForm
        )
    {
        $this->structionService = $structionService;
        $this->structionForm = $structionForm;
        $this->middleware(['role:system-admin']);
    }

    public function index()
    {
        $result = $this->structionService->getStructionPagePaginations();
        return Inertia::render('Office/Struction/StructionPage', [
            'data' => $result,
            'form' => $this->structionForm->getForm(),
            'islist' => 1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $page_code = $request->get('page_code');
        $code = $request->get('code');
        $structionPageId = $this->structionService->getStructionPageByPageCodeAndCode($page_code, $code);

        $structionForm = $this->structionForm->getForm($page_code, $code);
        return Inertia::render('Office/Struction/FormAdd', [
            'dataForm' => $structionForm[StructionConstant::defaultData][StructionConstant::fieldForm] ?? [],
            'structionForm' => $structionForm,
            'pageCode' => $page_code,
            'code' => $code,
            'structionPageId' => $structionPageId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StructionRequest $request)
    {
        $pageCode = $request->get('page_code');
        $code = $request->get('code');
        $structionPageId = $this->structionService->getStructionPageByPageCodeAndCode($pageCode, $code);

        $this->structionService->save($request->all());

        return redirect()->to(route('structionpages.detail', ['id' => $structionPageId, 'is_list' => 1]));
    }

    /**
     * Display the specified resource.
     */
    public function show (Request $request, $id)
    {
        if ($rediectExpection = $this->redirectExpectionPage($request, $id)) {
            return $rediectExpection;
        }

        $metaData = $this->structionService->getStructionMetaByStructionDetailId($id);
        list($structionDetailRecord, $code, $page_code) = $this->structionService->getStructionDetailAndCodeAndPageCodeByStructionDetailId($id);

        if (empty($metaData)) {
            abort(404);
        }

        $data = $this->structionService->getKeyValueByMeta($metaData, $structionDetailRecord, $page_code, $code);
        $structionForm = $this->structionForm->getForm($page_code, $code);

        return Inertia::render('Office/Struction/FormDetail', [
            'dataForm' => $data,
            'structionForm' => $structionForm,
            'id' => $id,
            'structionPageId' => $structionDetailRecord->structionPageId ?? 0
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit (Request $request, string $id)
    {
        if ($rediectExpection = $this->redirectExpectionPage($request, $id)) {
            return $rediectExpection;
        }

        $metaData = $this->structionService->getStructionMetaByStructionDetailId($id);
        list($structionDetailRecord, $code, $page_code) = $this->structionService->getStructionDetailAndCodeAndPageCodeByStructionDetailId($id);
        if (empty($metaData)) {
            abort(404);
        }

        $data = $this->structionService->getKeyValueByMeta($metaData, $structionDetailRecord, $page_code, $code);
        $structionForm = $this->structionForm->getForm($page_code, $code);

        return Inertia::render('Office/Struction/FormAdd', [
            'dataForm' => $data,
            'structionForm' => $structionForm,
            'id' => $id,
            'structionPageId' => $structionDetailRecord->structionPageId,
            'pageCode' => $page_code,
            'code' => $code
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StructionRequest $request, string $id)
    {
        $structionPageId = $this->structionService->getStructionPageIdByStructionDetailId($id);
        $this->structionService->save($request->all(), $id);
        return redirect()->to(route('structionpages.detail', ['id' => $structionPageId, 'is_list' => 1]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $structionDetailRecord = $this->structionService->getStructionDetailById($id);
        $structionPageRecord = $this->structionService->getStructionPageById($structionDetailRecord->structionPageId);

        $this->structionService->deleteStructionDetailById($id);
        return redirect()->to(route('structionpages.detail', ['id' => $structionPageRecord->id, 'is_list' => 1]));
    }

    public function singleShow ($id) {
        $structionPage = $this->structionService->getStructionPageById($id);
        if ($rediectExpection = $this->rediectExpectionList($structionPage)) {
            return $rediectExpection;
        }

        if ($structionPage) {
            $structionForm = $this->structionForm->getForm($structionPage->pageCode, $structionPage->code);
            $structionDetail = $this->structionService->getSingleStructionDetailByStructionPageId($structionPage->id);
            $data = [];
            if (!empty($structionDetail)) {
                $metaData = $this->structionService->getStructionMetaByStructionDetailId($structionDetail->id);
                if (empty($metaData)) {
                    abort(404);
                }
                $data = $this->structionService->getKeyValueByMeta($metaData, $structionDetail, $structionPage->pageCode, $structionPage->code);

            }

            return Inertia::render('Office/Struction/FormDetail', [
                'dataForm' => $data,
                'structionForm' => $structionForm,
                'id' => $structionDetail->id ?? 0,
                'structionPageId' => $id,
                'singleRow' => 1
            ]);
        }
    }

    public function singleEdit ($id) {
        $structionPage = $this->structionService->getStructionPageById($id);
        if ($rediectExpection = $this->rediectExpectionList($structionPage)) {
            return $rediectExpection;
        }

        if ($structionPage) {
            $structionForm = $this->structionForm->getForm($structionPage->pageCode, $structionPage->code);
            $structionDetail = $this->structionService->getSingleStructionDetailByStructionPageId($id);

            $data = [];
            if (!empty($structionDetail)) {
                $metaData = $this->structionService->getStructionMetaByStructionDetailId($structionDetail->id);
                if (empty($metaData)) {
                    abort(404);
                }
                $data = $this->structionService->getKeyValueByMeta($metaData, $structionDetail, $structionPage->pageCode, $structionPage->code);
            }

            return Inertia::render('Office/Struction/FormAdd', [
                'dataForm' => $data,
                'structionForm' => $structionForm,
                'id' => $structionDetail->id ?? 0,
                'structionPageId' => $id,
                'pageCode' => $structionPage->pageCode,
                'code' => $structionPage->code,
                'singleRow' => 1
            ]);
        }
    }

    public function singleUpdate(StructionRequest $request, string $id)
    {
        $structionPage = $this->structionService->getStructionPageById($id);
        if ($structionPage) {
            $structionDetail = $this->structionService->getSingleStructionDetailByStructionPageId($id);
            if (empty($structionDetail)) {
                $this->structionService->save($request->all());
            } else {
                $this->structionService->save($request->all(), $structionDetail->id);
            }

            return redirect()->to(route('structionpages.index'));
        }
    }

    private function redirectExpectionPage ($request, $id) {
        $is_list = $request->get('is_list');
        if ($is_list) {

            $structionPageData = $this->structionService->getStructionPageById($id);
            if (!empty($structionPageData->singleRow)) {
                return redirect()->to(route('structionpages.single_detail', ['id' => $id]));
            }

            list($data, $code, $page_code, $form, $defaultParams) = $this->structionService->getStructionDetailByStructionPageId($id, $request->all());

            return Inertia::render('Office/Struction/StructionPage', [
                'id' => $id,
                'data' => $data,
                'islist' => 0,
                'pageCode' => $page_code,
                'code' => $code,
                'form' => $form,
                'params' => $defaultParams
            ]);
        }

        return false;
    }

    private function rediectExpectionList ($structionPage) {
        if (empty($structionPage->singleRow)) {
            return redirect()->to(route('structionpages.detail', ['id' => $structionPage->id, 'is_list' => 1]));
        }
        return false;
    }
}
