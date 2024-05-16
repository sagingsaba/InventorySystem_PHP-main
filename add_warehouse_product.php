<?php
  $page_title = 'Add Warehouse Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');

  // Automatically generate barcode
  $generated_barcode = barcode_generator();
?>
<?php
 if(isset($_POST['add_warehouse_product'])){
   $req_fields = array('product-title','product-categorie','barcodeInput','product-quantity','low-stock-quantity', 'buying-price', 'saleing-price' );
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_ls   = remove_junk($db->escape($_POST['low-stock-quantity']));
     $p_buy   = remove_junk($db->escape($_POST['buying-price']));
     $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
     $p_bcode = remove_junk($db->escape($_POST['barcodeInput']));
     if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
       $media_id = '0';
     } else {
       $media_id = remove_junk($db->escape($_POST['product-photo']));
     }
     $date    = make_date();
     $query  = "INSERT INTO warehouse (";
     $query .=" name,quantity,barcode,low_stock_quantity, buy_price,sale_price,categorie_id,media_id,date";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_qty}','{$p_bcode}', '{$p_ls}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '{$date}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
     if($db->query($query)){
       $session->msg('s',"Product added ");
       redirect('add_warehouse_product.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_warehouse_product.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Warehouse Product.</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_warehouse_product.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Product Title" value="<?php echo isset($_POST['product-title']) ? $_POST['product-title'] : ''; ?>">
               </div>
              </div>
              <div class="form-group">
              <div class="input-group">
              <span class="input-group-addon">
              <i class="glyphicon glyphicon-barcode"></i>
            </span>
                <div class="row">
                  <div class="col-md-6">
                   <input type="text" class="form-control" id="barcodeInput" name="barcodeInput" placeholder="Generated Barcode" value="<?php echo $generated_barcode; ?>">           
                  </div>
                </div>
              </div>             
              <br>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                      <option value="">Select Product Category</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>" <?php echo isset($_POST['product-categorie']) && $_POST['product-categorie'] == $cat['id'] ? 'selected' : ''; ?>>
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value="">Select Product Photo</option>
                    <?php  foreach ($all_photo as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>" <?php echo isset($_POST['product-photo']) && $_POST['product-photo'] == $photo['id'] ? 'selected' : ''; ?>>
                        <?php echo $photo['file_name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity" value="<?php echo isset($_POST['product-quantity']) ? $_POST['product-quantity'] : ''; ?>">
                  </div>
                 </div>
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="low-stock-quantity" placeholder="Low Stock Quantity" value="<?php echo isset($_POST['low-stock-quantity']) ? $_POST['low-stock-quantity'] : ''; ?>">
                  </div>
                 </div>
                </div>
              </div>
              <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                   <div class="input-group">
                     <span class="input-group-addon">
                     <span>&#8369;</span>
                     </span>
                     <input type="number" class="form-control" name="buying-price" placeholder="Buying Price" value="<?php echo isset($_POST['buying-price']) ? $_POST['buying-price'] : ''; ?>">
                     <span class="input-group-addon">.00</span>
                  </div>
                 </div>
                  <div class="col-md-5">
                    <div class="input-group">
                      <span class="input-group-addon">
                      <span>&#8369;</span>
                      </span>
                      <input type="number" class="form-control" name="saleing-price" placeholder="Selling Price" value="<?php echo isset($_POST['saleing-price']) ? $_POST['saleing-price'] : ''; ?>">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="add_warehouse_product" class="btn btn-danger">Add product</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<!-- <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Warehouse Product Via Scanner</span>
         </strong>
        </div>
        <div class="panel-body">
          <div class="col-md-12">

          </div>

        </div>
      
      </div>
    </div>
  </div>-->
  

<?php include_once('layouts/footer.php'); ?>

<?php
// Function to generate a unique barcode
function barcode_generator(){
  global $db;

  $is_unique = false;
  $barcode = '';

  while (!$is_unique) {
      $barcode = substr(str_shuffle("1234567890"), 0, 10);

      $query = "SELECT COUNT(id) AS total FROM warehouse WHERE barcode = '{$barcode}'";
      $result = $db->query($query);
      $row = $db->fetch_assoc($result);

      if ($row['total'] == 0) {
          $is_unique = true;
      }
  }

  return $barcode;
}
?>
