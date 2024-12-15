<?php

declare(strict_types=1);

namespace Purchasehistory\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Twig\Environment;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PrestaShop\PrestaShop\Core\Grid\GridFactoryInterface;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Purchasehistory\Repository\PurchaseHistoryRepository;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteria;

final class CustomTabType extends TranslatorAwareType
{
    private GridFactoryInterface $gridFactory;
    private Environment $twig;
    private PurchaseHistoryRepository $repository;

    /**
     * @param TranslatorInterface $translator
     * @param array $locales
     * @param GridFactoryInterface $gridFactory
     * @param PurchaseHistoryRepository $repository
     * @param Environment $twig
     */
    public function __construct(
        TranslatorInterface $translator,
        array $locales,
        GridFactoryInterface $gridFactory,
        PurchaseHistoryRepository $repository,
        Environment $twig
    ) {
        parent::__construct($translator, $locales);
        $this->gridFactory = $gridFactory;
        $this->repository = $repository;
        $this->twig = $twig;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $searchCriteria = new SearchCriteria();

        $gridData = $this->gridFactory->getGrid($searchCriteria)->getData();
        $gridHtml = $this->twig->render('@Modules/purchasehistory/views/templates/admin/purchase_history_grid.html.twig', [
            'gridData' => $gridData,
        ]);

        $builder->add('purchase_history_grid', CollectionType::class, [
            'mapped' => false,
            'allow_add' => $gridHtml,
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
