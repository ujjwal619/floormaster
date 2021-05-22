<?php

namespace App\Domain\Admin\Services\Template;

use App\Data\Entities\Models\Template\Template;
use App\Data\Repositories\Template\TemplateRepository;

/**
 * Class TemplateService
 * @package App\Domain\Admin\Services\Template
 */
class TemplateService
{
    /**
     * @var TemplateRepository
     */
    protected $repository;

    /**
     * TemplateService constructor.
     * @param TemplateRepository $repository
     */
    public function __construct(TemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find the latest id of the template.
     * @return Template
     */
    public function findLatest(): Template
    {
        return $this->repository->getLatest();
    }

    /**
     * Create new template
     * @param array $inputData
     * @return \App\Data\Entities\Models\Template\Template
     * @throws \Exception
     */
    public function createTemplate(array $inputData): Template
    {
        return $this->repository->create($inputData);
    }

    /**
     * @param array $inputData
     * @param int $templateId
     * @return mixed
     */
    public function update(array $inputData, int $templateId)
    {
        return $this->repository->update($inputData, $templateId);
    }

    /**
     * Delete the template.
     *
     * @param int $templateId
     *
     * @return int
     */
    public function delete(int $templateId)
    {
        return $this->repository->delete($templateId);
    }

    /**
     * Get selected materials and labours products
     * @param array $selectedTemplates
     * @return array
     */
    public function getSelected(array $selectedTemplates): array
    {
        $templates           = $this->repository->getSelected($selectedTemplates);
        $materialProducts    = collect();
        $labourProducts      = collect();
        $name = '';
        $salesCode = '';
        $remarks = '';
        $guidedPercentage = '';
        foreach ($templates as $template) {
            $name = $template->name;
            $guidedPercentage = $template->markup_guide;
            if ($template->sales_code_id) {
                $salesCode = $template->sales_code_id;
            }
            if (!empty($template->customer_details)) {
                $remarks = optional($template->customer_details)->quote;
            }
            foreach ($template->labour_products as $labourProduct) {
                $labourProducts->push($labourProduct);
            }

            foreach ($template->material_products as $materialProduct) {
                if (!$materialProducts->contains('product_id', isset($materialProduct->product_id) ? $materialProduct->product_id : null)) {
                    $materialProducts[] = $materialProduct;
                }
            }
        }

        return [
            'name' => count($templates) > 1 ? 'Mixed' : $name,
            'sales_code_id' => $salesCode,
            'remarks' => $remarks,
            'guided_percentage' => $guidedPercentage,
            'material_products' => $materialProducts,
            'labour_products' => $labourProducts
        ];
    }
}
