<?php

namespace App\Data\Repositories\Job;

use App\Console\Commands\CalculateJobTotal;
use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Quote\Quote;
use App\Data\Repositories\Job\JobRepository;
use App\FMS\Client\Manager as ClientManager;
use App\FMS\Job\Manager as JobManager;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class QuoteEloquentRepository
 * @package App\Data\Repositories\Quote
 */
class JobEloquentRepository extends BaseRepository implements JobRepository
{
    /**
     * @var array
     */
    protected $filterFields = [
        'company' => 'customer_id',
        'quote_number' => 'quote_id',
    ];
    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    protected $clientManager;
    protected $jobManager;

    public function __construct(
        Application $app,
        DatabaseManager $databaseManager,
        ClientManager $clientManager,
        JobManager $jobManager
    ) {
        parent::__construct($app);
        $this->databaseManager = $databaseManager;
        $this->clientManager = $clientManager;
        $this->jobManager = $jobManager;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Job::class;
    }

    /**
     * Add new quote with the pivot sales - labour & material.
     *
     * @param $inputData
     *
     * @return mixed
     * @throws \Exception
     */
    public function createQuotesWithSalesPrices($inputData): Quote
    {
        $quoteData = array_get($inputData, 'quote');
        $quoteData['quote_id'] = sprintf('%s-%s', strtoupper(str_random(3)), rand(1000, 9999));
        $labourSalesPriceData = array_get($inputData, 'labours');
        $materialSalesPrice = array_get($inputData, 'materials');
        $sales = array_get($inputData, 'selectedSales', []);

        $this->databaseManager->beginTransaction();
        try {
            $quote = $this->create($quoteData);

            collect($sales)->each(function ($sale) use ($quote) {
                $quote->sales()->attach($sale);
            });

            collect($labourSalesPriceData)->each(function ($labourSale) use ($quote) {
                $quote->labourSalesPrice()->attach($labourSale['labour_product_id'], array_only($labourSale, ['total', 'quantity', 'unit']));
            });

            collect($materialSalesPrice)->each(function ($materialSale) use ($quote) {
                $quote->materialSalesPrice()->attach(
                    $materialSale['product_id'], 
                    array_only($materialSale, [
                        'variant_id', 
                        'total', 
                        'quantity', 
                        'unit',
                        'unit_sell',
                    ]));
            });


            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            dd($exception);
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $quote;
    }

    /**
     * Returns the paginated quotes with different filters.
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedQuotesWith(array $filters): LengthAwarePaginator
    {
        $sortField = array_get($this->filterFields, $filters['column'], $filters['column']);

        $query = $this->model->orderBy($sortField, $filters['order']);

        $searchQuery = $filters['search'];

//        if (!empty($searchQuery)) {
//            $query = $query->where(
//                function ($query) use ($searchQuery) {
//                    $query->orWhere('trading_name', 'like', "%{$searchQuery}%")
//                        ->orWhere('phone', 'like', "%{$searchQuery}%")
//                        ->orWhere('fax', 'like', "%{$searchQuery}%");
//                }
//            );
//        }

        return $query->paginate($filters['per_page']);
    }

    /**
     * Update quotes with pivot sales - labour and material.
     *
     * @param array $updateData
     * @param int $quoteID
     *
     * @return Quote
     * @throws \Exception
     */
    public function updateQuoteWithSalesPrices(array $updateData, int $quoteID): Quote
    {
        $quoteData = array_get($updateData, 'quote');
        $labourSalesPriceData = array_get($updateData, 'labours');
        $materialSalesPrice = array_get($updateData, 'materials');
        $sales = array_get($updateData, 'selectedSales', []);

        $this->databaseManager->beginTransaction();
        try {
            $quote = $this->update($quoteData, $quoteID);

            collect($sales)->each(function ($sale) use ($quote) {
                $quote->sales()->sync($sale);
            });

            $quote->labourSalesPrice()->detach();
            $quote->materialSalesPrice()->detach();

            collect($labourSalesPriceData)->each(function ($labourSale) use ($quote) {
                $quote->labourSalesPrice()->attach($labourSale['labour_product_id'], array_only($labourSale, ['total', 'quantity', 'unit']));
            });

            collect($materialSalesPrice)->each(function ($materialSale) use ($quote) {
                $quote->materialSalesPrice()->attach(
                    $materialSale['product_id'], 
                    array_only($materialSale, [
                        'variant_id', 
                        'total', 
                        'quantity', 
                        'unit',
                        'unit_sell',
                    ]));
            });


            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $quote;
    }

    /**
     * Create new job from the quote details provided.
     *
     * @param Quote $quote
     * @return Job
     * @throws \Exception
     */
    public function createJobFromQuote(Quote $quote, array $inputData)
    {
        $this->databaseManager->beginTransaction();
        try {
            $inputData = array_merge($quote->toArray(), $inputData);
            $job = $quote->job()->create($inputData);
            $materialSalesPrices = $quote->materials;
            $labourSalesPrices = $quote->labourSalesPrice;
            $sales = $quote->sales;

            $sales = $sales->map(function ($sale) {
                return [
                    'sales_id' => $sale->pivot->sales_id,
                    'priority' => $sale->pivot->priority,
                    'commission' => $sale->pivot->commission,
                ];
            })->toArray();

            $formattedSales = $this->getFormattedSales($sales);

            $job->sales()->sync($formattedSales);

            $materialSalesPrices->each(function ($materialSale) use ($job) {
                $job->materials()->create([
                    'supplier_id' => $materialSale->supplier_id,
                    'product_id' => $materialSale->product_id,
                    'variant_id' => $materialSale->variant_id,
                    'quantity' => $materialSale->quantity,
                    'unit' => $materialSale->unit,
                    'total' => $materialSale->total,
                    'gst' => $materialSale->gst,
                    'levy' => $materialSale->levy,
                    'discount' => $materialSale->discount ?? 0,
                    'unit_sell' => $materialSale->unit_sell,
                ]);
            });

            $labourSalesPrices->each(function ($labourSale) use ($job) {
                $job->labourSalesPrice()->attach($labourSale->pivot->labour_product_id, [
                    'total' => $labourSale->pivot->total,
                    'quantity' => $labourSale->pivot->quantity,
                    'unit' => $labourSale->pivot->unit,
                ]);
            });

            $quote->forceFill(['converted_to_job' => true])->save();

            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            dd($exception);
            logger()->error($exception);
            $this->databaseManager->rollBack();
        }

        return $job;
    }

    public function getFormattedSales(array $sales)
    {
        return collect($sales)->mapWithKeys(function ($item) {
            return [$item['sales_id'] => ['commission' => $item['commission'], 'priority' => $item['priority']]];
        })->toArray();
    }

    public function getFormattedMaterials(array $materials)
    {
        return collect($materials)->mapWithKeys(function ($item) {
            return [
                $item['variant_id'] => [
                    'total' => $item['total'],
                    'quantity' => $item['quantity'],
                    'material_from' => $item['material_from'] ?? 'P',
                    'unit' => $item['unit'],
                    'product_id' => $item['product_id'],
                    'act_on' => $item['quantity'] - array_get($item, 'allocated', 0),
                    'gst' => array_get($item, 'gst', 0),
                    'levy' => array_get($item, 'levy', 0),
                    'discount' => array_get($item, 'discount', 0),
                    'unit_sell' => array_get($item, 'unit_sell', 0),
                ]
            ];
        });
    }

    /**
     * working
     * 
     * Create new job with sales prices.
     *
     * @param array $inputData
     *
     * @return mixed
     * @throws \Exception
     */
    public function createJobWithSalesPrices(array $inputData): Job
    {
        $jobData = array_get($inputData, 'job');
        $customer = $inputData['customerDetails'];
        $jobData['title'] = array_get($customer, 'title', '');
        $jobData['firstname'] = array_get($customer, 'firstname', '');
        $jobData['trading_name'] = array_get($customer, 'trading_name', '');
        $jobData['address'] = array_get($customer, 'address', '');
        $jobData['contact'] = array_get($customer, 'contact', '');
        $jobData['phone'] = array_get($customer, 'phone', '');
        $jobData['work_phone'] = array_get($customer, 'work_phone', '');
        $jobData['mobile'] = array_get($customer, 'mobile', '');
        $jobData['email'] = array_get($customer, 'email', '');
        $jobData['fax'] = array_get($customer, 'fax', '');
        $jobData['initiation_date'] = $jobData['quote_date'];

        $jobData['job_id'] = getQuoteCode($jobData['site_id']);

        $materialSalesPrice = array_get($inputData, 'materials');
        $sales = array_get($inputData, 'selectedSales', []);

        $formattedSales = $this->getFormattedSales($sales);

        $this->databaseManager->beginTransaction();
        try {
            $job = $this->create($jobData);

            $job->sales()->sync($formattedSales);

            collect($materialSalesPrice)->each(function ($materialSale) use ($job) {
                $job->materials()->create([
                    'supplier_id' => array_get($materialSale, 'supplier_id'),
                    'product_id' => array_get($materialSale, 'product_id'),
                    'variant_id' => array_get($materialSale, 'variant_id'),
                    'total' => array_get($materialSale, 'total'),
                    'quantity' => array_get($materialSale, 'quantity'),
                    'unit' => array_get($materialSale, 'unit'),
                    'gst' => array_get($materialSale, 'gst', 0),
                    'levy' => array_get($materialSale, 'levy', 0),
                    'discount' => array_get($materialSale, 'discount', 0) ?? 0,
                    'unit_sell' => array_get($materialSale, 'unit_sell'),
                    'material_from' => array_get($materialSale, 'material_from', 'P'),
                    'act_on' => array_get($materialSale, 'quantity') - array_get($materialSale, 'allocated', 0)
                ]);
            });

            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            dd($exception);
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $job;
    }

    /**
     * Returns the paginated quotes with different filters.
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedJobsWith(array $filters): LengthAwarePaginator
    {
        $sortField = array_get($this->filterFields, $filters['column'], $filters['column']);

        $query = $this->model->orderBy($sortField, $filters['order']);

        $searchQuery = $filters['search'];

        return $query->paginate($filters['per_page']);
    }

    /**
     * // working
     * Update the job with the sales and material and labour prices.
     *
     * @param array $updateData
     * @param int $jobId
     *
     * @return mixed
     * @throws \Exception
     */
    public function updateJobWithSalesAndPrices(array $updateData, int $jobId): Job
    {
        $jobData = array_get($updateData, 'job');
        $customer = array_get($updateData, 'customerDetails');
        $jobData['title'] = array_get($customer, 'title', '');
        $jobData['firstname'] = array_get($customer, 'firstname', '');
        $jobData['trading_name'] = array_get($customer, 'trading_name', '');
        $jobData['address'] = array_get($customer, 'address', '');
        $jobData['contact'] = array_get($customer, 'contact', '');
        $jobData['phone'] = array_get($customer, 'phone', '');
        $jobData['work_phone'] = array_get($customer, 'work_phone', '');
        $jobData['mobile'] = array_get($customer, 'mobile', '');
        $jobData['email'] = array_get($customer, 'email', '');
        $jobData['fax'] = array_get($customer, 'fax', '');
        $jobData['costed_commission_balance'] = array_get($jobData,'costed_commission', 0) - array_get($jobData, 'costed_commission_paid', 0);
        $materialSalesPrice = array_get($updateData, 'materials');
        $sales = array_get($updateData, 'selectedSales', []);

        $formattedSales = $this->getFormattedSales($sales);

        $this->databaseManager->beginTransaction();
        try {
            $job = $this->update($jobData, $jobId);

            $jobMaterials = $job->materials;

            $deletedMaterialsIds = $jobMaterials->pluck('id')->diff(collect($materialSalesPrice)->pluck('id'));

            $deletedMaterialsIds->each(function ($materialId) use ($jobMaterials) {
                $material = $jobMaterials->firstWhere('id', $materialId);
                $material->delete();
            });

            collect($materialSalesPrice)->each(function ($materialSale) use ($job, $jobMaterials) {
                if (isset($materialSale['id'])) {
                    $material = $jobMaterials->firstWhere('id', $materialSale['id']);
                    $material->update([
                        'quantity' => array_get($materialSale, 'quantity'),
                        'unit' => array_get($materialSale, 'unit'),
                        'total' => array_get($materialSale, 'total'),
                        'gst' => array_get($materialSale, 'gst'),
                        'levy' => array_get($materialSale, 'levy'),
                        'discount' => array_get($materialSale, 'discount'),
                        'unit_sell' => array_get($materialSale, 'unit_sell'),
                    ]);
                } else {
                    $job->materials()->create([
                        'supplier_id' => array_get($materialSale, 'supplier_id'),
                        'product_id' => array_get($materialSale, 'product_id'),
                        'variant_id' => array_get($materialSale, 'variant_id'),
                        'total' => array_get($materialSale, 'total'),
                        'quantity' => array_get($materialSale, 'quantity'),
                        'unit' => array_get($materialSale, 'unit'),
                        'gst' => array_get($materialSale, 'gst', 0),
                        'levy' => array_get($materialSale, 'levy', 0),
                        'discount' => array_get($materialSale, 'discount', 0) ?? 0,
                        'unit_sell' => array_get($materialSale, 'unit_sell'),
                        'material_from' => array_get($materialSale, 'material_from', 'P'),
                        'act_on' => array_get($materialSale, 'quantity') - array_get($materialSale, 'allocated', 0)
                    ]);
                }
            });

            $this->jobManager->calculateJobTotal($job);

            $job->sales()->sync($formattedSales);

            event(new CalculateJobTotal($job));

            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            dd($exception);
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $job;
    }

    /**
     * Get the latest job.
     * @return Job
     * @throws ModelNotFoundException
     */
    public function getLatest(): Job
    {
        $job = $this->model->latest()->first();
        if (!$job) {
            throw new ModelNotFoundException();
        }

        return $job;
    }

    /**
     * Get job with main sales person
     *
     * @param int $jobId
     * @return Job
     */
    public function getWithSalesPerson(int $jobId): Job
    {
        return $this->model->newQuery()
            ->with(['customer', 'sales', 'primarySalesPerson'])
            ->whereId($jobId)
            ->first();
    }
}
