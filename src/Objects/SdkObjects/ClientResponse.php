<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

use EncoreDigitalGroup\SdkClientFoundation\HttpStatusCode;
use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\SdkContainer as BaseSdkContainer;
use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\ClientResponse as BaseClientResponse;

class ClientResponse extends BaseClientResponse
{
    public BaseSdkContainer $sdk;
    public object $pco;

    public function __construct(mixed $clientResponse)
    {
        $responseBody = $clientResponse->getBody()->getContents();
        $httpStatusCode = $clientResponse->getStatusCode();
        $httpMessage = $clientResponse->getReasonPhrase();

        if ($httpStatusCode >= HttpStatusCode::OK && $httpStatusCode < HttpStatusCode::MULTIPLE_CHOICES) {
            $success = true;
        }

        if ($httpStatusCode == HttpStatusCode::TOO_MANY_REQUESTS) {
            $rateLimited = true;
        }

        $this->sdk = new SdkContainer;
        $this->sdk->outcome->success = $success ?? false;
        $this->sdk->outcome->rateLimited = $rateLimited ?? false;
        $this->sdk->outcome->http->statusCode = $httpStatusCode ?? null;
        $this->sdk->outcome->http->message = $httpMessage ?? null;
        /** @deprecated use http->service instead */
        $this->sdk->outcome->http->pco = $responseBody;
        $this->sdk->outcome->http->service = $responseBody;
        $this->sdk->outcome->http->attempts = $this->attempts ?? 1;

        if ($success ?? false) {
            $responseBody = json_decode($responseBody);
            $this->pco = $responseBody;
            $this->sdk->page->previous = $responseBody->meta->prev->offset ?? null;
            $this->sdk->page->next = $responseBody->meta->next->offset ?? null;
        }
    }
}
