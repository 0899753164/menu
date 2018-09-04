<?php
//session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

$sql = "SELECT * FROM customer";
$search ='';
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$sql .= " WHERE cus_name LIKE '%".$search."%' OR cus_surname LIKE '%".$search."%'";
}

$stmt = $db->prepare($sql);


		///bind variable from customer table  to variable in php

$stmt->bindParam(":cus_id", $cus_id, PDO::PARAM_INT);
$stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
$stmt->bindParam(":cus_surname", $cus_surname, PDO::PARAM_STR);
$stmt->bindParam(":gen_radio", $gen_radio, PDO::PARAM_STR);
$stmt->bindParam(":cus_mail", $cus_mail, PDO::PARAM_STR);
$stmt->bindParam(":cus_phone", $cus_phone, PDO::PARAM_STR);
$stmt->bindParam(":cus_add", $cus_add, PDO::PARAM_STR);

		//execute statatement
$stmt->execute();  ///stmt = statement

$result = $stmt->execute(array(':cus_id'=>$cus_id, 
	':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
	':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail,
	':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add)); //5

?>
<!DOCTYPE html>
<html>
<head>
    <title>show data customer</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
  	<!--sidebar & navbar!-->
	<link rel="stylesheet" type="text/css" href="/Project/Menu/Menu.css">
 	<script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery.form.js"></script>

</head>
  <style>
  	#tbhead {
  		background-color: #2C394F;
  		color: #ffffff;
  		text-align: center;
  		font-weight: normal;
  	}
  	#del {
  		color: red;
  	}
  	h3 {
	color: #2C394F;
	}
	tbody{
		background-color: #ffffff;
	}
	/*border-radius*/
	.table-rounded thead th:first-child {
    border-radius: 15px 0 0 0;
	}
	.table-rounded thead th:last-child {
	    border-radius: 0 15px 0 0;
	}
	.table-rounded tbody td {
	    border: none;
	   /* border-top: solid 1px #957030;*/
	   /* background-color: #EED592;*/
	}
	.table-rounded tbody tr:last-child td:first-child {
	    border-radius: 0 0 0 15px;
	}
	.table-rounded tbody tr:last-child td:last-child {
	    border-radius: 0 0 15px 0;
	}
  </style>
  <body>
  	<div class="main">
  		<br>
  		<br>
  		<b><h3>ข้อมูลลูกค้า</h3></b>
  		<br>
  		<br>
<div class="row">
	<div class="col-8">
		<form class="form-inline" action="../Project/source/cus_list.php" method="get" >
		    <input class="form-control" type="text" name="search" value="<?php echo $search ?>" placeholder="ค้นหาด้วยรหัสลูกค้า" aria-label="Search">&nbsp;
		    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">ค้นหา</button>
  		</form>
	</div>
	<div class="col-sm-4" align="right">
		<div class="btn-group">
			<a href="index.php?page=addnewCus"><button class="btn btn-success" type="submit" name="button" value="" class="btn btn-primary btn-md">เพิ่มลูกค้าใหม่
			</button></a>
	  	</div>
	</div>
</div>
  <p></p>
  	<p></p>
    <div class="table-responsive">
    <table class="table table-hover table-white table-rounded">
      <thead>
        <tr id="tbhead">
          <th>รหัสลูกค้า</th>
          <th>ชื่อลูกค้า</th>
          <th>นามสกุล</th>
          <th>อายุ</th>
          <th>อีเมล์</th>
          <th>เบอร์โทร</th>
          <th>ที่อยู่</th>
          <th>จัดการข้อมูล</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_OBJ)){ ?>
        <tr>
          <td><?php echo $row->cus_id ?></td>
          <td><?php echo $row->cus_name ?></td>
          <td><?php echo $row->cus_surname ?></td>
          <td><?php echo $row->cus_gender ?></td>
          <td><?php echo $row->cus_mail ?></td>
          <td><?php echo $row->cus_phone ?></td>
          <td><?php echo $row->cus_add ?></td>
          <td> <a href="" style="text-decoration:none">view</a> |
              <a href="index.php?page=cuseditForm&cus_id=<?= $row->cus_id; ?>" style="text-decoration:none">edit</a> |
              <a href=" style="text-decoration:none" id="del" onclick="if(!confirm('กรุณายืนยันการลบข้อมูล')) { return false; }">delete</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
</div>
  </body>
</html>
