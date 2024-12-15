<?php

declare(strict_types=1);

use Purchasehistory\Form\Modifier\ProductFormModifier;

if (!defined('_PS_VERSION_')) {
    exit;
}

class PurchaseHistory extends Module
{
    public function __construct()
    {
        $this->name = 'purchasehistory';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Graff Ostick';
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Purchase History');
        $this->description = $this->l('Adds a new "Purchase History" tab to the product page.');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook(['actionProductFormBuilderModifier']);
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookActionProductFormBuilderModifier(array $params): void
    {
        /** @var ProductFormModifier $productFormModifier */
        $productFormModifier = $this->get(ProductFormModifier::class);
        $productId = (int) $params['id'];

        $productFormModifier->modify($productId, $params['form_builder']);
    }
}
