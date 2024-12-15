<?php

declare(strict_types=1);

namespace Purchasehistory\Form\Type;

use PrestaShopBundle\Form\Admin\Type\CustomContentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Purchasehistory\Repository\PurchaseHistoryRepository;

final class PurchaseHistoryTabType extends TranslatorAwareType
{
    private PurchaseHistoryRepository $repository;

    /**
     * @param TranslatorInterface $translator
     * @param array $locales
     * @param PurchaseHistoryRepository $repository
     */
    public function __construct(
        TranslatorInterface $translator,
        array $locales,
        PurchaseHistoryRepository $repository,
    ) {
        parent::__construct($translator, $locales);
        $this->repository = $repository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     * @throws \PrestaShopDatabaseException
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder->add('purchase_history_table', CustomContentType::class, [
            'help' => $this->trans('Here is a preview of orders where product was sold.', 'Modules.Purchasehistory.Admin'),
            'template' => '@Modules/purchasehistory/views/templates/admin/tabs/purchase_history_grid.html.twig',
            'data' => [
                'purchase_history' => $this->repository->getPurchaseHistory($options['product_id']),
            ],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'label' => $this->trans('Purchase history', 'Modules.Purchasehistory.Admin', []),
                'product_id' => null,
            ])
            ->setAllowedTypes('product_id', ['null', 'int']);
    }
}
