<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$matr_id = $_GET['matr_id'];    //getting id from url

	$sql = 'SELECT * FROM rawmaterial WHERE matr_id=:matr_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':matr_id' => $matr_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

$sql = "SELECT * FROM manufacture";
$stmtmanufac = $db->prepare($sql);//prepare data after select//
$stmtmanufac->execute();  ///stmt = statement
$result = $stmtmanufac->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Raw material data</title>
	<link rel="stylesheet" type="text/css" href="/Project/CSS/form.css"><!--form used-->
<script type="text/javascript">   //no refresh page when submit
  $(document).ready(function() {
    $('#myForm').ajaxForm({
      target: '#showdata',
      success: function() {
        $('#showdata').fadeIn('slow');
      }
    });
  });
  </script>
</head>
<body>
<!--Content!-->
<div class="main">
	<b><h3>แก้ไขข้อมูลวัตถุดิบ</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลวัตถุดิบ</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="matr_id" placeholder="รหัสลูกค้า" value="<?php echo $select->matr_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ชื่อวัตถุดิบ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="matr_name" placeholder="ชื่อลูกค้า" value="<?php echo $select->matr_name; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่นำเข้า :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="matr_impdate" placeholder="วันที่นำเข้าวัตถุดิบ" value="<?php echo $select->matr_impdate; ?>" required>
	    </div>
	  </div>

		<div class="form-group row">
	    	<label for="" class="col-sm-2 col-form-label">ปริมาณ :</label>
	    	<div class="col-sm-10">
	      	<input type="number" class="form-control" id="input" name="matr_quantity" placeholder="ปริมาณ" value="<?php echo $select->matr_quantity; ?>" required>
	    </div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ราคาต่อหน่วย :</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="input" name="matr_price" placeholder="ราคาต่อหน่วย" value="<?php echo $select->matr_price; ?>">
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="rawupdate" value="" class="btn btn-primary btn-md">อัพเดท</button>
	     </input>
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button type="button" name="cancle" value="" class="btn btn-secondary btn-md" >ยกเลิก</button>
	  </div>
	    </div>
	</div>
</form>
	<div id="showdata">
  		<? include("../Project/source/edit.php");?>
  	</div>
</script>
</div>
</body>
</html>