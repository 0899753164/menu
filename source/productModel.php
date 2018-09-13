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
	<b><h3>ข้อมูลแบบผลิตภัณฑ์</h3></b>
	<form id="myForm" class="" name="blog post" action="../Project/database/insert.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">ข้อมูลแบบผลิตภัณฑ์</h4></b>
		</div>
	  <div class="form-group row">
	  	<label for="" class="col-sm-2 col-form-label">รหัสแบบผลิตภัณฑ์ :</label>
	  	<div class="col-sm-10">
	  		<input type="text" class="form-control" id="input" name="invent_id" placeholder="รหัสแบบผลิตภัณฑ์">
	  	</div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อผลิตภัณฑ์ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="inven_date" placeholder="ชื่อผลิตภัณฑ์" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ประเภทผลิตภัณฑ์ :</label>
	    <div class="col-sm-10">
	      <select class="custom-select" id="input">
	      	<option selected>เลือกประเภทสินค้า</option>
		    <option value="1">เฟอร์นิเจอร์</option>
		    <option value="2">เครื่องดื่ม</option>
		    <option value="3">เครื่องประดับตกแต่ง</option>
  		</select>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รูปภาพ :</label>
	    <div class="col-sm-10">
	      <div class="custom-file">
			  <input type="file" class="custom-file-input" id="input">
			  <label class="custom-file-label" for="customFile" id="input">เลือกไฟล์</label>
			</div>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รายละเอียด :</label>
	    <div class="col-sm-10">
	       <textarea type="text" class="form-control" rows="6" name="cus_add" placeholder="รายละเอียด" required></textarea>
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group"><a href="index.php?page=button"><button type="submit" name="button" value="" class="btn btn-primary btn-md">บันทึก</button></a>
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
