<?php
  $page_title = 'Import Items';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $fileName = $_FILES["file"]["tmp_name"];

    if(!$fileName){
      $session->msg('d',' Sorry failed to added!');
      redirect('product.php', false);
    }

    if($_FILES["file"]["size"] > 0) {
      $file = fopen($fileName,"r");

      fgetcsv($file);

      while(($column = fgetcsv($file,10000, ",")) !== FALSE) {
        $date    = make_date();
        $query  = "INSERT INTO products (";
        $query .=" name,quantity,low_stock_quantity, buy_price,sale_price,categorie_id,media_id,date";
        $query .=") VALUES (";
        $query .=" '{$column[0]}', '{$column[1]}', '{$column[2]}', '{$column[3]}', '{$column[4]}', '{$column[5]}', '{$column[6]}', '{$date}'";
        $query .=")";
        $query .=" ON DUPLICATE KEY UPDATE name='{$column[0]}'";

        $res = $db->query($query);
        if(!isset($query)){
          $session->msg('d',' Sorry failed to added!');
          redirect('add_product.php', false);
        }
      }
          if(isset($res)){
          $session->msg('s',"Product added ");
          redirect('product.php', false);
        } else {
          $session->msg('d',' Sorry failed to added!');
          redirect('add_product.php', false);
        }
     
      fclose($file);
    }
  }
    
?>
<?php include_once('layouts/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
  .main {
    border: 1px solid #ddd;
    background-color: #fff;  
    display: grid;
    grid-template-rows: 50px 240px;
    width: 500px;
    border-radius: 3px;
  }

  input[type=file]{
    display: none;
  }

  .top-header {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #3498DB;
    background-color: #f5f5f5;
  }

  .heading {
    font-weight:  700;
    font-size: 16px;
    margin: 5px;
  }

  .margin {
    margin-left: 15px;
  }

  .bot-header {
    display: flex;
    margin: 15px 15px;
    justify-content: center;
  }

  #label1 {
    border: 3px dashed gray;
    padding: 60px 30px;
    cursor: pointer;
  }

  .btn-import {
    margin-top: 10px;
    padding: 9px 15px;
    text-transform: uppercase;
    border: none;
    background-color: #ed5153;
    color: white;
    border-radius: 3px;
    transition: all 0.25s;
  }

  .btn-import:hover {
    box-shadow: 2px 3px 8px rgba(0, 0, 0, 0.25);
  }
  .btn-cancel {
    margin-left: 10px;
    padding: 11px 15px;
    box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.25);
    transition: all 0.25s;
    border-radius: 3px;
    text-transform: uppercase;
    border: none;
  }
  .btn-cancel:hover {
    text-decoration: none;
    box-shadow: 2px 3px 8px rgba(0, 0, 0, 0.25);
  }

</style>
<body>
  <div class="main">
    <div class="top-header">
      <span class="glyphicon glyphicon-th margin"></span>
      <span class="heading" >Import Items with CSV file</span>
    </div>
    <div class="bot-header">
      <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" enctype="multipart/form-data">
        <label id="label1" for="import">Upload CSV File</label>
        <input type="file" name="file" id="import" accept=".csv" onchange="updateLabel()">
        <br>
        <button type="submit" name="import" class="btn-import">Import</button>
        <a href="product.php" class="btn-cancel">Cancel</a>
      </form>
    </div>
  </div>

  <script>
    function updateLabel() {
      const label = document.getElementById('label1');
      const input = document.getElementById('import');
      if(input.files.length > 0) {
        label.innerText = input.files[0].name;
      } else {
        label.innerText = 'Upload CSV File';
      }
    }
  </script>
  
</body>
</html>
<?php include_once('layouts/footer.php'); ?>

