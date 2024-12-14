<?php

declare(strict_types=1);

namespace Purchasehistory\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Twig\Environment;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Purchasehistory\Repository\PurchaseHistoryRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class CustomTabType extends TranslatorAwareType
{
    private PurchaseHistoryRepository $repository;
    private Environment $twig;
    private TranslatorInterface $translator;

    /**
     * @param TranslatorInterface $translator
     * @param array $locales
     * @param PurchaseHistoryRepository $repository
     * @param Environment $twig
     */
    public function __construct(
        TranslatorInterface $translator,
        array $locales,
        PurchaseHistoryRepository $repository,
        Environment $twig
    ) {
        parent::__construct($translator, $locales);
        $this->repository = $repository;
        $this->twig = $twig;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $purchaseHistory = $this->repository->getPurchaseHistory($options['product_id']);

        $builder->add('purchase_history', TextareaType::class, [
            'label' => false,
            'data' => $this->twig->render('@Modules/purchasehistory/views/templates/admin/purchase_history.html.twig', [
                'purchaseHistory' => $purchaseHistory,
            ]),
            'attr' => [
                'readonly' => true,
                'style' => 'background: transparent; border: none; resize: none;',
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
                'label' => $this->trans('Purchase history', 'Modules.Purchasehistory.Admin'),
                'product_id' => null,
            ])
            ->setAllowedTypes('product_id', ['null', 'int']);
    }
}