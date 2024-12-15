<?php

declare(strict_types=1);

namespace Purchasehistory\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class PurchaseHistoryRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $dbPrefix;

    /**
     * * @param Connection $connection
     * * @param string $dbPrefix
     */
    public function __construct(
        Connection $connection,
        string $dbPrefix
    ) {
        $this->connection = $connection;
        $this->dbPrefix = $dbPrefix;
    }

    /**
     * @param int $productId
     * @return array
     * @throws Exception
     */
    public function getPurchaseHistory(int $productId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('od.product_id', 'o.id_order', 'o.date_add AS purchase_date', 'od.product_quantity', 'od.unit_price_tax_incl')
            ->from($this->dbPrefix . 'order_detail', 'od')
            ->innerJoin('od', $this->dbPrefix . 'orders', 'o', 'od.id_order = o.id_order')
            ->where($qb->expr()->eq('od.product_id', ':productId'))
            ->orderBy('o.date_add', 'DESC')
            ->setParameter('productId', $productId);

        return $qb->execute()->fetchAll();
    }
}
