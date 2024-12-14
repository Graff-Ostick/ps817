<?php

declare(strict_types=1);

namespace Purchasehistory\Form\Modifier;

use PrestaShopBundle\Form\FormBuilderModifier;
use Purchasehistory\Form\Type\CustomTabType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductFormModifier
{
    private FormBuilderModifier $formBuilderModifier;

    /**
     * @param FormBuilderModifier $formBuilderModifier
     */
    public function __construct(
        FormBuilderModifier $formBuilderModifier,
    ) {
        $this->formBuilderModifier = $formBuilderModifier;
    }

    /**
     * @param int $productId
     * @param FormBuilderInterface $productFormBuilder
     */
    public function modify(int $productId, FormBuilderInterface $productFormBuilder): void
    {
        $this->formBuilderModifier->addAfter(
            $productFormBuilder,
            'pricing',
            'purchase_history',
            CustomTabType::class,
            [
                'product_id' => $productId,
            ]
        );
    }
}