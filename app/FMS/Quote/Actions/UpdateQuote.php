<?php

namespace App\FMS\Quote\Actions;

use App\Data\Entities\Models\Quote\Quote;
use App\FMS\Quote\Manager;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\Request;

class UpdateQuote extends AdminController
{
    public function __invoke(Quote $quote, Request $request, Manager $quoteManager)
    {
        $this->validate($request, ['gst_inclusive_quote' => 'numeric']);

        $quoteManager->update($quote, $request->validated());

        return $this->sendSuccessResponse([], 'Quote Updated Successfully.');
    }
}
