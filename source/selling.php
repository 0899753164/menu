<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();
$db = $objDb->database;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Product model Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="/Project/CSS/Form_login.css"><!--navbar used!-->
  	<link rel="stylesheet" type="text/css" href="./CSS/form.css"><!--form used!-->
 	<script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
  	<script type="text/javascript" src="/Project/jquery/jquery.form.js"></script><!--no refresh form!-->

<!--no refresh page when submit!-->
<script type="text/javascript">
  $(document).ready(function() {
    $('#myForm').ajaxForm({
      target: '#showdata',
      success: function() {
        $('#showdata').fadeIn('slow');
      }
    });
  });
  </script>
<!--end-->
</head>
<body>
<!--Content!-->
<div class="main">
	<b><h3>ข้อมูลการขาย</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">ข้อมูลการขาย</h4></b>
		</div>
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">รหัสการขาย :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="sell_id" placeholder="รหัสการขาย">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ขาย :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="sell_date" placeholder="วันที่ขาย" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสลูกค้า :</label>
	    <div class="col-sm-10">
	      <select class="custom-select" id="input" style="font-family: Mitr" placeholder="รหัสลูกค้า">
	      	 <option value="1" selected="">เลือกรหัสลูกค้า</option>
		    <option value="1">เฟอร์นิเจอร์</option>
		    <option value="2">เครื่องดื่ม</option>
		    <option value="3">เครื่องประดับตกแต่ง</option>
  		</select>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสสินค้า :</label>
	    <div class="col-sm-10">
	      <select class="custom-select" id="input" style="font-family: Mitr">
	      	<option selected>เลือกรหัสสินค้า</option>
		    <option value="1">เฟอร์นิเจอร์</option>
		    <option value="2">เครื่องดื่ม</option>
		    <option value="3">เครื่องประดับตกแต่ง</option>
  		</select>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสการจัดส่ง :</label>
	    <div class="col-sm-10">
	      <select class="custom-select" id="input" style="font-family: Mitr">
	      	<option selected>เลือกรหัสการจัดส่ง</option>
		    <option value="1">เฟอร์นิเจอร์</option>
		    <option value="2">เครื่องดื่ม</option>
		    <option value="3">เครื่องประดับตกแต่ง</option>
  		</select>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ราคา :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="sell_price" placeholder="ราคา" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวน :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="sell_amount" placeholder="จำนวน" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ยอดรวม :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="sell_total" placeholder="ยอดรวม" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="sell_status" placeholder="สถานะ" required>
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="sellsubmit" value="" class="btn btn-primary btn-md">บันทึก</button></a>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
	  </div>
	    </div>
	</div>
</form>
<br>
<br>
<div id="showdata">
    <?include("../Project/database/insert.php");?>
  </div>
</div>

</body>
</html>
