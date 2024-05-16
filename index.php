<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Banana Cart</title>
</head>
<body>
<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header.php'); ?>

<img src="images/Banana Login.png" width="900" height="900" class="logo">
<div class="half"></div>
<div class="main">
        
		<input type="checkbox" id="chk" aria-hidden="true">
        
			<div class="signup">
      <form method="post" action="auth.php" class="clearfix">
      <img src="images/Banana Logo.png" width="100" height="100" class="logo2">
      <div class="box1">INVENTORY MANAGEMENT SYSTEM</div>
      <br><br>
      <h4 class="asd">Login</h4>
        <div class="form-group">
        </span><input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" name= "password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-warning" style="border-radius:0%">Login</button>
        <?php echo display_msg($msg); ?>
        </div>
    </form>
			</div>

<?php include_once('layouts/footer.php'); ?>

</body>
<style>

@import url('https://fonts.cdnfonts.com/css/futura-display');
@import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap');

  body{
    background-color: rgb(255,240,192);
    overflow: hidden;
  }
  .asd{
    font-family: "Alfa Slab One", serif;
    text-align: center;
    font-size: 30px;
  }
.half{
  z-index: -1;
  position:absolute;
  background-size: 400% 400%;
  height: 1000px;
  width: 1000px;
  left: 1000px;
  top: -50px;
  background: linear-gradient(-45deg, #FFCC73, #FFE49E, #FFCB44);
  background-size: 400% 400%;

}
.box1{
  background-color: rgb(255,240,192);
  height: 100px;
  text-align: center;
  font-family: 'Futura Display', sans-serif;
  font-style: normal;
  font-size: 20px;
  -webkit-text-fill-color: white; /* Will override color (regardless of order) */
  -webkit-text-stroke: 1px black;
  padding: 20px;
}
.logo{
  position:absolute;
  left: 0px;
  top: -50px;
}
.logo2{
  position: relative;
  float: right;

}

.main{
  border-radius: 25px; 
  top: 160px;
  right: 300px;
  position: absolute;
	width: 350px;
	height: 500px;
	background: red;
	overflow: hidden;
	background: linear-gradient(to bottom, #fff59d, #FAD545);
	box-shadow: 5px 20px 50px #000;
  border: 3px solid black;
  padding: 20px;
  text-align: center;
}
#chk{
	display: none;
}
.signup{
	position: relative;
	width:100%;
	height: 100%;
}
input{
	width: 50px;
	height: 35px;
	background: white;
	justify-content: center;
	display: flex;
	margin: 20px auto;
	padding: 30px;
	border: none;
	outline: none;
	border-radius: 5px;
}
button{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: #FAC700;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
.buttonn{
	width: 60%;
	height: 100%;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: #FAC700;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
button:hover{
	background: #FADA5E;
}
.login{
	height: 490px;
	background: #f5f4f4;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}


</style>
</html>