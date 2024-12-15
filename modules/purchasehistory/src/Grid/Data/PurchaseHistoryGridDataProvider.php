<?php

declare(strict_types=1);

namespace Purchasehistory\Grid\Data;

use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;
use Purchasehistory\Repository\PurchaseHistoryRepository;

final class PurchaseHistoryGridDataProvider
{
    private PurchaseHistoryRepository $repository;

    public function __construct(PurchaseHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getData(SearchCriteriaInterface $searchCriteria): array
    {

        $productId = $searchCriteria->getFilters()['product_id'] ?? null;
        $purchaseHistory = $this->repository->getPurchaseHistory((int) $productId);

        return [
            'data' => $purchaseHistory,
            'recordsTotal' => count($purchaseHistory),
            'recordsFiltered' => count($purchaseHistory),
        ];
    }
}
