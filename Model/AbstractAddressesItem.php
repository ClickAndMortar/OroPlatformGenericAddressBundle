<?php

namespace ClickAndMortar\GenericAddressBundle\Model;

use ClickAndMortar\GenericAddressBundle\Entity\Address;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Abstract addresses item
 *
 * @author  Simon CARRE <simon.carre@clickandmortar.fr>
 * @package ClickAndMortar\GenericAddressBundle\Model
 */
abstract class AbstractAddressesItem
{
    /**
     * Addresses
     *
     * @var Collection | Address[]
     */
    protected $addresses;

    /**
     * Constructor
     *
     * The real implementation of this method is auto generated.
     *
     * IMPORTANT: If the derived class has own constructor it must call parent constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * Get addresses
     *
     * @return Collection|Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Has address
     *
     * @param Address $address
     *
     * @return bool
     */
    public function hasAddress(Address $address)
    {
        return $this->getAddresses()->contains($address);
    }

    /**
     * Set primary address
     *
     * @param Address $address
     *
     * @return AbstractAddressesItem
     */
    public function setPrimaryAddress(Address $address)
    {
        if ($this->hasAddress($address)) {
            $address->setPrimary(true);
            /** @var Address $otherAddress */
            foreach ($this->getAddresses() as $otherAddress) {
                if (!$address->isEqual($otherAddress)) {
                    $otherAddress->setPrimary(false);
                }
            }
        }

        return $this;
    }

    /**
     * Gets primary address if it's available
     *
     * @return Address|null
     */
    public function getPrimaryAddress()
    {
        /** @var Address $address */
        foreach ($this->getAddresses() as $address) {
            if ($address->isPrimary()) {
                return $address;
            }
        }

        return null;
    }

    /**
     * Add address
     *
     * @param Address $address
     *
     * @return AbstractAddressesItem
     */
    public function addAddress(Address $address)
    {
        if (!$address instanceof Address) {
            throw new \InvalidArgumentException("Address must be instance of Address");
        }

        /** @var AbstractAddressesItem $address */
        if (!$this->addresses->contains($address)) {
            // Add additional data on address
            $additionalData = array(
                Address::SERIALIZED_KEY_ADDRESSES_ENTITY_ID    => $this->getId(),
                Address::SERIALIZED_KEY_ADDRESSES_ENTITY_CLASS => get_class($this),
            );
            $address->setSerializedDataAsArray($additionalData);

            $this->addresses->add($address);
        }

        return $this;
    }

    /**
     * Remove address
     *
     * @param Address $address
     *
     * @return AbstractAddressesItem
     */
    public function removeAddress(Address $address)
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }

    /**
     * Set addresses.
     *
     * This method could not be named setAddresses because of bug CRM-253.
     *
     * @param Collection|Address[] $addresses
     *
     * @return AbstractAddressesItem
     */
    public function resetAddresses($addresses)
    {
        $this->addresses->clear();

        foreach ($addresses as $address) {
            $this->addAddress($address);
        }

        return $this;
    }

    /**
     * Get current class name
     *
     * @return string
     */
    public function getClassName()
    {
        return (new \ReflectionClass($this))->getName();
    }
}