<?php

declare(strict_types=1);

namespace Purchasehistory\Grid\Definition;

use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\ViewOptionsCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\GridDefinitionFactoryInterface;
use PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinition;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;

final class PurchaseHistoryGridDefinitionFactory implements GridDefinitionFactoryInterface
{
    public function getDefinition(): GridDefinition
    {

        $columns = new ColumnCollection();
        $columns->add(new DataColumn('order_reference', [
            'label' => 'Order Reference',
            'sortable' => true,
        ]));
        $columns->add(new DataColumn('purchase_date', [
            'label' => 'Purchase Date',
            'sortable' => true,
        ]));

        $filters = new FilterCollection();
        $gridActions = new GridActionCollection();
        $bulkActions = new BulkActionCollection();
        $viewOptions = new ViewOptionsCollection();

        return new GridDefinition(
            'purchase_history_grid',
            'Purchase History Grid',
            $columns,
            $filters,
            $gridActions,
            $bulkActions,
            $viewOptions
        );
    }
}