<?php

namespace ClickAndMortar\GenericAddressBundle\Entity;

use ClickAndMortar\SimpleItemBundle\Entity\SimpleItem;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\AddressBundle\Entity\AbstractAddress;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * Address
 *
 * @author  Simon CARRE <simon.carre@clickandmortar.fr>
 * @package ClickAndMortar\GenericAddressBundle\Controller
 *
 * @ORM\Entity()
 * @ORM\Table(name="candm_address")
 * @Config()
 */
class Address extends AbstractAddress
{
    /**
     * Addresses entity id key
     *
     * @var string
     */
    const SERIALIZED_KEY_ADDRESSES_ENTITY_ID = 'addressesEntityId';

    /**
     * Addresses entity class key
     *
     * @var string
     */
    const SERIALIZED_KEY_ADDRESSES_ENTITY_CLASS = 'addressesEntityClass';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_primary", type="boolean", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=150
     *          }
     *      }
     * )
     */
    protected $primary;

    /**
     * @ORM\ManyToOne(targetEntity="ClickAndMortar\SimpleItemBundle\Entity\SimpleItem")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=160
     *          }
     *      }
     * )
     *
     * @var SimpleItem
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="ClickAndMortar\SimpleItemBundle\Entity\SimpleItem")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=165
     *          }
     *      }
     * )
     *
     * @var SimpleItem
     */
    protected $title;

    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     * * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=170
     *          }
     *      }
     * )
     *
     * @var string
     */
    protected $phone;

    /**
     * @ORM\Column(name="mobile_phone", type="string", nullable=true)
     * * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=180
     *          }
     *      }
     * )
     *
     * @var string
     */
    protected $mobilePhone;

    /**
     * @ORM\Column(name="email", type="string", nullable=true)
     * * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=190
     *          }
     *      }
     * )
     *
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(name="comment", type="text", nullable=true)
     * * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=200
     *          }
     *      }
     * )
     *
     * @var string
     */
    protected $comment;

    /**
     * Used to store usefull data
     *
     * @ORM\Column(name="serialized_data", type="text", nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     *
     * @var string
     */
    protected $serializedData;

    /**
     * Address constructor.
     */
    public function __construct()
    {
        $this->primary = false;
    }

    /**
     * Set primary
     *
     * @param bool $primary
     *
     * @return Address
     */
    public function setPrimary($primary)
    {
        $this->primary = (bool)$primary;

        return $this;
    }

    /**
     * Is primary
     *
     * @return bool
     */
    public function isPrimary()
    {
        return (bool)$this->primary;
    }

    /**
     * Get type
     *
     * @return SimpleItem
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param SimpleItem $type
     *
     * @return Address
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return SimpleItem
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param SimpleItem $title
     *
     * @return Address
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Address
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get mobile phone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set mobile phone
     *
     * @param string $mobilePhone
     *
     * @return Address
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Address
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return Address
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getSerializedData()
    {
        return $this->serializedData;
    }

    /**
     * @return array
     */
    public function getSerializedDataAsArray()
    {
        $serializedDataAsJson = $this->getSerializedData();

        return json_decode($serializedDataAsJson, true);
    }

    /**
     * @param string $serializedData
     *
     * @return Address
     */
    public function setSerializedData($serializedData)
    {
        $this->serializedData = $serializedData;

        return $this;
    }

    /**
     * @param array $serializedData
     *
     * @return Address
     */
    public function setSerializedDataAsArray($serializedData)
    {
        $serializedDataAsJson = json_encode($serializedData);

        return $this->setSerializedData($serializedDataAsJson);
    }

    /**
     * Check if current address is linked to $classname
     *
     * @param string $classname
     *
     * @return boolean
     */
    public function isLinkedTo($classname)
    {
        $serializedData = $this->getSerializedDataAsArray();
        if (
            !empty($serializedData)
            && array_key_exists(self::SERIALIZED_KEY_ADDRESSES_ENTITY_CLASS, $serializedData)
            && $classname === $serializedData[self::SERIALIZED_KEY_ADDRESSES_ENTITY_CLASS]
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get linked entity id from serialized properties
     *
     * @return int
     */
    public function getLinkedEntityId()
    {
        $serializedData = $this->getSerializedDataAsArray();
        if (
            !empty($serializedData)
            && array_key_exists(self::SERIALIZED_KEY_ADDRESSES_ENTITY_ID, $serializedData)
        ) {
            return $serializedData[self::SERIALIZED_KEY_ADDRESSES_ENTITY_ID];
        }

        return null;
    }
}