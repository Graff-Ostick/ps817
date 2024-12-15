<?php

declare(strict_types=1);

namespace Purchasehistory\Grid\Data\Factory;

use PrestaShop\PrestaShop\Core\Grid\Data\Factory\GridDataFactoryInterface;
use PrestaShop\PrestaShop\Core\Grid\Record\RecordCollection;
use PrestaShop\PrestaShop\Core\Grid\Data\GridData;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;
use Purchasehistory\Grid\Data\PurchaseHistoryGridDataProvider;

final class PurchaseHistoryGridDataFactory implements GridDataFactoryInterface
{
    private PurchaseHistoryGridDataProvider $dataProvider;

    public function __construct(PurchaseHistoryGridDataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function getData(SearchCriteriaInterface $searchCriteria): GridData
    {
        $data = $this->dataProvider->getData($searchCriteria);

        return new GridData(
            new RecordCollection($data['data']),
            $data['recordsTotal'],
            $data['recordsFiltered']
        );
    }
}
