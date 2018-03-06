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
    
public function hookDisplayAdminOrder($params) {
 
    $order = new Order((int) Tools::getValue('id_order'));
    $cart = new Cart($order->id_cart);
    $products_temp = $cart->getProducts();
    $products= array();
    $id_customer = $this->context->customer->id;
           
    $supplier_total = array();
    $total_supplier_name = array();
  
    foreach ($products_temp => $val) {

          $product = array();
          $product['id_product'] = $val['id_product'];
          $product['name'] = $val['name'];
          $product['quantity'] = $val['quantity'];
          $product['price'] = $val['price'];
          $product['supplier_reference'] = $val['supplier_reference'];
          $product['id_supplier'] = $val['id_supplier'];
          $details = $this->getProdDetails((int) Tools::getValue('id_order'), $val['id_product'], $val['id_product_attribute']);
          $product['wholesale_price'] = $details['purchase_supplier_price'];
          $product['attr_name'] = $val['attributes'];
        
        $products[] = $product;
          $supplier_object = new Supplier($product['id_supplier']);
          $supplier_name = preg_replace("/[^A-Za-z0-9]/", "", mb_strtolower($supplier_object->name));
          $products_details[$product['id_supplier']][] = array(
            'id_product'=>$product['id_product'],
            'id_product_attribute'=>$val['id_product_attribute'],
            'name'=>$product['name'],
            'supplier_name'=> $supplier_name,
            'reference'=>$val['reference'],
            'wholesale_price'=>$product['wholesale_price'],
            'quantity'=>$product['quantity']
          );
        
        if($product != 0 ){
               $sql = 'SELECT ps.*,s.name,l.name as product,l.id_lang FROM ' . _DB_PREFIX_ . 'product_supplier ps
               INNER join ps_supplier s on ps.id_supplier = s.id_supplier
               INNER join ps_product_lang l on ps.id_product = l.id_product
               WHERE ps.id_product = '.$product['id_product'].'
               AND ps.id_product_attribute = '.$val['id_product_attribute'].' and l.id_lang=1 group by s.id_supplier';
              $res = Db::getInstance()->executeS($sql);
        }
    }   
  }
    public function getProdDetails($id_order, $id_product, $id_product_attribute){
          $db = Db::getInstance();

          $sql = "SELECT * FROM "._DB_PREFIX_."order_detail
                  WHERE id_order=".$id_order. "
                  AND product_id=".$id_product. "
                  AND product_attribute_id=".$id_product_attribute;

          if ($row = Db::getInstance()->getRow($sql))
                return $row;
  }
 }
