<?php

declare(strict_types=1);

namespace Purchasehistory\Repository;

use Db;

final class PurchaseHistoryRepository
{
    /**
     * @param int $productId
     * @return array
     * @throws \PrestaShopDatabaseException
     */
    public function getPurchaseHistory(int $productId): array
    {
        $sql = '
            SELECT od.product_id, o.date_add AS purchase_date, od.product_quantity, od.unit_price_tax_incl
            FROM ' . _DB_PREFIX_ . 'order_detail od
            INNER JOIN ' . _DB_PREFIX_ . 'orders o ON od.id_order = o.id_order
            WHERE od.product_id = ' . (int)$productId . ' 
            AND o.valid = 1
            ORDER BY o.date_add DESC
        ';

//        todo like this
//        $qb = $this->connection->createQueryBuilder();
//        $qb
//            ->select('cc.id_cms_category, ccl.name')
//            ->from($this->dbPrefix . 'cms_category', 'cc')
//            ->innerJoin('cc', $this->dbPrefix . 'cms_category_lang', 'ccl', 'cc.id_cms_category = ccl.id_cms_category')
//            ->innerJoin('cc', $this->dbPrefix . 'cms_category_shop', 'ccs', 'cc.id_cms_category = ccs.id_cms_category')
//            ->andWhere('cc.active = 1')
//            ->andWhere('ccl.id_lang = :idLang')
//            ->andWhere('ccs.id_shop IN (:shopIds)')
//            ->setParameter('idLang', $this->idLang)
//            ->setParameter('shopIds', implode(',', $this->shopIds))
//            ->orderBy('ccl.name')
//        ;
//        $categories = $qb->execute()->fetchAll();
//        $choices = [];
//        foreach ($categories as $category) {
//            $choices[$category['name']] = $category['id_cms_category'];
//        }

        return Db::getInstance()->executeS($sql);
    }
}
