<?php

namespace App\FMS\Client;


use App\Data\Entities\Models\Customer\Customer;

class Manager
{
    private $client;

    public function __construct(Customer $client)
    {
        $this->client = $client;
    }

    public function create(int $siteId, array $details)
    {
        $details['site_id'] = $siteId;
        return $this->client->newInstance()->create($details);
    }

    public function update(Customer $client, array $details)
    {
        return $client->fill($details)->save();
    }

    public function find(int $id)
    {
        return $this->client->find($id);
    }
}
