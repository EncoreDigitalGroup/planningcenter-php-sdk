<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use Illuminate\Http\Client\Response;

trait HasResponse
{
    protected ?Response $lastResponse = null;

    /**
     * Get the most recent API response
     *
     * This allows consumers to access HTTP metadata such as:
     * - Status codes: $resource->response()->status()
     * - Headers: $resource->response()->header('X-RateLimit-Remaining')
     * - Raw body: $resource->response()->body()
     * - Check success: $resource->response()->successful()
     */
    public function response(): ?Response
    {
        return $this->lastResponse;
    }

    /**
     * Store the API response
     *
     * @internal This method is for internal SDK use only.
     */
    protected function setResponse(Response $response): void
    {
        $this->lastResponse = $response;
    }
}