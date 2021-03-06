<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
?>
<?php
require_once("../Project/database/Db.php");   ///connect database
$objDb = new Db();							//ให้ตัวแปร $objDb เรียกใช้ฟังก์ชั่น Db()
$db = $objDb->database;

$sell_id = $_GET['sell_id'];    //getting id from url

	$sql = 'SELECT * FROM sell WHERE sell_id=:sell_id';    //เรียกข้อมูลที่ต้องการแก้ไขมา 1 แถว
		$stmt = $db->prepare($sql);   //เตรียมคำสั่ง SQL
		$stmt->execute([':sell_id' => $sell_id]);
		$select = $stmt->fetch(PDO::FETCH_OBJ);
$sql = "SELECT * FROM customer";
$stmt = $db->prepare($sql);
$stmt->execute();  ///stmt = statement
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Selling</title>
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
	<b><h3>แก้ไขข้อมูลการขาย</h3></b>
	<form id="myForm" class="" action="./source/edit.php" method="post">
		 <div class="form-group row">
			<b><h4 id="fh4">แก้ไขข้อมูลการขาย</h4></b>
		</div>
	  <div class="form-group row">
	  	<div class="col-sm-10">
	  		<input type="hidden" class="form-control" id="input" name="sell_id" placeholder="" value="<?php echo $select->sell_id; ?>">
	  	</div>
	  </div>
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">วันที่ขาย :</label>
	    <div class="col-sm-10">
	      <input type="date" class="form-control" id="input" name="sell_date" placeholder="" value="<?php echo $select->sell_date; ?>" required>
	    </div>
	  </div>

	  	 				<!--foreign key product type-->
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">รหัสลูกค้า :</label>
	    <div class="col-sm-10">
	      <select class="form-control" id="input" name="cus_fid" value=' ' style="font-family: Mitr" id="myForm">
	      	<option value="">เลือกรหัสลูกค้า</option>
	    <?php foreach($result as $rows ) {?>
	      	<option required value="<?php echo $rows['cus_id']; ?>" <?php if ($result == $rows['cus_id']) { echo "selected='selected'"; } ?>>
	      		<?php echo $rows['cus_id'].'.'.$rows['cus_name'] ?>
	      	</option>
	    <?php } ?>
  		</select>
	    </div>
	  </div>
	  <!--END foreign key product type-->

	  <!--Auto multiply-->
	  <script type="text/javascript">
	  	$(function () 
	  	{
  			$("#price, #Qty").keyup(function () 
  			{
    			$("#total").val(+$("#price").val() * +$("#Qty").val());
  			});
		});
	  </script>
	  			<!--END Auto multiply-->

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ราคา :</label>
	    <div class="col-sm-10">
	      <input type="number" id="price" class="form-control" id="input" name="sell_price" placeholder="ตัวเลขเท่านั้น" value="<?php echo $select->sell_price; ?>" required>
	    </div>
	  </div>

	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">จำนวน :</label>
	    <div class="col-sm-10">
	      <input type="number" id="Qty" class="form-control" id="input" name="sell_amount" placeholder="ตัวเลขเท่านั้น" value="<?php echo $select->sell_amount; ?>" required>
	    </div>
	  </div>
	  
	  <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">ยอดรวม :</label>
	    <div class="col-sm-10">
	      <input type="number" id="total" readonly="" class="form-control" id="input" name="sell_total" placeholder="ตัวเลขเท่านั้น" value="<?php echo $select->sell_total; ?>">
	    </div>
	  </div>

	   <div class="form-group row">
	    <label for="" class="col-sm-2 col-form-label">สถานะ :</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="input" name="sell_status" placeholder="สถานะ" value="<?php echo $select->sell_status; ?>">
	    </div>
	  </div>

	 <div class="form-group col" align="right">
	   <div class="col-sm-3">
	     <div class="btn-group">
	     	<a href="index.php?page=button"><button type="submit" name="sellupdate" value="" class="btn btn-primary btn-md">อัพเดท</button></a>
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