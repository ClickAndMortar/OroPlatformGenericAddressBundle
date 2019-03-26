<?php

namespace ClickAndMortar\GenericAddressBundle\Form;

use ClickAndMortar\SimpleItemBundle\Entity\Manager\SimpleItemManager;
use ClickAndMortar\SimpleItemBundle\Entity\SimpleItem;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraint;

/**
 * Address type
 *
 * @author  Simon CARRE <simon.carre@clickandmortar.fr>
 * @package ClickAndMortar\GenericAddressBundle\Form
 */
class AddressType extends AbstractType
{
    /**
     * Address validation group
     *
     * @var string
     */
    const ABSTRACT_ADDRESS_GROUP = 'AbstractAddress';

    /**
     * Address types list
     *
     * @var string
     */
    const LIST_VALUE_TYPES = 'addressTypes';

    /**
     * @var SimpleItemManager
     */
    protected $simpleItemManager;

    /**
     * AddressType constructor.
     *
     * @param SimpleItemManager $simpleItemManager
     */
    public function __construct(SimpleItemManager $simpleItemManager)
    {
        $this->simpleItemManager = $simpleItemManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('label', 'text',
                array(
                    'required' => true,
                    'label'    => 'candm.generic_address.address.label.label',
                )
            )
            ->add('primary', 'checkbox',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.primary.label',
                )
            )
            ->add('type', 'entity',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.type.label',
                    'class'    => SimpleItem::CLASS_NAME,
                    'choices'  => $this->simpleItemManager->getByListValue(self::LIST_VALUE_TYPES),
                ))
            ->add('firstName', 'text',
                array(
                    'required' => false,
                    'label'    => 'oro.address.first_name.label',
                )
            )
            ->add('lastName', 'text',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.last_name.label',
                )
            )
            ->add('street', 'text',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.street.label',
                )
            )
            ->add('street2', 'text',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.street2.label',
                )
            )
            ->add('postalCode', 'text',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.postal_code.label',
                )
            )
            ->add('city', 'text',
                array(
                    'required' => false,
                    'label'    => 'oro.address.city.label',
                )
            )
            ->add('country', 'oro_country',
                array(
                    'required' => false,
                    'label'    => 'oro.address.country.label',
                )
            )
            ->add('phone', 'text',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.phone.label',
                )
            )
            ->add('mobilePhone', 'text',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.mobile_phone.label',
                )
            )
            ->add('email', 'email',
                array(
                    'required' => false,
                    'label'    => 'candm.generic_address.address.email.label',
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'        => 'ClickAndMortar\GenericAddressBundle\Entity\Address',
                'intention'         => 'address',
                'single_form'       => true,
                'validation_groups' => [Constraint::DEFAULT_GROUP, self::ABSTRACT_ADDRESS_GROUP],
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'candm_address_type';
    }
}
