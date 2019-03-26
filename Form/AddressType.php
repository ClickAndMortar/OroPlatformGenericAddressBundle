<?php

namespace ClickAndMortar\GenericAddressBundle\Form;

use ClickAndMortar\SimpleItemBundle\Entity\Manager\SimpleItemManager;
use ClickAndMortar\SimpleItemBundle\Entity\SimpleItem;
use Oro\Bundle\AddressBundle\Form\Type\CountryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('id', HiddenType::class)
            ->add('label', TextType::class,
                array(
                    'required' => true,
                    'label'    => 'clickandmortar.generic_address.address.label.label',
                )
            )
            ->add('primary', CheckboxType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.primary.label',
                )
            )
            ->add('type', EntityType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.type.label',
                    'class'    => SimpleItem::CLASS_NAME,
                    'choices'  => $this->simpleItemManager->getByListValue(self::LIST_VALUE_TYPES),
                ))
            ->add('firstName', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'oro.address.first_name.label',
                )
            )
            ->add('lastName', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.last_name.label',
                )
            )
            ->add('street', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.street.label',
                )
            )
            ->add('street2', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.street2.label',
                )
            )
            ->add('postalCode', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.postal_code.label',
                )
            )
            ->add('city', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'oro.address.city.label',
                )
            )
            ->add('country', CountryType::class,
                array(
                    'required' => false,
                    'label'    => 'oro.address.country.label',
                )
            )
            ->add('phone', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.phone.label',
                )
            )
            ->add('mobilePhone', TextType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.mobile_phone.label',
                )
            )
            ->add('email', EmailType::class,
                array(
                    'required' => false,
                    'label'    => 'clickandmortar.generic_address.address.email.label',
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
