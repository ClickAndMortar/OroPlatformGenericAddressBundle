<?php

namespace ClickAndMortar\GenericAddressBundle\Controller;

use ClickAndMortar\GenericAddressBundle\Entity\Address;
use ClickAndMortar\GenericAddressBundle\Entity\Manager\AddressesItemManager;
use ClickAndMortar\GenericAddressBundle\Model\AbstractAddressesItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

/**
 * Address Controller
 *
 * @author  Simon CARRE <simon.carre@clickandmortar.fr>
 * @package ClickAndMortar\GenericAddressBundle\Controller
 */
class AddressController extends Controller
{
    /**
     * Display address book from address entity
     *
     * @param string $className
     * @param int    $id
     *
     * @return array
     * @Route("/address-book/{className}/{id}", name="candm_address_book", requirements={"className"=".+","id"="\d+"})
     * @Template()
     */
    public function addressBookAction($className, $id)
    {
        $addressesEntity = $this->getAddressesItemManager()->find($className, $id);

        return array(
            'entity' => $addressesEntity,
        );
    }

    /**
     * Create new address on addresses entity
     *
     * @param string $className
     * @param int    $addressesEntityId
     *
     * @return array
     * @Route(
     *      "/{className}/{addressesEntityId}/address-create",
     *      name="candm_address_create",
     *      requirements={"className"=".+","addressesEntityId"="\d+"}
     * )
     * @Template("ClickAndMortarGenericAddressBundle:Address:update.html.twig")
     * @ParamConverter("addressesEntity", options={"id" = "addressesEntityId"})
     */
    public function createAction($className, $addressesEntityId)
    {
        $addressesEntity = $this->getAddressesItemManager()->find($className, $addressesEntityId);

        return $this->update($addressesEntity, new Address());
    }

    /**
     * Update address
     *
     * @param string  $className
     * @param int     $addressesEntityId
     * @param Address $address
     *
     * @return array
     *
     * @Route(
     *      "/{className}/{addressesEntityId}/address-update/{id}",
     *      name="candm_address_update",
     *      requirements={"className"=".+","addressesEntityId"="\d+","id"="\d+"},defaults={"id"=0}
     * )
     * @Template
     */
    public function updateAction($className, $addressesEntityId, Address $address)
    {
        $addressesEntity = $this->getAddressesItemManager()->find($className, $addressesEntityId);

        return $this->update($addressesEntity, $address);
    }

    /**
     * Update address
     *
     * @param AbstractAddressesItem $addressesEntity
     * @param Address               $address
     *
     * @return array
     * @throws BadRequestHttpException
     */
    protected function update($addressesEntity, Address $address)
    {
        $responseData = array(
            'saved'           => false,
            'addressesEntity' => $addressesEntity,
        );
        if (!is_null($addressesEntity)) {
            $addressesEntity->addAddress($address);
            if ($this->get('candm.form.handler.address')->process($address)) {
                $manager   = $this->getDoctrine()->getManager();
                $addresses = $addressesEntity->getAddresses();

                // Add primary on first element
                if (
                    $addresses->count() == 1
                    || $addressesEntity->getPrimaryAddress() === null
                ) {
                    $address->setPrimary(true);
                }

                // Check for other primary address
                if ($address->isPrimary() && $addresses->count() != 1) {
                    foreach ($addressesEntity->getAddresses() as $otherAddress) {
                        if ($otherAddress->isPrimary() && $otherAddress->getId() != $address->getId()) {
                            $otherAddress->setPrimary(false);
                            $manager->persist($otherAddress);
                        }
                    }
                }

                // And save
                $manager->flush();
                $responseData['entity'] = $address;
                $responseData['saved']  = true;
            }
        }
        $responseData['form'] = $this->get('candm.address.form')->createView();

        return $responseData;
    }

    /**
     * Get addresses item manager
     *
     * @return AddressesItemManager
     */
    protected function getAddressesItemManager()
    {
        return $this->get('candm.addresses_item.manager');
    }
}
