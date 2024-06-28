<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

use Illuminate\Http\Client\Response;

class ClientResponse
{
    public MetaContainer $meta;
    public array|object|null $data;

    public function __construct(Response $response)
    {
        $this->meta = new MetaContainer;
        $this->meta->response = $response;
        $this->meta->success = $this->meta->response->successful();
        $this->meta->nextPage = $this->meta->response->json('meta.next.offset');
        $this->meta->previousPage = $this->meta->response->json('meta.prev.offset');
    }
}
