<?php

namespace App\FMS\Client\Actions;

use App\FMS\Client\Queries\LatestClient;
use App\StartUp\BaseClasses\Controller\AdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexClient extends AdminController
{
    public function __construct()
    {
        $this->middleware(['permission:client.access']);
    }

    public function __invoke(Request $request, LatestClient $latestClient)
    {
        $client = $latestClient->fetch($request->user());

        if (!$client) {
            return new JsonResponse(['success' => 'true', 'data' => null, 'message' => 'no client']);
        }

        return $this->sendSuccessResponse($client->toArray());
    }
}
