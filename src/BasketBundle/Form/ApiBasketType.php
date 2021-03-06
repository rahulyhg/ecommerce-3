<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\BasketBundle\Form;

use Sonata\Component\Currency\CurrencyFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class ApiBasketType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var CurrencyFormType
     */
    protected $currencyFormType;

    /**
     * @param string           $class            An entity data class
     * @param CurrencyFormType $currencyFormType A Sonata ecommerce currency form type
     */
    public function __construct($class, CurrencyFormType $currencyFormType)
    {
        $this->class = $class;
        $this->currencyFormType = $currencyFormType;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            $builder->create('currency', $this->currencyFormType)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'csrf_protection' => false,
            'validation_groups' => array('api'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sonata_basket_api_form_basket';
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
    public function getParent()
    {
        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
        return method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? 'Sonata\BasketBundle\Form\ApiBasketParentType'
            : 'sonata_basket_api_form_basket_parent';
    }
}
