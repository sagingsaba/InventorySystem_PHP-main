<?php
  $page_title = 'All Warehouse Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $wproducts = join_warehouse_table();
?>
<?php include_once('layouts/header.php'); ?>
<style>
  .red {
    color: 		#ff9966;
    font-weight: 600;
  }

  .red2 {
    color: 		#cc3300;
    font-weight: 600;
  }
</style>  
  
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_warehouse_product.php" class="btn btn-primary">Add New</a>

         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Photo</th>
                <th> Product Title </th>
                <th class="text-center" style="width: 10%;"> Categories </th>
                <th class="text-center" style="width: 10%;"> In-Stock </th>
                <th class="text-center" style="width: 10%;"> Buying Price </th>
                <th class="text-center" style="width: 10%;"> Selling Price </th>
                <th class="text-center" style="width: 10%;"> Product Added </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($wproducts as $warehouse):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($warehouse['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $warehouse['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($warehouse['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($warehouse['categorie']); ?></td>
                <td class="text-center"> <?php echo remove_junk($warehouse['quantity']); ?>
                <?php
                  if($warehouse['quantity'] <=  $warehouse['low_stock_quantity'] && $warehouse['quantity'] > 0) {
                    echo "<div class='red'>Low stock</div>";
                  }
                  if ($warehouse['quantity'] == 0) {
                    echo "<div class='red2'>Out of stock</div>";
                  }
                  
                ?>
              </td>
                <td class="text-center"> <?php echo remove_junk($warehouse['buy_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($warehouse['sale_price']); ?></td>
                <td class="text-center"> <?php echo read_date($warehouse['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_warehouse_product.php?id=<?php echo (int)$warehouse['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_warehouse_product.php?id=<?php echo (int)$warehouse['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
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

  <?php include_once('layouts/footer.php'); ?>


