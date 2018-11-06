<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$invent_id = $_GET['invent_id'];    //getting id from url

	$sql = 'SELECT * FROM inventory WHERE invent_id=:invent_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':invent_id' => $invent_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit inventory data</title>
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
	<b><h3>แก้ไขสินค้าในคลัง</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post" target="blank">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลสินค้าในคลัง</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="invent_id" placeholder="" value="<?php echo $select->invent_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่นำเข้า :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="inven_date" placeholder="" value="<?php echo $select->inven_date; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวนสินค้า :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="product_amount" placeholder="" value="<?php echo $select->invent_amount; ?>" required>
	    </div>
	  </div>

		<div class="form-group row">
	    	<label for="" class="col-sm-2 col-form-label">ราคาต่อหน่วย :</label>
	    	<div class="col-sm-10">
	      	<input type="text" class="form-control" id="input" name="product_price" placeholder="" value="<?php echo $select->invent_price; ?>" required>
	    </div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="invent_status" placeholder="" value="<?php echo $select->	invent_status; ?>">
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<button type="submit" name="inventupdate" value="" class="btn btn-primary btn-md">อัพเดท</button>
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