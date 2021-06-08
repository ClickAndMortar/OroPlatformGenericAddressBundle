<?php

namespace ClickAndMortar\GenericAddressBundle\Controller\Api\Rest;

use ClickAndMortar\GenericAddressBundle\Entity\Address;
use ClickAndMortar\GenericAddressBundle\Entity\Manager\AddressesItemManager;
use ClickAndMortar\GenericAddressBundle\Model\AbstractAddressesItem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;

/**
 * Class AddressController
 *
 * @author  Simon CARRE <simon.carre@clickandmortar.fr>
 * @package ClickAndMortar\GenericAddressBundle\Controller\Api\Rest
 *
 * @RouteResource("class_entity_address")
 * @NamePrefix("candm_api_")
 */
class AddressController extends RestController implements ClassResourceInterface
{
    /**
     * Get address
     *
     * @param string $className
     * @param string $addressesEntityId
     * @param string $addressId
     *
     * @return Response
     * @ApiDoc(
     *      description="Get address",
     *      resource=true
     * )
     */
    public function getAction($className, $addressesEntityId, $addressId)
    {
        /** @var AbstractAddressesItem $addressesEntity */
        $addressesEntity = $this->getAddressesItemManager()->find($className, $addressesEntityId);

        /** @var Address $address */
        $address = $this->getManager()->find($addressId);

        $addressData = null;
        if ($address && $addressesEntity->getAddresses()->contains($address)) {
            $addressData = $this->getPreparedItem($address);
        }
        $responseData = $addressData ? json_encode($addressData) : '';

        return new Response($responseData, $address ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    /**
     * Get addresses
     *
     * @param string $className
     * @param int    $addressesEntityId
     *
     * @return JsonResponse
     * @ApiDoc(
     *      description="Get all addresses items",
     *      resource=true
     * )
     */
    public function cgetAction($className, $addressesEntityId)
    {
        /** @var AbstractAddressesItem $addressesEntity */
        $addressesEntity = $this->getAddressesItemManager()->find($className, $addressesEntityId);
        $result          = [];

        if (!empty($addressesEntity)) {
            $items = $addressesEntity->getAddresses();

            foreach ($items as $item) {
                $result[] = $this->getPreparedItem($item);
            }
        }

        return new JsonResponse(
            $result,
            empty($addressesEntity) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK
        );
    }

    /**
     * Delete address
     *
     * @param string $className
     * @param int    $addressesEntityId
     * @param int    $addressId
     *
     * @return Response
     * @ApiDoc(
     *      description="Delete address items",
     *      resource=true
     * )
     */
    public function deleteAction($className, $addressesEntityId, $addressId)
    {
        /** @var Address $address */
        $address = $this->getManager()->find($addressId);
        /** @var AbstractAddressesItem $addressesEntity */
        $addressesEntity = $this->getAddressesItemManager()->find($className, $addressesEntityId);
        if ($addressesEntity->getAddresses()->contains($address)) {
            $addressesEntity->removeAddress($address);

            return $this->handleDeleteRequest($addressId);
        } else {
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        }
    }

    /**
     * Get primary address
     *
     * @param string $className
     * @param int    $addressesEntityId
     *
     * @return Response
     * @ApiDoc(
     *      description="Get contact primary address",
     *      resource=true
     * )
     */
    public function getPrimaryAction($className, $addressesEntityId)
    {
        /** @var AbstractAddressesItem $addressesEntity */
        $addressesEntity = $this->getAddressesItemManager()->find($className, $addressesEntityId);

        if (!is_null($addressesEntity)) {
            $address = $addressesEntity->getPrimaryAddress();
        } else {
            $address = null;
        }
        $responseData = $address ? json_encode($this->getPreparedItem($address)) : '';

        return new Response($responseData, $address ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
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

    /**
     * {@inheritdoc}
     */
    public function getManager()
    {
        return $this->get('candm.address.manager.api');
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        throw new \BadMethodCallException('Form is not available.');
    }

    /**
     * {@inheritdoc}
     */
    public function getFormHandler()
    {
        throw new \BadMethodCallException('FormHandler is not available.');
    }

    /**
     * {@inheritDoc}
     */
    protected function getPreparedItem($entity, $resultFields = [])
    {
        $result                = parent::getPreparedItem($entity);
        $result['countryIso2'] = $entity->getCountryIso2();
        $result['countryIso3'] = $entity->getCountryIso2();
        $result['regionCode']  = $entity->getRegionCode();
        $result['country']     = $entity->getCountryName();

        return $result;
    }
}
