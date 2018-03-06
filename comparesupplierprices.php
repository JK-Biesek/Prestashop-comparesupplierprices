<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class CompareSupplierPrices extends Module {

    public function __construct(){
        $this->name = 'comparesupplierprices';
        $this->tab = 'billing_invoicing';
        $this->version = '1.0';
        $this->author = 'Jakub Biesek';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Supplier price comparer ABC');
        $this->description = $this->l('Compare supplier price difference of products bought');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
      }

      public function install(){

        if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);

        if(!parent::install())
          return false;

          if(!$this->registerHook('displayAdminOrder'))
            return false;
          return true;
    }

    public function uninstall(){
      if (!parent::uninstall())
      return false;
    return true;
  }


}
