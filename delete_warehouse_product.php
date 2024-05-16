<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $wproduct = find_by_id('warehouse',(int)$_GET['id']);
  if(!$wproduct){
    $session->msg("d","Missing Product id.");
    redirect('warehouse_product.php');
  }
?>
<?php
  $delete_id = delete_by_id('warehouse',(int)$wproduct['id']);
  if($delete_id){
      $session->msg("s","Warehouse Products deleted.");
      redirect('warehouse_product.php');
  } else {
      $session->msg("d","Products deletion failed.");
      redirect('warehouse_product.php');
  }
?>
