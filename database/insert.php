<?php
//session_start();
require_once("../database/Db.php");
$objDb = new Db();
$db = $objDb->database;

//insert data to customer table
if (isset($_POST['submitcustomer']))
{
	//get value from form
	$form = $_POST;
	$cus_id = $form[ 'cus_id' ];
	$cus_name = $form[ 'cus_name' ];
	$cus_surname = $form[ 'cus_surname' ];
	$gen_radio = $form[ 'gen_radio' ];
	$cus_mail = $form[ 'cus_mail' ];
	$cus_phone = $form[ 'cus_phone' ];
	$cus_add = $form[ 'cus_add' ];

	if (empty($cus_name) || empty($cus_surname) || empty($gen_radio) || empty($cus_mail) || empty($cus_phone) || empty($cus_add))
	{
		echo "กรุณากรอกข้อมูลให้ครบทุกช่อง";
	}
				///check duplicate name //
		$sql = "SELECT cus_name AND cus_surname FROM customer 
		WHERE cus_name = :cus_name AND cus_surname = :cus_surname";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":cus_name", $cus_name, PDO::PARAM_STR);
			$stmt->bindParam(":cus_surname", $cus_surname, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ชื่อ $cus_name.$cus_surname มีอยู่แล้ว. กรุณาตรวจสอบอีกครั้ง')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO customer (cus_id, cus_name, cus_surname, cus_gender, cus_mail, cus_phone, cus_add) 
				VALUES (:cus_id, :cus_name, :cus_surname, :gen_radio, :cus_mail, :cus_phone, :cus_add)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':cus_id'=>$cus_id, ':cus_name'=>$cus_name, ':cus_surname'=>$cus_surname, 
				':gen_radio'=>$gen_radio, ':cus_mail'=>$cus_mail, ':cus_phone'=>$cus_phone, ':cus_add'=>$cus_add));

		if($result)
		{
			?> <script>alert('<?php echo $cus_name ?> ถูกเพิ่มเรียบร้อยแล้ว')
						window.location="../index.php?page=customer";
			</script>
			<?php
		}
		else
		{
			
			?> <script>alert('<?php echo $cus_name ?> เพิ่มข้อมูลไม่สำเร็จ')
						window.location="../index.php?page=addnewCus";
			</script>
			<?php
		}
	}
}
//END insert customer//

//insert data to material table//
if (isset($_POST['submitmatr']))
{
	//get value from form
	$form = $_POST;                         ///2
	$matr_id = $form[ 'matr_id' ];
	$matr_name = $form[ 'matr_name' ];
	$matr_impdate = $form[ 'matr_impdate' ];
	$matr_quantity = $form[ 'matr_quantity' ];
	$matr_price = $form[ 'matr_price' ];
	$rawmaterial_fid = $form[ 'rawmaterial_fid' ];

	if (empty($matr_name) || empty($matr_impdate) || empty($matr_quantity) || empty($matr_price))
	{

		echo "กรุณากรอกข้อมูลให้ครบทุกช่อง";
	}
					///check duplicate name //
		$sql = "SELECT matr_impdate FROM rawmaterial WHERE matr_impdate = :matr_impdate";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(":matr_impdate", $matr_impdate, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0)
		{
			?> <script>alert('<?php echo $matr_impdate ?> วัน/เดือน/ปี/นี้มีอยู่แล้ว.กรุณาตรวจสอบอีกครั้ง')
						window.location="../index.php?page=addnewrowMaterial";
			</script>
			<?php
		}
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO rawmaterial (matr_id, matr_name, matr_impdate, matr_quantity, matr_price, rawmaterial_fid) 
				VALUES (:matr_id, :matr_name, :matr_impdate, :matr_quantity, :matr_price, :rawmaterial_fid)"; //1

		//prepare value
		$stmt = $db->prepare($sql);

		$result = $stmt->execute(array(':matr_id'=>$matr_id, ':matr_name'=>$matr_name, ':matr_impdate'=>$matr_impdate, 
				':matr_quantity'=>$matr_quantity, ':matr_price'=>$matr_price, ':rawmaterial_fid'=>$rawmaterial_fid)); //5
		if($result)
		{
			?> <script>alert('<?php echo $matr_name ?>.ข้อมูลสินค้าถูกเพิ่มเรียบร้อยแล้ว.')
						window.location="../index.php?page=material";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('<?php echo $matr_name ?>.เพิ่มข้อมูลไม่สำเร็จ.')
						window.location="../index.php?page=material";
			</script>
			<?php
		}
	}
}
//END insert customer//

//insert data to inventory table//
/*if (isset($_POST['submitinventr']))
{
	//get value from form
	$form = $_POST;
	$invent_id = $form[ 'invent_id' ];
	$inven_date = $form[ 'inven_date' ];
	$product_amount = $form[ 'product_amount' ];
	$product_price = $form[ 'product_price' ];
	$invent_status = $form[ 'invent_status' ];
		//check availability//
	if (empty($inven_date) || empty($product_amount) || empty($product_price) || empty($invent_status))
	{
		echo "กรุณากรอกข้อมูลให้ครบทุกช่อง";
	}
					///check duplicate name //
		$sql = "SELECT * FROM inventory WHERE invent_id = :invent_id";

		$stmt = $db->prepare($sql);
		$stmt->bindParam(":invent_id", $invent_id, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0)
		{
		    echo "<script>alert('ชื่อนี้มีอยู่แล้ว.')</script>";
		    return false;
		}
	else
	{
			//Column name=invent_id, invent_date, invent_amount, invent_price, invent_status
		$sql = "INSERT INTO inventory (invent_id, invent_date, invent_amount, invent_price, invent_status) 
						VALUES (:invent_id, :inven_date, :product_amount, :product_price, :invent_status)"; //1

		//prepare value
		$stmt = $db->prepare($sql);

			//excecute array value//
		$result = $stmt->execute(array(':invent_id'=>$invent_id, ':inven_date'=>$inven_date,
				 ':product_amount'=>$product_amount, ':product_price'=>$product_price, ':invent_status'=>$invent_status)); //5
					//check result//
		if($result)
		{
			echo "<script>alert('เพิ่มข้อมูลสำเร็จ.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=inventory'>" ;
		}
		else
		{
			echo "เพิ่มข้อมูลไม่สำเร็จ";
		}
	}
}*/
//END insert inventory//

//insert data to product table//
if (isset($_POST['submitproduct']))
{
	//get value from form
	$form = $_POST;
	$product_id = $form[ 'product_id' ];
	$product_name = $form[ 'product_name' ];
	$product_pricepd = $form[ 'product_pricepd' ];
	$product_amountpd = $form[ 'product_amountpd' ];
	$product_status = $form[ 'product_status' ];
	$producttype_fid = $form[ 'producttype_fid' ];

	if (empty($product_name) || empty($product_pricepd) || empty($product_amountpd) || empty($product_status))
	{

		echo "กรุณากรอกข้อมูลให้ครบทุกช่อง";
	}
					///check duplicate name //
		$sql = "SELECT * FROM product WHERE product_name = :product_name";

		$stmt = $db->prepare($sql);
		$stmt->bindParam(":product_name", $product_name, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0)
		{
			?> <script>alert('<?php echo $product_name ?>.มีอยู่แล้ว.กรุณาตรวจสอบอีกครั้ง')
						window.location="../index.php?page=addnewProduct";
			</script>
			<?php
		}
	else
	{
		$sql = "INSERT INTO product (product_id, product_name, product_price, product_amount, 
		product_status, producttype_fid) 
		VALUES (:product_id, :product_name, :product_pricepd, :product_amountpd, 
		:product_status, :producttype_fid)"; //1

		//prepare value
		$stmt = $db->prepare($sql);
		//excecute array value//
		$result = $stmt->execute(array(':product_id'=>$product_id, ':product_name'=>$product_name,
				 ':product_pricepd'=>$product_pricepd, ':product_amountpd'=>$product_amountpd, 
				 ':product_status'=>$product_status, ':producttype_fid'=>$producttype_fid)); //5
					//check result//
		if($result)
		{
			?> <script>alert('<?php echo $product_name ?> เพิ่มข้อมูลสำเร็จ.')
						window.location="../index.php?page=product";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('<?php echo $product_name ?>.เพิ่มข้อมูลไม่สำเร็จ.กรุณาตรวจสอบอีกครั้ง')
						window.location="../index.php?page=addnewProduct";
			</script>
			<?php
		}
	}
}
//END insert product//

//insert productModel//
if (isset($_POST['pmodelsubmit']))
{
	//get value from form pmodel_img
	$form = $_POST;
	$pmodel_id = $form[ 'pmodel_id' ];
	$pmodel_name = $form[ 'pmodel_name' ];
	$pmodel_desc = $form[ 'pmodel_desc' ];

	$pmodel_img=$_FILES['pmodel_img'];
    $filename = $_FILES['pmodel_img']['name'];
    $filetemp = $_FILES['pmodel_img']['tmp_name'];
    $filesize = $_FILES['pmodel_img']['size'];
    $filebasename = basename($_FILES['pmodel_img']['name']);
    $dir="../imgUpload/";	//set upload folder path
  //  $finaldir=$dir.$filebasename;

	if(!file_exists($dir)) //check file not exist in your upload folder path
	{
	$errorMsg="ไฟล์ภาพนี้มีอยู่แล้ว"; //error message file not exists your upload folder path
	}
	else
	{
		$finaldir=$dir.$filebasename;
	    move_uploaded_file($filetemp,$finaldir); //move upload file temperory directory to your upload folder
	}
	if (empty($pmodel_name) || empty($pmodel_desc))
	{

		echo "กรุณากรอกข้อมูลให้ครบทุกช่อง";
	}
					///check duplicate name //
		$sql = "SELECT * FROM productmodel WHERE pmodel_name = :pmodel_name";

		$stmt = $db->prepare($sql);
		$stmt->bindParam(":pmodel_name", $pmodel_name, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0)
		{
		   ?> <script>alert('<?php echo $pmodel_name ?>.ชื่อนี้มีอยู่แล้ว.กรุณาตรวจสอบอีกครั้ง')
						window.location="../index.php?page=addnewproductModel";
			</script>
			<?php
		}
	else
	{
		$sql = "INSERT INTO productmodel (pmodel_id, pmodel_name, pmodel_desc, pmodel_img) 
		VALUES (:pmodel_id, :pmodel_name, :pmodel_desc, :pmodel_img)"; //1

		//prepare value
		$stmt = $db->prepare($sql);

			//excecute array value//
		$result = $stmt->execute(array(':pmodel_id'=>$pmodel_id, ':pmodel_name'=>$pmodel_name,
				 ':pmodel_desc'=>$pmodel_desc, ':pmodel_img'=>$filebasename)); //5
					//check result//
		if($result)
		{
			 ?> <script>alert('<?php echo $pmodel_name ?>เพิ่มข้อมูลสำเร็จ')
						window.location="../index.php?page=productmodel";
			</script>
			<?php
		}
		else
		{
			 ?> <script>alert('<?php echo $pmodel_name ?>เพิ่มข้อมูลไม่สำเร็จ')
						window.location="../index.php?page=addnewproductModel";
			</script>
			<?php
		}
	}
}
//END//

//insert staff//
if (isset($_POST['staffsubmit']))
{
	//get value from form
	$form = $_POST;
	$staff_id = $form[ 'staff_id' ];
	$staff_name = $form[ 'staff_name' ];
	$staff_surname = $form[ 'staff_surname' ];
	$staff_passportid = $form[ 'staff_passportid' ];
	$staff_add = $form[ 'staff_add' ];
	$staff_stwd = $form[ 'staff_stwd' ];
	$staff_phone = $form[ 'staff_phone' ];

	if (empty($staff_name) || empty($staff_surname) || empty($staff_passportid) || empty($staff_add) || empty($staff_stwd) || empty($staff_phone))
	{
		echo "<script>alert('กรุณากรอกข้อมูลให้ครบทุกช่อง.')</script>";
	}
				///check duplicate name //
		$sql = "SELECT * FROM staff WHERE staff_name = :staff_name AND staff_surname = :staff_surname";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":staff_name", $staff_name, PDO::PARAM_STR);
			$stmt->bindParam(":staff_surname", $staff_surname, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
			 ?> <script>alert('<?php echo $staff_name.$staff_surname ?>ชื่อนี้มีอยู่แล้ว')
						window.location="../index.php?page=addnewStaff";
			</script>
			<?php
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO staff (staff_id, staff_name, staff_surname, staff_passportid, staff_add, 
		staff_stwd, staff_phone) 
		VALUES (:staff_id, :staff_name, :staff_surname, :staff_passportid, :staff_add, :staff_stwd, 
		:staff_phone)"; //1
		$stmt = $db->prepare($sql);//prepare sql//
		$result = $stmt->execute(array(':staff_id'=>$staff_id, ':staff_name'=>$staff_name, 
			':staff_surname'=>$staff_surname, ':staff_passportid'=>$staff_passportid, ':staff_add'=>$staff_add,
				 ':staff_stwd'=>$staff_stwd, ':staff_phone'=>$staff_phone));
		if($result)
		{
			?> <script>alert('<?php echo $staff_name.$staff_surname ?>เพิ่มข้อมูลสำเร็จ')
						window.location="../index.php?page=staff";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('<?php echo $staff_name.$staff_surname ?>เพิ่มข้อมูลไม่สำเร็จ')
						window.location="../index.php?page=addnewStaff";
			</script>
			<?php
		}
	}
}
//END//

//insert into sell table
if (isset($_POST['sellsubmit']))
{
	//get value from form
	$form = $_POST;
	$sell_id = $form[ 'sell_id' ];  //Pk
	$sell_date = $form[ 'sell_date' ];
	$cus_fid = $form[ 'cus_fid' ];  //Fk
	$pd_fid = $form[ 'pd_fid' ];	//Fk
	$sell_price = $form[ 'sell_price' ];
	$sell_amount = $form[ 'sell_amount' ];
	$sell_total = $form[ 'sell_total' ];
	$sell_status = $form[ 'sell_status' ];
	$count = count($pd_fid); //count array
	$duplicate = true; //set defult
	$morethan = true;  //set defult
	//////////////////////////check duplicate manufac_rowfid///////////////////////////////////////
	for ($i=0; $i < $count; $i++)
	{
		for ($j=0; $j < $count; $j++)
		{
			if ($i != $j)
			{
				if($pd_fid[$i] == $pd_fid[$j])
				{
					$duplicate = false;
				}
			}
		}
	}
	/////////////if not duplicate get $duplicate variable for check Qty product table/////////
	if($duplicate)
	{
		for ($i=0; $i < $count; $i++)///////count $manufac_rawfid[i]
		{			//select Qty column from rawmaterial where matr_id = Fk//
			$sql = "SELECT product_qty FROM product WHERE product_id=:pd_fid";
			$stmt = $db->prepare($sql);
			$result = $stmt->execute([':pd_fid'=> $pd_fid[$i]]);
			while($row = $stmt->fetch(PDO::FETCH_OBJ))
			{	echo $row->product_qty;
				echo $sell_amount[$i];
				echo $morethan;
				if($sell_amount[$i] > $row->product_qty)//check get amount[i]
				{
					echo $morethan;
					$morethan = false;
				}
			}
		}
		if ($morethan)
		{
			//insert data to sell table//
		$sql = "INSERT INTO sell (sell_id, sell_date, cus_fid, sell_status) 
		VALUES (:sell_id, :sell_date, :cus_fid, :sell_status)";
		$stmt = $db->prepare($sql);//prepare sql//
		$result = $stmt->execute(array(':sell_id'=>$sell_id, ':sell_date'=>$sell_date, 
			':cus_fid'=>$cus_fid, ':sell_status'=>$sell_status));

		if(!empty($pd_fid))
		{
			$sell_id = $db->lastInsertId(); //get last id from sell table on sell_id column
			for($i = 0; $i < count($pd_fid); $i++)
			{
				if(!empty($pd_fid[$i]))
				{
					$pfid = $pd_fid[$i];
					$p_price = $sell_price[$i];
					$s_amount = $sell_amount[$i];
					$s_total = $sell_total[$i];

					////////////////////////////////////insert desc sell sametime//////////////////////////
					$sql = "INSERT INTO desc_sell (sell_fid, product_fid, sell_price, sell_amount, sell_total) VALUES (:sell_fid, :product_fid, :sell_price, :sell_amount, :sell_total)";
					$stmt = $db->prepare($sql);
					$result = $stmt->execute(array(':sell_fid'=>$sell_id, ':product_fid'=>$pfid,
					 ':sell_price'=>$p_price, ':sell_amount'=>$s_amount, ':sell_total'=>$s_total));
					/////////////END/////////////////
					////Update  Product row on column product_qty after sold out///////
					$sql = "UPDATE product SET 	product_qty = product_qty - $s_amount 
					WHERE product_id='$pfid'";
					$stmt = $db->prepare($sql);
					$result = $stmt->execute();
					/////////////////////////////////////////////END//////////////////
				}
            }
        }
		if($result)
		{
			?> <script>alert('<?php echo $cus_fid ?> เพิ่มข้อมูลสำเร็จ.')
						window.location="../index.php?page=sell";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('<?php echo $cus_fid ?> เพิ่มข้อมูลไม่สำเร็จ.')
						window.location="../index.php?page=addnewrowSell";
			</script>
			<?php
		}
	}
	else
		{
			?> 
			<script>alert('สินค้าไม่พอ! กรุณาเช็คจำนวนสินค้าก่อน.')
			window.location="../index.php?page=addnewrowSell";
			</script>
			<?php
		}
	}
	else
	{
		?> <script>alert('เลือสินค้าซ้ำ!.กรุณาตรวจสอบอีกครั้ง') 
		window.location="../index.php?page=addnewrowSell";
		</script>
		<?php
	}
	//////////Check Qty product befor sold out/////////
	//select จำนวนสินค้า from ตารางสินค้า where รหัสสินค้า = ค่าไอดีที่สั่งซื้อ
/*	$sql = "SELECT product_qty FROM product WHERE product_id='$pd_fid'";
	 	$stmt = $db->prepare($sql);
		$result = $stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_OBJ))
		{
			if($sell_amount > $row->product_qty)
			{
				?> <script>alert('สินค้าไม่พอ! กรุณาเช็คจำนวนสินค้าก่อน.')
								window.location="../index.php?page=addnewrowSell";
					</script>
				<?php
				return false;
			}
		}
		///////////////////////////////////END//////////////////////////////////////
	if (empty($sell_date) || empty($sell_price) || empty($sell_amount) || empty($sell_total) || empty($sell_status))
	{
		echo "<script>alert('กรุณากรอกข้อมูลให้ครบทุกช่อง.')</script>";
	}
					///check duplicate name //
	$sql = "SELECT * FROM sell WHERE sell_id = :sell_id";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(":sell_id", $sell_id, PDO::PARAM_INT);
	$stmt->execute();
	if ($stmt->rowCount() > 0)
	{
		?> <script>alert('<?php echo $sell_id ?>ข้อมูลนี้มีอยู่แล้ว')
						window.location="../index.php?page=addnewrowSell";
			</script>
			<?php
	}
	else
	{
		//insert data to sell table//
		$sql = "INSERT INTO sell (sell_id, sell_date, cus_fid, sell_status) 
		VALUES (:sell_id, :sell_date, :cus_fid, :sell_status)";
		$stmt = $db->prepare($sql);//prepare sql//
		$result = $stmt->execute(array(':sell_id'=>$sell_id, ':sell_date'=>$sell_date, 
			':cus_fid'=>$cus_fid, ':sell_status'=>$sell_status));

		if(!empty($pd_fid))
		{
			$sell_id = $db->lastInsertId(); //get last id from sell table on sell_id column
			for($i = 0; $i < count($pd_fid); $i++)
			{
				if(!empty($pd_fid[$i]))
				{
					$pfid = $pd_fid[$i];
					$p_price = $sell_price[$i];
					$s_amount = $sell_amount[$i];
					$s_total = $sell_total[$i];

					////////////////////////////////////insert desc sell sametime//////////////////////////
					$sql = "INSERT INTO desc_sell (sell_fid, product_fid, sell_price, sell_amount, sell_total) VALUES (:sell_fid, :product_fid, :sell_price, :sell_amount, :sell_total)";
					$stmt = $db->prepare($sql);
					$result = $stmt->execute(array(':sell_fid'=>$sell_id, ':product_fid'=>$pfid,
					 ':sell_price'=>$p_price, ':sell_amount'=>$s_amount, ':sell_total'=>$s_total));
					/////////////END/////////////////
					////Update  Product row on column product_qty after sold out///////
					$sql = "UPDATE product SET 	product_qty = product_qty - $s_amount 
					WHERE product_id='$pfid'";
					$stmt = $db->prepare($sql);
					$result = $stmt->execute();
					/////////////////////////////////////////////END//////////////////
				}
            }
        }
		if($result)
		{
			?> <script>alert('<?php echo $cus_fid ?> เพิ่มข้อมูลสำเร็จ.')
						window.location="../index.php?page=sell";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('<?php echo $cus_fid ?> เพิ่มข้อมูลไม่สำเร็จ.')
						window.location="../index.php?page=addnewrowSell";
			</script>
			<?php
		}
	}*/
}
//END//
///////////////insert desc sell///////////////////////////
if (isset($_POST['submitdescsell']))
{
	//get value from form
	$form = $_POST;
	$descsell_id = $form[ 'descsell_id' ];
	$product_fid = $form[ 'product_fid' ];
	$sell_fid = $form[ 'sell_fid' ];
				///check duplicate name //
		$sql = "SELECT * FROM desc_sell WHERE descsell_id = :descsell_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":descsell_id", $descsell_id, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        ?> <script>alert('<?php echo $descsell_id ?> ชื่อนี้มีอยู่แล้ว.')
						window.location="../index.php?page=addnewdescsell";
			</script>
			<?php
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO desc_sell (descsell_id, product_fid, sell_fid) 
				VALUES (:descsell_id, :product_fid, :sell_fid)"; //1
		$stmt = $db->prepare($sql);//prepare value//
		$result = $stmt->execute(array(':descsell_id'=>$descsell_id, ':product_fid'=>$product_fid,
		 ':sell_fid'=>$sell_fid));

		if($result)
		{
			?> <script>alert('ข้อมูลถูกเพิ่มเรียบร้อยแล้ว.')
						window.location="../index.php?page=desc_sell";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('เพิ่มข้อมูลไม่สำเร็จ.')
						window.location="../index.php?page=addnewdescsell";
			</script>
			<?php
		}
	}
}
////////////////////END//////////////////////////////////

//insert into delivery table
if (isset($_POST['deliversubmit']))
{
	//get value from form
	$form = $_POST;
	$deliver_id = $form[ 'deliver_id' ];
	$deliver_date = $form[ 'deliver_date' ];
	$deliver_by = $form[ 'deliver_by' ];
	$deliver_sellid = $form[ 'deliver_sellid' ];
	$deliver_stafffid = $form[ 'deliver_stafffid' ];

	if (empty($deliver_date) || empty($deliver_by))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT * FROM delivery WHERE deliver_sellid = :deliver_sellid";
	    $stmt = $db->prepare($sql);
		$stmt->bindParam(":deliver_sellid", $deliver_sellid, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	       ?> <script>alert('<?php echo $deliver_sellid ?> .รหัสนี้มีอยู่แล้ว.')
						window.location="../index.php?page=addnewDelivery";
			</script>
			<?php
	    }
	else
	{
		//insert data to delivery table//
		$sql = "INSERT INTO delivery (deliver_id, deliver_date, deliver_by, 
		deliver_sellid, deliver_stafffid) 
				VALUES (:deliver_id, :deliver_date, :deliver_by, 
				:deliver_sellid, :deliver_stafffid)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':deliver_id'=>$deliver_id, ':deliver_date'=>$deliver_date, 
			':deliver_by'=>$deliver_by, 
			':deliver_sellid'=>$deliver_sellid, ':deliver_stafffid'=>$deliver_stafffid));

		////////////////////////////////////insert delivery Desc sametime//////////////////////////
		$deliver_id = $db->lastInsertId(); //get last id from sell table on sell_id column
		$sql = "INSERT INTO desc_deliver (descdeliver_deliverid, descdeliver_staffid) 
		VALUES (:descdeliver_deliverid, :descdeliver_staffid)";
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':descdeliver_deliverid'=>$deliver_id, 
			':descdeliver_staffid'=>$deliver_stafffid));
		///////////////////////////////////////END//////////////////////////////////////////////

		if($result)
		{
			?> <script>alert('<?php echo $deliver_id ?> เพิ่มข้อมูลสำเร็จ.')
						window.location="../index.php?page=delivery";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('<?php echo $deliver_sellid ?> .เพิ่มข้อมูลไม่สำเร็จ.')
						window.location="../index.php?page=addnewDelivery";
			</script>
			<?php
		}
	}
}
//END
//insert into product defective
if (isset($_POST['defectsubmit']))
{
	//get value from form
	$form = $_POST;
	$defective_id = $form[ 'defective_id' ];
	$defective_amount = $form[ 'defective_amount' ];
	$defective_total = $form[ 'defective_total' ];
	$pddefective_fid = $form[ 'pddefective_fid' ];

	if (empty($defective_amount) || empty($defective_total))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT * FROM defective WHERE pddefective_fid = :pddefective_fid";
	    $stmt = $db->prepare($sql);
		$stmt->bindParam(":pddefective_fid", $pddefective_fid, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	       ?> <script>alert('<?php echo $pddefective_fid ?> .ชื่อนี้มีอยู่แล้ว.')
						window.location="../index.php?page=addnewDefective";
			</script>
			<?php
	    }
	else
	{
		//insert data to delfective table//
		$sql = "INSERT INTO defective (defective_id, defective_amount, defective_total, pddefective_fid) 
				VALUES (:defective_id, :defective_amount, :defective_total, :pddefective_fid)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':defective_id'=>$defective_id, ':defective_amount'=>$defective_amount,
		 ':defective_total'=>$defective_total, ':pddefective_fid'=>$pddefective_fid));
		if($result)
		{
			?> <script>alert('<?php echo $defective_id ?> เพิ่มข้อมูลสำเร็จ.')
						window.location="../index.php?page=defective";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('<?php echo $pddefective_fid ?> .เพิ่มข้อมูลไม่สำเร็จ.')
						window.location="../index.php?page=addnewDefective";
			</script>
			<?php
		}
	}
}
//////////////////END//////////////////
///////////////////////////////////////insert into manufacture///////////////////////////////////////////////
if (isset($_POST['manufacsubmit']))
{
	//get value from form
	$form = $_POST;
	$manufac_id = $form[ 'manufac_id' ]; //Pk
	$manufac_date = $form[ 'manufac_date' ];
	$manufac_ordered = $form[ 'manufac_ordered' ];
	$manufac_lotnum = $form[ 'manufac_lotnum' ];
	$manufacstaff_fid = $form[ 'manufacstaff_fid' ];//Fk
	$manufac_status = $form[ 'manufac_status' ];
	$manufac_pfid = $form[ 'manufac_pfid' ];	//Fk
	$manufac_rowfid = $form[ 'manufac_rowfid' ]; //Fk
	$manufac_QtyrMtr = $form[ 'manufac_QtyrMtr' ];
	$count = count($manufac_rowfid); //count array
	$duplicate = true; //set defult
	$morethan = true;  //set defult
	//////////////////////////check duplicate manufac_rowfid///////////////////////////////////////
	for ($i=0; $i < $count; $i++)
	{
		for ($j=0; $j < $count; $j++)
		{
			if ($i != $j)
			{
				if($manufac_rowfid[$i] == $manufac_rowfid[$j])
				{
					$duplicate = false;
				}
			}
		}
	}
	/////////////if not duplicate get $duplicate variable for check Qty rawmaterial table/////////
	if($duplicate)
	{
		for ($i=0; $i < $count; $i++)///////count $manufac_rawfid[i]
		{			//select Qty column from rawmaterial where matr_id = Fk//
			$sql = "SELECT matr_quantity FROM rawmaterial WHERE matr_id=:manufac_rowfid";
			$stmt = $db->prepare($sql);
			$result = $stmt->execute([':manufac_rowfid'=> $manufac_rowfid[$i]]);
			while($row = $stmt->fetch(PDO::FETCH_OBJ))
			{	echo $row->matr_quantity;
				echo $manufac_QtyrMtr[$i];
				echo $morethan;
				if($manufac_QtyrMtr[$i] > $row->matr_quantity)//check get amount[i]
				{
					echo $morethan;
					$morethan = false;
				}
			}
		}
		if ($morethan)
		{
						//insert data to cutmer table//
			$sql = "INSERT INTO manufacture (manufac_id, manufac_date, manufac_ordered, manufac_lotnum, manufacstaff_fid, manufac_status, manufac_pfid) 
					VALUES (:manufac_id, :manufac_date, :manufac_ordered, :manufac_lotnum, :manufacstaff_fid, :manufac_status, :manufac_pfid)"; //1

			$stmt = $db->prepare($sql);//prepare sql//
			$result = $stmt->execute(array(':manufac_id'=>$manufac_id, ':manufac_date'=>$manufac_date, 
				':manufac_ordered'=>$manufac_ordered, ':manufac_lotnum'=>$manufac_lotnum, 
				':manufacstaff_fid'=>$manufacstaff_fid, ':manufac_status'=>$manufac_status, 
				':manufac_pfid'=>$manufac_pfid));

			if(!empty($manufac_rowfid)) //check empty Dinamic for vaiable $manufac_rowfid
			{
				$manufac_id  = $db->lastInsertId(); //get last id from manufac table on manufac_id column
				for($i = 0; $i < count($manufac_rowfid); $i++)
				{
					if(!empty($manufac_rowfid[$i]))
					{
						$rowfid = $manufac_rowfid[$i];
						$Qtymtr = $manufac_QtyrMtr[$i];
						////////////////////////////////////insert desc manufacture sametime////////
						$sql = "INSERT INTO desc_manufac (descmnf_fid, descmtr_fid, manufac_QtyrMtr) 
						VALUES (:descmnf_fid, :descmtr_fid, :manufac_QtyrMtr)";
						$stmt = $db->prepare($sql);
						$result = $stmt->execute(array(':descmnf_fid'=>$manufac_id,
						 ':descmtr_fid'=>$rowfid, ':manufac_QtyrMtr'=>$Qtymtr));
						/////////Update  rowmaterial row on column matr_quantity after generate///////
						$sql = "UPDATE rawmaterial SET matr_quantity = matr_quantity - $Qtymtr
						 WHERE matr_id='$rowfid'";
						$stmt = $db->prepare($sql);
						$result = $stmt->execute();
						/////////////////////////////////////////////END//////////////////////////////
					}
	            }
	        }
	        /////////Update product table on productqty column after generated manufacture//////////
			$sql = "UPDATE product SET product_qty = product_qty + $manufac_ordered 
			WHERE product_id='$manufac_pfid'";
			$stmt = $db->prepare($sql);
			$result = $stmt->execute();
			/////////////////////////////////////////////END/////////////////////////////////
			if($result)
			{
				?> <script>alert('<?php echo $manufac_pfid?> ข้อมูลถูกเพิ่มเรียบร้อยแล้ว.')
							window.location="../index.php?page=manufacture";
				</script>
				<?php
			}
			else
			{
				?> <script>alert('<?php echo $$manufac_pfid?>เพิ่มข้อมูลไม่สำเร็จ.')
							window.location="../index.php?page=addnewrowManufac";
				</script>
				<?php
			}
		}
		else
		{
			?> 
			<script>alert('วัตถุดิบไม่พอ! กรุณาเช็คจำนวนวัตถุดิบก่อน.')
			window.location="../index.php?page=addnewrowManufac";
			</script>
			<?php
		}
	}
	else
	{
		?> <script>alert('เลือกวัถุดิบซ้ำ!.กรุณาตรวจสอบอีกครั้ง') 
		window.location="../index.php?page=addnewrowManufac";
		</script>
		<?php
	}
			///////////////////////////////////END//////////////////////////////////////

	/*if (empty($manufac_date) || empty($manufac_lotnum))
	{
		echo "please enter the fullfeild!";
	}
	/*			///check duplicate name //
		$sql = "SELECT * FROM manufacture WHERE manufac_lotnum = :manufac_lotnum";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":manufac_lotnum", $manufac_lotnum, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ข้อมูลนี้มีอยู่แล้ว.')</script>";
	        return false;
	    }*/
	/*else
	{

		//insert data to cutmer table//
		$sql = "INSERT INTO manufacture (manufac_id, manufac_date, manufac_ordered, manufac_lotnum, manufacstaff_fid, manufac_status, manufac_pfid) 
				VALUES (:manufac_id, :manufac_date, :manufac_ordered, :manufac_lotnum, :manufacstaff_fid, :manufac_status, :manufac_pfid)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':manufac_id'=>$manufac_id, ':manufac_date'=>$manufac_date, 
			':manufac_ordered'=>$manufac_ordered, ':manufac_lotnum'=>$manufac_lotnum,
			 ':manufacstaff_fid'=>$manufacstaff_fid, ':manufac_status'=>$manufac_status, 
			 ':manufac_pfid'=>$manufac_pfid));

		if(!empty($manufac_rowfid))
		{
			$manufac_id  = $db->lastInsertId(); //get last id from manufac table on manufac_id column
			for($i = 0; $i < count($manufac_rowfid); $i++)
			{
				if(!empty($manufac_rowfid[$i]))
				{
					$rowfid = $manufac_rowfid[$i];
					$Qtymtr = $manufac_QtyrMtr[$i];
					////////////////////////////////////insert desc manufacture sametime////////
					$sql = "INSERT INTO desc_manufac (descmnf_fid, descmtr_fid, manufac_QtyrMtr) 
					VALUES (:descmnf_fid, :descmtr_fid, :manufac_QtyrMtr)";
					$stmt = $db->prepare($sql);
					$result = $stmt->execute(array(':descmnf_fid'=>$manufac_id,
					 ':descmtr_fid'=>$rowfid, ':manufac_QtyrMtr'=>$Qtymtr));
					/////////Update  rowmaterial row on column matr_quantity after generate///////
					$sql = "UPDATE rawmaterial SET matr_quantity = matr_quantity - $Qtymtr
					 WHERE matr_id='$rowfid'";
					$stmt = $db->prepare($sql);
					$result = $stmt->execute();
					/////////////////////////////////////////////END//////////////////////////////
				}
            }
        }
        /////////Update product table on productqty column after generated manufacture//////////
		$sql = "UPDATE product SET product_qty = product_qty + $manufac_ordered 
		WHERE product_id='$manufac_pfid'";
		$stmt = $db->prepare($sql);
		$result = $stmt->execute();
		/////////////////////////////////////////////END/////////////////////////////////
		if($result)
		{
			?> <script>alert('<?php echo $$manufac_pfid?> ข้อมูลถูกเพิ่มเรียบร้อยแล้ว.')
						window.location="../index.php?page=manufacture";
			</script>
			<?php
		}
		else
		{
			?> <script>alert('<?php echo $$manufac_pfid?>เพิ่มข้อมูลไม่สำเร็จ.')
						window.location="../index.php?page=addnewrowManufac";
			</script>
			<?php
		}
	}*/
}
//END
//insert into payroll staff//
if (isset($_POST['salarysubmit']))
{
	//get value from form
	$form = $_POST;
	$salary_id = $form[ 'salary_id' ];
	$salary_paydate = $form[ 'salary_paydate' ];
	$salary_payroll = $form[ 'salary_payroll' ];
	$salary_status = $form[ 'salary_status' ];
	$salary_ovtWdr = $form[ 'salary_ovtWdr' ];
	$salary_receiveAm = $form[ 'salary_receiveAm' ];
	$salary_total = $form[ 'salary_total' ];
	$staffsalary_fid = $form[ 'staffsalary_fid' ];

	if (empty($salary_paydate) || empty($salary_payroll) || empty($salary_status) || empty($salary_ovtWdr) 
		|| empty($salary_receiveAm) || empty($salary_total))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT * FROM payrollstaff WHERE salary_id = :salary_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":salary_id", $salary_id, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ข้อมูลนี้มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO payrollstaff (salary_id, salary_paydate, salary_payroll, salary_status, salary_ovtWdr, salary_receiveAm, salary_total, staffsalary_fid) 
				VALUES (:salary_id, :salary_paydate, :salary_payroll, :salary_status, :salary_ovtWdr, :salary_receiveAm, :salary_total, :staffsalary_fid)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':salary_id'=>$salary_id, ':salary_paydate'=>$salary_paydate, 
			':salary_payroll'=>$salary_payroll, ':salary_status'=>$salary_status, 
			':salary_ovtWdr'=>$salary_ovtWdr, ':salary_receiveAm'=>$salary_receiveAm,
			 ':salary_total'=>$salary_total, ':staffsalary_fid'=>$staffsalary_fid));

		if($result)
		{
			?> <script>alert('Payroll Data added successfully.')
						window.location="../index.php?page=salary";
			</script>
			<?php
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//
//Insert into work///
if (isset($_POST['submitwork']))
{
	//get value from form
	$form = $_POST;
	$work_id = $form[ 'work_id' ];
	$work_date = $form[ 'work_date' ];
	$work_dayoff = $form[ 'work_dayoff' ];
	$work_time = $form[ 'work_time' ];
	$staff_fid = $form[ 'staff_fid' ];
	if (empty($work_date) || empty($work_dayoff) || empty($work_time))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT * FROM work WHERE work_id = :work_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":work_id", $work_id, PDO::PARAM_INT);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ข้อมูลนี้มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO work (work_id, work_date, work_dayoff, work_time, staff_fid) 
				VALUES (:work_id, :work_date, :work_dayoff, :work_time, :staff_fid)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':work_id'=>$work_id, ':work_date'=>$work_date, 
			':work_dayoff'=>$work_dayoff, ':work_time'=>$work_time, ':staff_fid'=>$staff_fid));
		if($result)
		{
			?> <script>alert('Working Data added successfully.')
						window.location="../index.php?page=work";
			</script>
			<?php
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//
//Insert into account//
if (isset($_POST['submitaccount']))
{
	//get value from form
	$form = $_POST;
	$account_id = $form[ 'account_id' ];
	$account_date = $form[ 'account_date' ];
	$account_year = $form[ 'account_year' ];
	$account_desc = $form[ 'account_desc' ];
	$account_itemtype = $form[ 'account_itemtype' ];
	$account_total = $form[ 'account_total' ];

	if (empty($account_date) || empty($account_year) || empty($account_desc) || empty($account_itemtype) 
		|| empty($account_total))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT account_id FROM account WHERE account_id = :account_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":account_id", $account_id, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ชื่อ $account_id มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO account (account_id, account_date, account_year, account_desc, account_itemtype, account_total) 
				VALUES (:account_id, :account_date, :account_year, :account_desc, :account_itemtype, :account_total)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':account_id'=>$account_id, ':account_date'=>$account_date, ':account_year'=>$account_year, 
				':account_desc'=>$account_desc, ':account_itemtype'=>$account_itemtype, ':account_total'=>$account_total));

		if($result)
		{
			?> <script>alert('account Data added successfully.')
						window.location="../index.php?page=finance";
			</script>
			<?php
		}
		else
		{
			echo "not found insert";
		}
	}
}
//END//
//Insert into maintenance machine//
if (isset($_POST['submitmaintenance']))
{
	//get value from form
	$form = $_POST;
	$maintn_id = $form[ 'maintn_id' ];
	$maintn_title = $form[ 'maintn_title' ];
	$maintn_date = $form[ 'maintn_date' ];
	$maintn_desc = $form[ 'maintn_desc' ];
	$maintn_name = $form[ 'maintn_name' ];
	$maintn_phone = $form[ 'maintn_phone' ];
	$maintnstaff_fid = $form[ 'maintnstaff_fid' ];

	if (empty($maintn_date) || empty($maintn_desc) || empty($maintn_name) || empty($maintn_phone))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		$sql = "SELECT maintn_id FROM maintenance WHERE maintn_id = :maintn_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":maintn_id", $maintn_id, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ชื่อ $maintn_id มีอยู่แล้ว.')</script>";
	        return false;
	    }
	else
	{
		//insert data to cutmer table//
		$sql = "INSERT INTO maintenance (maintn_id, maintn_title, maintn_date, maintn_desc, maintn_name, maintn_phone, maintnstaff_fid) 
				VALUES (:maintn_id, :maintn_title, :maintn_date, :maintn_desc, :maintn_name, :maintn_phone, :maintnstaff_fid)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':maintn_id'=>$maintn_id, ':maintn_title'=>$maintn_title, 
			':maintn_date'=>$maintn_date, ':maintn_desc'=>$maintn_desc, ':maintn_name'=>$maintn_name, 
			':maintn_phone'=>$maintn_phone, ':maintnstaff_fid'=>$maintnstaff_fid));
		if($result)
		{
			?> <script>alert('<?php echo $maintn_id ?> เพิ่มข้อมูลสำเร็จ.')
						window.location="../index.php?page=repairmachine";
			</script>
			<?php
		}
		else
		{

			echo "เพิ่มข้อมูลไม่สำเร็จ";
		}
	}
}

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////machine history////////////////////////////////////////
if (isset($_POST['maintn_History']))
{
	//get value from form
	$form = $_POST;
	$mch_id = $form[ 'mch_id' ];
	$maintn_fid = $form[ 'maintn_fid' ];
	$mch_date = $form[ 'mch_date' ];
	$mch_desc = $form[ 'mch_desc' ];
	$mch_title = $form[ 'mch_title' ];
	if (empty($mch_date) || empty($mch_desc) || empty($mch_title))
	{
		echo "please enter the fullfeild!";
	}
				///check duplicate name //
		/*$sql = "SELECT maintn_id FROM maintenance WHERE maintn_id = :maintn_id";
	    $stmt = $db->prepare($sql);
			$stmt->bindParam(":maintn_id", $maintn_id, PDO::PARAM_STR);
	    $stmt->execute();
	    if ($stmt->rowCount() > 0)
	    {
	        echo "<script>alert('ชื่อ $maintn_id มีอยู่แล้ว.')</script>";
	        return false;
	    }*/
	else
	{
		//$maintn_id = $db->lastInsertId(); //get last id from sell table on sell_id column
		//insert data to cutmer table//
		$sql = "INSERT INTO macchine_history (mch_id, maintn_fid, mch_date, mch_desc, mch_title) 
				VALUES (:mch_id, :maintn_fid, :mch_date, :mch_desc, :mch_title)"; //1

		//prepare value//
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':mch_id'=>$mch_id,':maintn_fid'=>$maintn_fid, ':mch_date'=>$mch_date, 
			':mch_desc'=>$mch_desc, ':mch_title'=>$mch_title));
		if($result)
		{
			?> <script>alert('เพิ่มข้อมูลสำเร็จ.')
						window.location="../index.php?page=repairmachine";
			</script>
			<?php
		}
		else
		{

			echo "เพิ่มข้อมูลไม่สำเร็จ";
		}
	}
}
//END//
//insertdata into product type//
if (isset($_POST['submitproductType']))
{

	//get value from form
	$form = $_POST;                         ///2
	$producttype_id = $form[ 'producttype_id' ];
	$producttype_name = $form[ 'producttype_name' ];

	echo $producttype_id;
	echo $producttype_name;

	if (empty($producttype_name))
	{

		echo "please enter the full feild!";
	}
		///check duplicate name //
		$sql = "SELECT * FROM producttype WHERE producttype_name = :producttype_name";

		$stmt = $db->prepare($sql);
		$stmt->bindParam(":producttype_name", $producttype_name, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0)
		{
		    echo "<script>alert('the already exite!.')</script>";
		    return false;

		}
	else
	{
			//Column name=invent_id, invent_date, invent_amount, invent_price, invent_status
		$sql = "INSERT INTO producttype (producttype_id, producttype_name) VALUES (:producttype_id, :producttype_name)"; //1

		//prepare value
		$stmt = $db->prepare($sql);

		//excecute array value//
		$result = $stmt->execute(array(':producttype_id'=>$producttype_id, ':producttype_name'=>$producttype_name)); //5
			//check result//
		if($result)
		{
			echo "<script>alert('Product type Data added successfully.')</script>";
			echo "<meta http-equiv='refresh' content='2; url = index.php?page=customer'>" ;
		}
		else
		{
			echo "not found insert product type";
		}
	}
}
//END insert product type//
//insert into product defective//

//END//
?>