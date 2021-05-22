<?php

namespace App\FMS\Quote\Actions;

use App\Data\Entities\Models\Quote\Quote;
use App\StartUp\BaseClasses\Controller\AdminController;

class DeleteQuote extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:quote.access.delete.quote']);
    }

    public function __invoke(Quote $quote) 
    {
        if(!$quote->delete()) {
            return $this->sendError('Could not delete quote.');
        }

        return $this->sendSuccessResponse([], 'Quote Deleted Successfully.');
    }
}
