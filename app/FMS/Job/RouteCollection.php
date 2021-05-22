<?php

namespace App\FMS\Job;

use App\FMS\Job\Actions\AllocateMIT;
use App\FMS\Job\Actions\CreateMemoForJob;
use App\FMS\Job\Actions\DeleteReceipt;
use App\FMS\Job\Actions\ListActionRequired;
use App\FMS\Job\Actions\ListJob;
use App\FMS\Job\Actions\ListJobBySite;
use App\FMS\Job\Actions\ListMergedTemplates;
use App\FMS\Job\Actions\ListWorkInProgress;
use App\FMS\Job\Actions\SaveJobShop;
use App\FMS\Job\Actions\UpdateJobInvoice;
use App\FMS\Job\Actions\UpdateJobRetention;
use App\FMS\Job\Actions\UpdateRecentlyCompleted;
use Illuminate\Routing\Router;

class RouteCollection
{
    /**
     * @var Router
     */
    private $router;

    /**
     * RouteCollection constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function __invoke()
    {
        $this->router->group(
            [
                'prefix' => 'api/jobs',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->patch('/{job}/recently-converted', UpdateRecentlyCompleted::class);
            $router->patch('/{job}/save-shop', SaveJobShop::class);
            $router->put('/{job}/invoice/{invoice}', UpdateJobInvoice::class);
            $router->post('/{job}/invoice/{invoice}/allocate-mit', AllocateMIT::class);
            $router->put('/{job}/update-retention', UpdateJobRetention::class);
            $router->post('/{job}/memos', CreateMemoForJob::class);
            $router->get('/', ListJob::class);
        });

        $this->router->group(
            [
                'prefix' => '/api/sites/{site}/jobs',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
                $router->get('/', ListJobBySite::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/terms',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListTerms::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/mergedtemplates',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->post('/', ListMergedTemplates::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/action-required',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListActionRequired::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/work-in-progress',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->get('/', ListWorkInProgress::class);
        });

        $this->router->group(
            [
                'prefix' => 'api/receipts',
                'middleware' => ['web', 'auth'],
            ], function (Router $router) {
            $router->delete('/{receipt}', DeleteReceipt::class);
        });

    }
}
