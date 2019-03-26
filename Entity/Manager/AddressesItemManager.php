<?php

namespace ClickAndMortar\GenericAddressBundle\Entity\Manager;

use ClickAndMortar\GenericAddressBundle\Model\AbstractAddressesItem;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Addresses item manager
 *
 * @author  Simon CARRE <simon.carre@clickandmortar.fr>
 * @package ClickAndMortar\GenericAddressBundle\Entity\Manager
 */
class AddressesItemManager
{
    /**
     * Storage manager
     *
     * @var ObjectManager
     */
    protected $om;

    /**
     * AddressesItemManager constructor.
     *
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Get addresses item entity by $className and $id
     *
     * @param string $className
     * @param int    $id
     *
     * @return AbstractAddressesItem
     */
    public function find($className, $id)
    {
        $repository = $this->getRepository($className);
        if ($repository !== null) {
            $addressesItem = $repository->find($id);

            return $addressesItem;
        }

        return null;
    }

    /**
     * Return repository by $class
     *
     * @param string $class
     *
     * @return ObjectRepository
     */
    public function getRepository($class)
    {
        return $this->getStorageManager()->getRepository($class);
    }

    /**
     * Retrieve object manager
     *
     * @return ObjectManager
     */
    public function getStorageManager()
    {
        return $this->om;
    }
}