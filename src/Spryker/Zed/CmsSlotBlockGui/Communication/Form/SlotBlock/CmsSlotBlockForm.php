<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Communication\Form\SlotBlock;

use Generated\Shared\Transfer\CmsSlotBlockTransfer;
use Generated\Shared\Transfer\CmsSlotTemplateConfigurationTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Spryker\Zed\CmsSlotBlockGui\Communication\CmsSlotBlockGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CmsSlotBlockGui\CmsSlotBlockGuiConfig getConfig()
 */
class CmsSlotBlockForm extends AbstractType
{
    protected const FIELD_ID_SLOT_TEMPLATE = 'idSlotTemplate';
    protected const FIELD_ID_SLOT = 'idSlot';
    protected const FIELD_ID_CMS_BLOCK = 'idCmsBlock';
    protected const FIELD_POSITION = 'position';
    protected const OPTION_CONDITIONS = 'conditions';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CmsSlotBlockTransfer::class]);
        $resolver->setRequired([static::OPTION_CONDITIONS]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addIdSlotTemplateField($builder)
            ->addIdSlotField($builder)
            ->addIdBlockField($builder)
            ->addPositionField($builder)
            ->addPluginForms($builder, $options);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdSlotTemplateField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_ID_SLOT_TEMPLATE, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdSlotField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_ID_SLOT, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdBlockField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_ID_CMS_BLOCK, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPositionField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_POSITION, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addPluginForms(FormBuilderInterface $builder, array $options)
    {
        $builder->add(static::OPTION_CONDITIONS, FormType::class, ['label' => false]);

        $cmsSlotTemplateConfigurationTransfer = (new CmsSlotTemplateConfigurationTransfer())->setConditions($options[static::OPTION_CONDITIONS]);

        foreach ($this->getFactory()->getCmsSlotBlockFormPlugins() as $formPlugin) {
            if ($formPlugin->isApplicable($cmsSlotTemplateConfigurationTransfer)) {
                $formPlugin->addConditionForm($builder->get(static::OPTION_CONDITIONS));
            }
        }

        return $this;
    }
}
