<?php

namespace ClickAndMortar\GenericAddressBundle\Migrations\Data\ORM;

use ClickAndMortar\GenericAddressBundle\Entity\Activity;
use ClickAndMortar\SimpleItemBundle\Entity\SimpleItem;
use ClickAndMortar\SimpleItemBundle\Entity\SimpleList;
use ClickAndMortar\SimpleItemBundle\Migrations\Data\ORM\LoadAbstractSimpleItems;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class LoadAddressSimpleLists
 *
 * @author  Simon CARRE <simon.carre@clickandmortar.fr>
 * @package ClickAndMortar\GenericAddressBundle\Migrations\Data\ORM
 */
class LoadAddressSimpleLists extends LoadAbstractSimpleItems
{
    /**
     * Get lists as array
     *
     * @return array
     */
    public function getLists()
    {
        return array(
            array(
                'label' => 'Type d\'adresse',
                'value' => 'addressTypes',
                'items' => array(
                    array(
                        'label' => 'Livraison',
                        'value' => 'shipping',
                    ),
                    array(
                        'label' => 'Facturation',
                        'value' => 'billing',
                    ),
                ),
            ),
            array(
                'label' => 'Civilité',
                'value' => 'addressTitles',
                'items' => array(
                    array(
                        'label' => 'M.',
                        'value' => 'm',
                    ),
                    array(
                        'label' => 'Mme',
                        'value' => 'mme',
                    ),
                ),
            ),
        );
    }
}