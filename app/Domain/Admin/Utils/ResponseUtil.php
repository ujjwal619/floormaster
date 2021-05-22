<?php

namespace App\Domain\Admin\Utils;

/**
 * Class ResponseUtil
 * @package App\Domain\Admin\Utils
 */
class ResponseUtil
{
    /**
     * @param string $message
     * @param array  $data
     * @param array  $meta
     *
     * @return array
     */
    public static function makeResponse(string $message, array $data, array $meta = []): array
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        return $response;
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError(string $message, array $data = []): array
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return $response;
    }
}