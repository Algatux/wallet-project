<?php declare(strict_types=1);

namespace AppBundle\Model\ApiResponses;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct(
        mixed $data = null,
        int $status = 200,
        array $headers = [],
        bool $json = false
    )
    {
        $body = [
            'http-status' => $status,
            'body' => $data,
        ];

        parent::__construct($body, $status, $headers, $json);
    }
}
