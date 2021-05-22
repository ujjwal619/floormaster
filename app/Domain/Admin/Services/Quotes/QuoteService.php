<?php

namespace App\Domain\Admin\Services\Quotes;

use App\Data\Entities\Models\Quote\Quote;
use App\Data\Repositories\Quote\QuoteRepository;
use App\Domain\Admin\Resources\Quotes\QuotesResource;
use App\Domain\Admin\Services\Customers\CustomerService;
use App\FMS\Client\Manager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundExceptionAlias;
use Illuminate\Support\Collection;

/**
 * Class QuoteService
 * @package App\Domain\Admin\Services\Quotes
 */
class QuoteService
{
    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var CustomerService
     */
    protected $customerService;

    protected $clientManager;

    /**
     * QuoteService constructor.
     * @param QuoteRepository $quoteRepository
     * @param CustomerService $customerService
     */
    public function __construct(
        QuoteRepository $quoteRepository,
        CustomerService $customerService,
        Manager $clientManager
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->customerService = $customerService;
        $this->clientManager = $clientManager;
    }

    /**
     * Returns all the quotes.
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->quoteRepository->all();
    }

    /**
     * Create new quote and associate the labour sales and material sales.
     * @param array $inputData
     * @return \App\Data\Entities\Models\Quote\Quote
     * @throws \Exception
     */
    public function createQuote(array $inputData): Quote
    {
        // if ($inputData['customerDetails']['manual'] === true) {
        //     $data['customer'] = $inputData['customerDetails'];
        //     $customer = $this->clientManager->create($inputData['quote']['site_id'], $data['customer']);

        //     $inputData['quote']['customer_id'] = $customer->id;
        // }

        return $this->quoteRepository->createQuotesWithSalesPrices($inputData);
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function getPaginatedQuotesForTable(array $filters)
    {
        $quotes = $this->quoteRepository->getPaginatedQuotesWith($filters);

        return QuotesResource::collection($quotes);
    }

    /**
     * Find quote with customer.
     * @param int $quoteId
     * @return Quote
     * @throws ModelNotFoundExceptionAlias
     */
    public function findById(int $quoteId): Quote
    {
        return $this->quoteRepository
            ->with([
                'sales',
                'labourSalesPrice',
                'customer',
                'materials.variant',
                'materials.supplier',
                'materials.product.supplier',
                'site',
                'salesCode',
                'memoReferences.user',
                'shop'
            ])
            ->find($quoteId);
    }

    /**
     * Update the quote.
     * @param array $updateData
     * @param int   $quoteID
     * @return Quote
     * @throws \Exception
     */
    public function update(array $updateData, int $quoteID): Quote
    {
        return $this->quoteRepository->updateQuoteWithSalesPrices($updateData, $quoteID);
    }

    /**
     * Delete the quote.
     * @param int $quoteId
     * @return int
     */
    public function delete(int $quoteId)
    {
        return $this->quoteRepository->delete($quoteId);
    }

    /**
     * Get the latest quote's id.
     * @return Quote
     * @throws ModelNotFoundExceptionAlias
     * @throws \Exception
     */
    public function findLatest(): Quote
    {
        return $this->quoteRepository->getLatest();
    }
}
