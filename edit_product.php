<?php
$page_title = 'Edit product';
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(2);
?>
<?php
$product = find_by_id('products', (int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$product){
  $session->msg("d", "Missing product id.");
  redirect('product.php');
}
?>

<?php
if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity', 'low-stock-quantity', 'buying-price', 'saleing-price');
    validate_fields($req_fields);

    if(empty($errors)){
        $p_name  = remove_junk($db->escape($_POST['product-title']));
        $p_cat   = (int)$_POST['product-categorie'];
        $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
        $p_ls    = remove_junk($db->escape($_POST['low-stock-quantity']));
        $p_buy   = remove_junk($db->escape($_POST['buying-price']));
        $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
        if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
            $media_id = '0';
        } else {
            $media_id = remove_junk($db->escape($_POST['product-photo']));
        }

        $original_qty = (int)$product['quantity'];
        $new_qty = (int)$p_qty;
        $qty_diff = $new_qty - $original_qty;

        $warehouse_query = "SELECT quantity, barcode FROM warehouse WHERE name = '{$product['name']}' AND categorie_id = '{$product['categorie_id']}'";
        $warehouse_result = $db->query($warehouse_query);

        if($db->num_rows($warehouse_result) > 0){
            $warehouse_data = $db->fetch_assoc($warehouse_result);
            $warehouse_qty = $warehouse_data['quantity'];
            $barcode = $warehouse_data['barcode'];

            $new_warehouse_qty = $warehouse_qty - $qty_diff;
            if($new_warehouse_qty >= 0){
                $update_warehouse_query = "UPDATE warehouse SET quantity = '{$new_warehouse_qty}' WHERE name = '{$product['name']}' AND categorie_id = '{$product['categorie_id']}'";

                if($db->query($update_warehouse_query)){
                    $query  = "UPDATE products SET";
                    $query .= " name ='{$p_name}', quantity ='{$p_qty}', low_stock_quantity ='{$p_ls}', ";
                    $query .= " buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}', media_id='{$media_id}'";
                    $query .= " WHERE id ='{$product['id']}'";
                    $result = $db->query($query);
                    
                    if($result && $db->affected_rows() === 1){
                        $session->msg('s', "Product updated ");
                        redirect('product.php', false);
                    } else {
                        $session->msg('d', 'Sorry, failed to update the product!');
                        redirect('edit_product.php?id='.$product['id'], false);
                    }
                } else {
                    $session->msg('d', 'Failed to update warehouse quantity.');
                    redirect('edit_product.php?id='.$product['id'], false);
                }
            } else {
                $session->msg('d', 'Insufficient quantity in warehouse.');
                redirect('edit_product.php?id='.$product['id'], false);
            }
        } else {
            $session->msg('d', 'Product not found in warehouse.');
            redirect('edit_product.php?id='.$product['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_product.php?id='.$product['id'], false);
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
        <span>Edit Product</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-7">
        <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>">
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <select class="form-control" name="product-categorie">
                  <option value=""> Select a category</option>
                  <?php foreach ($all_categories as $cat): ?>
                    <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?>>
                      <?php echo remove_junk($cat['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <select class="form-control" name="product-photo">
                  <option value=""> No image</option>
                  <?php foreach ($all_photo as $photo): ?>
                    <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?>>
                      <?php echo $photo['file_name'] ?>
                    </option>
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
                    <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
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
                    <input type="number" class="form-control" name="low-stock-quantity" value="<?php echo remove_junk($product['low_stock_quantity']); ?>">
                  </div>
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label for="qty">Buying Price</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <span>&#8369;</span>
                    </span>
                    <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($product['buy_price']);?>">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label for="qty">Selling Price</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <span>&#8369;</span>
                    </span>
                    <input type="number" class="form-control" name="saleing-price" value="<?php echo remove_junk($product['sale_price']);?>">
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
