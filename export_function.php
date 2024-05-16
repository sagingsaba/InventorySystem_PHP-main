<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);

 if(isset($_POST["Export"])){

  // Fetch records from database 
  $query = $db->query("SELECT * FROM products ORDER BY id ASC"); 

    if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "products-data_" . date('Y-m-d') . ".csv"; 

    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 

    // Set column headers 
    $fields = array('Name', 'Quantity', 'Low stock quantity', 'Buying price', 'Selling price', 'Category ID', 'Media ID'); 
    fputcsv($f, $fields, $delimiter); 

    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){ 
        $lineData = array($row['name'], $row['quantity'], $row['low_stock_quantity'], $row['buy_price'], $row['sale_price'], $row['categorie_id'], $row['media_id'] ?? 0); 
        fputcsv($f, $lineData, $delimiter); 
    } 

    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
  }
} 
exit;
// <!-- // Fetch records from database 
//     $query = $db->query("SELECT * FROM products ORDER BY id ASC");

//     header('Content-Type: text/csv; charset=utf-8');  
//     header('Content-Disposition: attachment; filename=data.csv');  
//     $output = fopen("php://output", "w");  
//     fputcsv($output, array('id', 'name', 'quantity', 'low_stock_quantity', 'buy_price', 'sale_price', 'categorie_id', 'media_id', 'date'));  
//     $query = "SELECT * from products ORDER BY id DESC";  
//     $result = mysqli_query($con, $query);  
//     while($row = mysqli_fetch_assoc($result))  
//     {  
//          fputcsv($output, $row);  
//     }  
//     fclose($output);  
// }  -->