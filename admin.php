<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
   page_require_level(1);
?>
<?php
 $c_categorie     = count_by_id('categories');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sales');
 $c_user          = count_by_id('users');
 $products_sold   = find_higest_saleing_product('10');
 $recent_products = find_recent_product_added('5');
 $recent_sales    = find_recent_sale_added('5')
?>

<?php 
$item_names = [];
$inventory_values = [];
$retail_values = [];
$potential_profits = [];


$sql = "SELECT name, buy_price, sale_price, quantity FROM products";
$result = $db->query($sql); 


if (!$result) {
    die("Error querying the database: " . $db->con->error);
}


while ($row = $db->fetch_assoc($result)) {
    $item_name = $row['name']; 
    $inventory_value = $row['buy_price'] * $row['quantity'];
    $total_retail_value = $row['sale_price'] * $row['quantity'];
    $potential_profit = $total_retail_value - $inventory_value;

 
    $item_names[] = $item_name;
    $inventory_values[] = $inventory_value;
    $retail_values[] = $total_retail_value;
    $potential_profits[] = $potential_profit;
}
?>

<?php include_once('layouts/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>
    <h1 class="invendash">Inventory Dashboard</h1>
</body>
</html>
<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>
  <div class="row">
    <a href="users.php" style="color:black;">
		<div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-secondary1">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_user['total']; ?> </h2>
          <p class="text-muted">Users</p>
        </div>
       </div>
    </div>
	</a>
	
	<a href="categorie.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_categorie['total']; ?> </h2>
          <p class="text-muted">Categories</p>
        </div>
       </div>
    </div>
	</a>
	
	<a href="product.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue2">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_product['total']; ?> </h2>
          <p class="text-muted">Products</p>
        </div>
       </div>
    </div>
	</a>
	
	<a href="sales.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-green">
          <i>&#8369;</i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php  echo $c_sale['total']; ?></h2>
          <p class="text-muted">Sales</p>
        </div>
       </div>
    </div>
	</a>
</div>
  
  <div class="row">
   <div class="col-md-4">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Highest Selling Products</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
          <thead>
           <tr>
             <th>Title</th>
             <th>Total Sold</th>
             <th>Total Quantity</th>
           <tr>
          </thead>
          <tbody>
            <?php foreach ($products_sold as  $product_sold): ?>
              <tr>
                <td><?php echo remove_junk(first_character($product_sold['name'])); ?></td>
                <td><?php echo (int)$product_sold['totalSold']; ?></td>
                <td><?php echo (int)$product_sold['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          <tbody>
         </table>
       </div>
     </div>
   </div>
   <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>LATEST SALES</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
       <thead>
         <tr>
           <th class="text-center" style="width: 50px;">#</th>
           <th>Product Name</th>
           <th>Date</th>
           <th>Total Sale</th>
         </tr>
       </thead>
       <tbody>
         <?php foreach ($recent_sales as  $recent_sale): ?>
         <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td>
            <a href="edit_sale.php?id=<?php echo (int)$recent_sale['id']; ?>">
             <?php echo remove_junk(first_character($recent_sale['name'])); ?>
           </a>
           </td>
           <td><?php echo remove_junk(ucfirst($recent_sale['date'])); ?></td>
           <td>$<?php echo remove_junk(first_character($recent_sale['price'])); ?></td>
        </tr>

       <?php endforeach; ?>
       </tbody>
     </table>
    </div>
   </div>
  </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Recently Added Products</span>
        </strong>
      </div>
      <div class="panel-body">

        <div class="list-group">
      <?php foreach ($recent_products as  $recent_product): ?>
            <a class="list-group-item clearfix" href="edit_product.php?id=<?php echo    (int)$recent_product['id'];?>">
                <h4 class="list-group-item-heading">
                 <?php if($recent_product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image'];?>" alt="" />
                <?php endif;?>
                <?php echo remove_junk(first_character($recent_product['name']));?>
                  <span class="label label-warning pull-right">
                  ₱<?php echo (int)$recent_product['sale_price']; ?>
                  </span>
                </h4>
                <span class="list-group-item-text pull-right">
                <?php echo remove_junk(first_character($recent_product['categorie'])); ?>
              </span>
          </a>
      <?php endforeach; ?>
    </div>
  </div>
 </div>
</div>
 </div>
  
    <div class="col-md-13">
      <div class="panel panel-default">
        <div class="panel-heading">
        <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Evaluation Report</span>           
        </strong>
        </div>
        <canvas id="inventoryChart" width="400" height="100"></canvas> 

<script>
document.addEventListener("DOMContentLoaded", function() {
    const labels = <?php echo json_encode($item_names); ?>;
    const inventoryValues = <?php echo json_encode($inventory_values); ?>;
    const retailValues = <?php echo json_encode($retail_values); ?>;
    const potentialProfits = <?php echo json_encode($potential_profits); ?>;

    new Chart(document.getElementById("inventoryChart"), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Inventory Value (₱)',
                    data: inventoryValues,
                    backgroundColor: 'yellow'
                },
                {
                    label: 'Total Retail Value (₱)',
                    data: retailValues,
                    backgroundColor: 'gold'
                },
                {
                    label: 'Potential Profit (₱)',
                    data: potentialProfits,
                    backgroundColor: 'brown'
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Inventory Value, Retail Value, and Potential Profit',
                fontSize: 12 
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        fontSize: 10, 
                        maxTicksLimit: 5 
                    }
                },
                x: {
                    ticks: {
                        fontSize: 10 
                    }
                }
            },
            legend: {
                position: 'bottom', 
                labels: {
                    fontSize: 10 
                }
            },
            responsive: true 
        }
    });
});
</script>
      </div>
    </div>
    <style>

@import url('https://fonts.cdnfonts.com/css/futura-display');
@import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap');

.invendash{
  font-family:"Alfa Slab One", serif;
}
</style>
<?php include_once('layouts/footer.php'); ?>
