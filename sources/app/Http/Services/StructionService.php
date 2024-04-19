<?php
namespace App\Http\Services;

use App\Constants\CommonConstant;
use App\Constants\StructionConstant;
use App\Http\Forms\StructionPage\StructionForm;
use App\Http\Repositories\Struction\StructionDetailRepository;
use App\Http\Repositories\Struction\StructionMetaRepository;
use App\Http\Repositories\Struction\StructionPageRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StructionService {
    private $structionPagesRepository;
    private $structionDetailsRepository;
    private $structionMetaRepository;
    private $commonService;
    private $structionForm;

    public function __construct(
        StructionPageRepository $structionPagesRepository,
        StructionDetailRepository $structionDetailRepository,
        StructionMetaRepository $structionMetaRepository,
        CommonService $commonService,
        StructionForm $structionForm
        )
    {
        $this->structionPagesRepository = $structionPagesRepository;
        $this->structionDetailsRepository = $structionDetailRepository;
        $this->structionMetaRepository = $structionMetaRepository;
        $this->commonService = $commonService;
        $this->structionForm = $structionForm;
    }

    public function getStructionPagePaginations () {
        return $this->structionPagesRepository->getPaginations();
    }

    public function getStructionPageByPageCodeAndCode ($page_code, $code) {
        return $this->structionPagesRepository->getByPageCodeAndCode($page_code, $code);
    }

    public function getStructionDetailByStructionPageId ($id, $params) {
        $structionPage = $this->structionPagesRepository->find($id);

        $form = $this->structionForm->getForm($structionPage->pageCode, $structionPage->code);

        $searchFields = [];
        foreach ($form[StructionConstant::fieldSearch] as $search) {
            $searchFields[$search[StructionConstant::NAME]] = $params[$search[StructionConstant::NAME]] ?? $search['value'];
        }

        $structionDetail = $this->structionDetailsRepository->getByStructionPageId($id, $params, $searchFields);

        if (!empty($structionDetail)) {
            foreach ($structionDetail as &$detail) {
                foreach ($form[StructionConstant::fieldList] as $show) {
                    $meta = $this->structionMetaRepository->getByIdAndField($detail->id, $show[StructionConstant::KEY]);
                    $type = $this->getKeyFormByInputKey($meta->key ?? '', $structionPage->pageCode, $structionPage->code);

                    if ($type === CommonConstant::IMAGE) {
                        $meta->value = Storage::url($meta->value);
                    }

                    $detail[$show[StructionConstant::TYPE]] = $meta->value ?? '';
                }
            }
        }

        return [$structionDetail, $structionPage->code, $structionPage->pageCode, $form, $searchFields];
    }

    public function getStructionMetaByStructionDetailId ($id) {
        return $this->structionMetaRepository->getByStructionDetailId($id);
    }

    public function getStructionDetailById ($id) {
        return $this->structionDetailsRepository->find($id);
    }

    public function getStructionPageById ($id) {
        return $this->structionPagesRepository->find($id);
    }

    public function deleteStructionDetailById ($id) {
        return $this->structionDetailsRepository->delele($id);
    }

    public function getStructionDetailAndCodeAndPageCodeByStructionDetailId ($id) {
        if ($id) {
            $structionDetail = $this->structionDetailsRepository->find($id);

            if (!empty($structionDetail)) {
                $structionPage = $this->structionPagesRepository->find($structionDetail->structionPageId);

                return [$structionDetail, $structionPage->code, $structionPage->pageCode];
            }
        }
        return [];
    }

    public function getStructionPageIdByStructionDetailId ($id) {
        if ($id) {
            $structionDetail = $this->structionDetailsRepository->find($id);
            if (!empty($structionDetail)) {
                $structionPage = $this->structionPagesRepository->find($structionDetail->structionPageId);

                return $structionPage->id;
            }
        }

        return 0;
    }

    public function getSingleStructionDetailByStructionPageId ($id) {
        return $this->structionDetailsRepository->getFirstByStructionPageId($id);
    }

    public function save ($attr, $id = 0) {
        $structionPageField = ['status', 'sequence'];

        try {
            DB::beginTransaction();

            list($attr, $pageCode, $code) = $this->getPageCodeAndCode($attr);

            if (!empty($id)) {
                $this->structionMetaRepository->deleteByStructionDetailId($id);
            } else {
                $structionPageId = $this->structionPagesRepository->getByPageCodeAndCode($pageCode, $code);

                $id = $this->structionDetailsRepository->create([
                    'structionPageId' => $structionPageId
                ])->id;
            }

            if (!empty($id) && !empty($attr)) {
                foreach ($attr as $key => $value) {
                    $type = $this->getKeyFormByInputKey($key, $pageCode, $code);

                    if(in_array($type, $structionPageField)) {
                        $this->structionDetailsRepository->update($id, [$key => $value]);
                        continue;
                    }

                    if ($type === CommonConstant::IMAGE) {
                        $value = $this->commonService->saveImages($value);
                    }

                    if ($type === CommonConstant::IMAGES) {
                        foreach ($value as &$val) {
                            $val['image'] = $this->commonService->saveImages($val['image'] ?? '');
                        }

                        $value = json_encode($value);
                    }

                    $this->structionMetaRepository->create([
                        'structionDetailId' => $id,
                        'key' => $key,
                        'value' => $value ?? ''
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    private function getKeyFormByInputKey ($key, $pageCode, $code) {
        $form = $this->structionForm->getForm($pageCode, $code);
        foreach ($form['form'] as $item) {
            if ($item['name'] == $key) {
                return $item['type'];
            }
        }

        return $key;
    }

    private function getPageCodeAndCode ($attr) {
        $pageCode = $attr['page_code'] ?? '';
        $code = $attr['code'] ?? '';

        unset($attr['page_code']);
        unset($attr['page_code']);

        return [$attr, $pageCode, $code];
    }

    public function getKeyValueByMeta ($metaData, $structionDetailRecord = null, $pageCode = null, $code = null) {
        $data = [];
        foreach ($metaData as $item) {
            $type = $this->getKeyFormByInputKey($item->key, $pageCode, $code);
            $value = $item->value;

            if ($type === CommonConstant::IMAGE) {
                $value = Storage::url($item->value);
            }

            if ($type === CommonConstant::IMAGES) {
                $value = json_decode($value);

                foreach($value as &$val) {
                    if (!empty($val->image)) {
                        $val->image = Storage::url($val->image);
                    }
                }

            }

            $data[$item->key] = $value ?? '';
        }

        if (!empty($structionDetailRecord)) {
            $data['status'] = $structionDetailRecord->status;
            $data['sequence'] = $structionDetailRecord->sequence;
        }

        $structionForm = $this->structionForm->getForm($pageCode, $code);
        $dataClone = $data;

        if (!is_null($structionForm) && !empty($structionForm['form'])) {
            $dataClone = [];
            foreach ($structionForm['form'] as $item) {
                if (isset($data[$item['name']])) {
                    $dataClone[$item['name']] = $data[$item['name']];
                }
            }
        }

        return $dataClone;
    }

    public function getStructionData ($pageCode, $code = null) {
        $listData = [];
        if (empty($pageCode)) {
            return $listData;
        }

        $structionPage = $this->structionPagesRepository->getByPageCodeAndCodeForView($pageCode, $code);
        foreach ($structionPage as $page) {
            if (empty($page['id'])) {
                continue;
            }

            $structionDetail = $this->getStructionDetail($page['id'], $page['pageCode'], $page['code']);
            if (empty($structionDetail)) {
                continue;
            }

            if (!empty($page['singleRow'])) {
                $listData[$page['code']] = $structionDetail[0] ?? [];
            } else {
                $listData[$page['code']] = $structionDetail;
            }
        }

        return $listData;
    }

    private function getStructionDetail ($structionPageId, $pageCode, $code) {
        $listData = [];
        if (empty($structionPageId)) {
            return $listData;
        }

        $structionDetails = $this->structionDetailsRepository->getByStructionPageIdForView($structionPageId);
        foreach ($structionDetails as &$item) {
            if (empty($item['id'])) {
                continue;
            }
            $metas = $this->structionMetaRepository->getByStructionDetailId($item['id']);

            if (empty($metas)) {
                continue;
            }

            foreach ($metas as $meta) {
                $type = $this->getKeyFormByInputKey($meta->key, $pageCode, $code);

                if ($type === CommonConstant::IMAGE) {
                    $meta->value = Storage::url($meta->value);
                }

                if ($type === CommonConstant::IMAGES) {
                    $meta->value = json_decode($meta->value);

                    foreach($meta->value as $val) {
                        if (!empty($val->image)) {
                            $val->image = Storage::url($val->image);
                        }
                    }

                }
                $item[$meta->key] = $meta->value ?? '';
            }

            $listData[] = $item;
        }

        return $listData;
    }
}
