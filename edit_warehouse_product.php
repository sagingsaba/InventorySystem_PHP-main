
<?php
  $page_title = 'Edit warehouse product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$wproduct = find_by_id('warehouse',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$wproduct){
  $session->msg("d","Missing product id.");
  redirect('warehouse_product.php');
}
?>

<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity', 'low-stock-quantity', 'buying-price', 'saleing-price' );
    validate_fields($req_fields);

   if(empty($errors)){
       $w_name  = remove_junk($db->escape($_POST['product-title']));
       $w_cat   = (int)$_POST['product-categorie'];
       $w_qty   = remove_junk($db->escape($_POST['product-quantity']));
       $w_ls   = remove_junk($db->escape($_POST['low-stock-quantity']));
       $w_buy   = remove_junk($db->escape($_POST['buying-price']));
       $w_sale  = remove_junk($db->escape($_POST['saleing-price']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE warehouse SET";
       $query  .=" name ='{$w_name}', quantity ='{$w_qty}', low_stock_quantity ='{$w_ls}', ";
       $query  .=" buy_price ='{$w_buy}', sale_price ='{$w_sale}', categorie_id ='{$w_cat}',media_id='{$media_id}'";
       $query  .=" WHERE id ='{$wproduct['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Product updated ");
                 redirect('warehouse_product.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('edit_warehouse_product.php?id='.$wproduct['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_warehouse_product.php?id='.$wproduct['id'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_warehouse_product.php?id=<?php echo (int)$wproduct['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($wproduct['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                    <option value=""> Select a categorie</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($wproduct['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value=""> No image</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($wproduct['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-5">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($wproduct['quantity']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-5">
                  <div class="form-group">
                    <label for="qty">Low Stock Quantity</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="low-stock-quantity" value="<?php echo remove_junk($wproduct['low_stock_quantity']); ?>">
                   </div>
                  </div>
                 </div>
                 
                 <div class="col-md-5">
                  <div class="form-group">
                    <label for="qty">Buying price</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                      <span>&#8369;</span>
                      </span>
                      <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($wproduct['buy_price']);?>">
                      <span class="input-group-addon">.00</span>
                   </div>
                  </div>
                 </div>
                  <div class="col-md-5">
                   <div class="form-group">
                     <label for="qty">Selling price</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                       <span>&#8369;</span>
                       </span>
                       <input type="number" class="form-control" name="saleing-price" value="<?php echo remove_junk($wproduct['sale_price']);?>">
                       <span class="input-group-addon">.00</span>
                    </div>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="product" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>

