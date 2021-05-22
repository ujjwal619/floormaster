<?php

namespace App\StartUp\BaseClasses\Controller;

use App\Domain\Admin\Utils\ResponseUtil;
use Illuminate\Http\Response;

/**
 * Class AdminController
 * @package App\StartUp\BaseClasses\Controller
 */
class AdminController extends Controller
{
    /**
     * @param array  $result
     * @param string $message
     * @param int    $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccessResponse($result = [], $message = 'success', $code = Response::HTTP_OK)
    {
        $meta = [];
        if (array_has($result, 'meta')) {
            $meta = $result['meta'];
            unset($result['meta']);
        }

        return response()->json(app(ResponseUtil::class)->makeResponse($message, $result, $meta), $code);
    }

    /**
     * @param string $error
     * @param int    $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError(string $error = 'error', $code = Response::HTTP_NOT_FOUND)
    {
        return response()->json(app(ResponseUtil::class)->makeError($error), $code);
    }
}
