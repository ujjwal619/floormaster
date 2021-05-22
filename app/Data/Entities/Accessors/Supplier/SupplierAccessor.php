<?php

namespace App\Data\Entities\Accessors\Supplier;

/**
 * Trait SupplierAccessor
 * @package App\Data\Entities\Accessors\Supplier
 */
trait SupplierAccessor
{
    /**
     * @return string
     */
    public function getFormattedAddressAttribute(): string
    {
        return $this->getFormattedAddress($this->address);
    }

    /**
     * Get the formatted address.
     * @param $address
     * @return string
     */
    public function getFormattedAddress($address): string
    {
        return sprintf('%s, %s, %s, %s', $address->street, $address->town, $address->state, $address->code);
    }

    /**
     * @return string
     */
    public function getFormattedPostalAddressAttribute(): string
    {
        return $this->getFormattedAddress($this->postal_address);
    }

    /**
     * @return string
     */
    public function getFormattedDeliveryAddressAttribute(): string
    {
        return $this->getFormattedAddress($this->delivery_address);
    }
}
