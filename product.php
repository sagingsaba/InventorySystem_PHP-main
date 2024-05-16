<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?> 

<style>
  @import url('https://fonts.cdnfonts.com/css/barcode-font');

  .barcode{
    font-family: 'barcode font', sans-serif;
    font-size: 90px;
    text-align: center;
  }
</style>
  
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
        <div class="pull-left">
          <a class="btn btn-warning" href="import-csv.php">Import</a>
          <form style="display:inline"action="export_function.php" method="post" name="upload_excel"   
             enctype="multipart/form-data">                
             <input type="submit" name="Export" class="btn btn-warning" value="EXPORT"/>
          </form>  
         </div>
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-warning">Add New</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
              <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 10%;"> Photo</th>
                <th class="text-center" style="width: 10%;"> Product Title </th>
                <th class="text-center" style="width: 10%;"> Barcode </th>
                <th class="text-center" style="width: 10%;"> Categories </th>
                <th class="text-center" style="width: 10%;"> In-Stock </th>
                <th class="text-center" style="width: 10%;"> Buying Price </th>
                <th class="text-center" style="width: 10%;"> Selling Price </th>
                <th class="text-center" style="width: 10%;"> Product Added </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="barcode"> <?php echo remove_junk($product['barcode']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity']); ?>
                <?php
                  if($product['quantity'] <=  $product['low_stock_quantity'] && $product['quantity'] > 0) {
                    echo "<div class='red'>Low stock</div>";
                  }
                  if ($product['quantity'] == 0) {
                    echo "<div class='red2'>Out of stock</div>";
                  }
                  
                ?>
              </td>
                <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['sale_price']); ?></td>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <style>
    .red{
      color: red;
    }
    .red2{
      color: red;
    }
    </style>
  <?php include_once('layouts/footer.php'); ?>

 