<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

namespace Purchasehistory\Form\Modifier;

use Purchasehistory\Service\PurchaseHistoryService;
use PrestaShopBundle\Form\FormBuilderModifier;
use Purchasehistory\Form\Type\CustomTabType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductFormModifier
{
    private FormBuilderModifier $formBuilderModifier;
    private PurchaseHistoryService $purchaseHistoryService;

    /**
     * @param FormBuilderModifier $formBuilderModifier
     * @param PurchaseHistoryService $purchaseHistoryService
     */
    public function __construct(
        FormBuilderModifier $formBuilderModifier,
        PurchaseHistoryService $purchaseHistoryService
    ) {
        $this->formBuilderModifier = $formBuilderModifier;
        $this->purchaseHistoryService = $purchaseHistoryService;
    }

    /**
     * @param int $productId
     * @param FormBuilderInterface $productFormBuilder
     */
    public function modify(
        int $productId,
        FormBuilderInterface $productFormBuilder
    ): void {
        $purchaseHistory = $this->purchaseHistoryService->getPurchaseHistory($productId);

        $this->formBuilderModifier->addAfter(
            $productFormBuilder,
            'pricing',
            'purchase_history',
            CustomTabType::class,
            [
                'data' => [
                    'purchase_history' => $purchaseHistory,
                ],
            ]
        );
    }
}