<?php

namespace App\Data\Repositories\Quote;

use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Quote\Quote;
use App\FMS\Site\Models\Site;
use App\StartUp\BaseClasses\Repository\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class QuoteEloquentRepository
 * @package App\Data\Repositories\Quote
 */
class QuoteEloquentRepository extends BaseRepository implements QuoteRepository
{
    /**
     * @var array
     */
    protected $filterFields = [
        'company'      => 'customer_id',
        'quote_number' => 'quote_id',
    ];
    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    public function __construct(Application $app, DatabaseManager $databaseManager)
    {
        parent::__construct($app);
        $this->databaseManager = $databaseManager;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Quote::class;
    }



    /**
     * Add new quote with the pivot sales - labour & material.
     * @param $inputData
     * @return mixed
     * @throws \Exception
     */
    public function createQuotesWithSalesPrices($inputData): Quote
    {
        $quoteData             = array_get($inputData, 'quote');
        $customer = $inputData['customerDetails'];
        $quoteData['title'] = array_get($customer, 'title', '');
        $quoteData['firstname'] = array_get($customer, 'firstname', '');
        $quoteData['trading_name'] = array_get($customer, 'trading_name', '');
        $quoteData['address'] = array_get($customer, 'address', '');
        $quoteData['contact'] = array_get($customer, 'contact', '');
        $quoteData['phone'] = array_get($customer, 'phone', '');
        $quoteData['work_phone'] = array_get($customer, 'work_phone', '');
        $quoteData['mobile'] = array_get($customer, 'mobile', '');
        $quoteData['email'] = array_get($customer, 'email', '');
        $quoteData['fax'] = array_get($customer, 'fax', '');

        $quoteData['quote_id'] = getQuoteCode($quoteData['site_id']);

        $materialSalesPrice    = array_get($inputData, 'materials');
        $sales                 = array_get($inputData, 'selectedSales', []);

        $formattedSales = $this->getFormattedSales($sales);

        $this->databaseManager->beginTransaction();
        try {
            $quote = $this->create($quoteData);

            $quote->sales()->sync($formattedSales);

            collect($materialSalesPrice)->each(function ($materialSale) use ($quote) {
                $quote->materials()->create(
                    array_only($materialSale, [
                        'supplier_id',
                        'product_id',
                        'variant_id', 
                        'total', 
                        'quantity', 
                        'unit',
                        'gst',
                        'levy',
                        'discount',
                        'unit_sell',
                    ])
                );
            });


            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }

        return $quote;
    }

    private function getFormattedSales(array $sales)
    {
        return collect($sales)->mapWithKeys(function($item) {
            return [$item['sales_id'] => ['commission' => $item['commission'], 'priority' => $item['priority']]];
        })->toArray();
    }

    /**
     * Returns the paginated quotes with different filters.
     * @param array $filters
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
     * @param array $updateData
     * @param int   $quoteID
     * @return Quote
     * @throws \Exception
     */
    public function updateQuoteWithSalesPrices(array $updateData, int $quoteID): Quote
    {
        $quoteData               = array_get($updateData, 'quote');
        $customer = array_get($updateData, 'customerDetails');
        $quoteData['title'] = array_get($customer, 'title', '');
        $quoteData['firstname'] = array_get($customer, 'firstname', '');
        $quoteData['trading_name'] = array_get($customer, 'trading_name', '');
        $quoteData['address'] = array_get($customer, 'address', '');
        $quoteData['contact'] = array_get($customer, 'contact', '');
        $quoteData['phone'] = array_get($customer, 'phone', '');
        $quoteData['work_phone'] = array_get($customer, 'work_phone', '');
        $quoteData['mobile'] = array_get($customer, 'mobile', '');
        $quoteData['email'] = array_get($customer, 'email', '');
        $quoteData['fax'] = array_get($customer, 'fax', '');
        $materialSalesPrice      = array_get($updateData, 'materials');
        $sales                   = array_get($updateData, 'selectedSales', []);

        $formattedSales = $this->getFormattedSales($sales);

        $this->databaseManager->beginTransaction();
        try {
            $quote = $this->update($quoteData, $quoteID);

            $quote->sales()->sync($formattedSales);

            $quote->materials()->delete();

            collect($materialSalesPrice)->each(function ($materialSale) use ($quote) {
                $quote->materials()->create(
                    array_only($materialSale, [
                        'supplier_id',
                        'product_id',
                        'variant_id', 
                        'total', 
                        'quantity', 
                        'unit',
                        'gst',
                        'levy',
                        'discount',
                        'unit_sell',
                    ])
                );
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
     * Get the latest quote.
     * @return Quote
     * @throws ModelNotFoundException
     */
    public function getLatest(): Quote
    {
        $quote = $this->model->latest()->first();
        if (!$quote) {
            throw new ModelNotFoundException();
        }

        return $quote;
    }
}
