<?php
		
		date_default_timezone_set('Asia/Kolkata');
		require_once 'PHPExcel/Classes/PHPExcel.php';
		session_start();
		$filename = 'userReport'; //your file name
		$objPHPExcel = new PHPExcel();
		if($_POST)
		{

		}
		
		$param_array = $_POST;
		$reportid = @$param_array['reportfor'];
		$departmentid =  @$param_array['departmentid'];
		$divisionid = @$param_array['divisionid'];
		$jobcategoryid = @$param_array['jobcategoryid'];
		$designationid = @$param_array['designationid'];
		//echo $departmentid.$divisionid.$jobcategoryid.$designationid.$reportid;
		
//echo $param_array;
		// for($k = 0; $k<count($param_array); $k++) {
  
	 //    if ($param_array[$k] > 0) {
	 //    		$mycount++;
		//     	// if ($k == 1) {
		//     	// 	$departmentid =  $param_array[$k];
		//     	// 	$mycount++;
		//     	// }
		//     	// else if ($k == 2) {
		//     	// 	$divisionid = $param_array[$k];
		//     	// 	$mycount++;
		//     	// }
		//     	// else if ($k == 3) {
		//     	// 	$jobcategoryid = $param_array[$k];
		//     	// 	$mycount++;
		//     	// }
		//     	// else if ($k == 4) {
		//     	// 	$designationid = $param_array[$k];
		//     	// 	$mycount++;
		//     	// }
		//     	echo $mycount. "Cyril";
		    	
	 //    	}
	 //    	//echo $param_array[$k]. "Cyril";
	    	
	    
		// }
		//echo $mycount. "Cyril";

		/*********************Add column headings START**********************/
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A1', 'Employee Code')
					->setCellValue('B1', 'Employee Name')
					->setCellValue('C1', 'Email')
					->setCellValue('D1', 'Mobile Number');
		$con = mysqli_connect('localhost','root','','hrms_basic');
		/*********************Add column headings END**********************/
		
		// You can add this block in loop to put all ur entries.Remember to change cell index i.e "A2,A3,A4" dynamically 
		/*********************Add data entries START**********************/

		$select_statement = "";
		if (isset($designationid) && $designationid > 0) {
			$select_statement = "SELECT * from employee WHERE departmentid = ".$departmentid." AND divisionid = ".$divisionid." AND jobcategoryid = ".$jobcategoryid." AND designationid = ".$designationid; 	
		}
		else if (isset($jobcategoryid) && $jobcategoryid > 0) {
			$select_statement = "SELECT * from employee WHERE departmentid = ".$departmentid." AND divisionid = ".$divisionid." AND jobcategoryid = ".$jobcategoryid; 
		}
		else if (isset($divisionid) && $divisionid > 0) {
			$select_statement = "SELECT * from employee WHERE departmentid = ".$departmentid." AND divisionid = ".$divisionid; 
		}
		else if (isset($departmentid) && $departmentid > 0) {
			$select_statement = "SELECT * from employee WHERE departmentid = ".$departmentid; 

		}

		echo $select_statement;
		
		if ($select_statement != "") {
			$_SESSION['query'] = $select_statement;
		}
			
		

		
		$i = 2;
		$query = mysqli_query($con, $_SESSION['query']);
		while ($row = @mysqli_fetch_array($query)) {
			$code = @$row['employee_code'];
			$name = @$row['employee_firstname'].' '.$row['employee_middlename'].' '.$row['employee_lastname'];
			$email = @$row['employee_email'];
			$phone = @$row['employee_mobile'];

			$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$i, $code)
					->setCellValue('B'.$i, $name)
					->setCellValue('C'.$i, $email)
					->setCellValue('D'.$i, $phone);
					$i = $i + 1;
			# code...
					//echo "string";
		}
		$time = date('Y-m-d H:i:s',time());
		$i =  $i + 2;
		$objPHPExcel->setActiveSheetIndex(0) 
					 ->setCellValue('A'.$i, "Generated on")
					->setCellValue('B'.$i, $time)
					->setCellValue('D'.$i, "Prep Eez Tech Limited");
		/*********************Add data entries END**********************/
		
		/*********************Autoresize column width depending upon contents START**********************/
        foreach(range('A','E') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		/*********************Autoresize column width depending upon contents END***********************/
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true); //Make heading font bold
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':'.'E'.$i)->getFont()->setBold(true); 
		
		/*********************Add color to heading START**********************/
		$objPHPExcel->getActiveSheet()
					->getStyle('A1:E1')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('99ff99');
		/*********************Add color to heading END***********************/
		$objPHPExcel->getActiveSheet()
					->getStyle('A'.$i.':'.'E'.$i)
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('99ff99');
		
		$objPHPExcel->getActiveSheet()->setTitle('userReport'); //give title to sheet
		$objPHPExcel->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;Filename=$filename.xls");
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
	unset($_POST);
		exit;
	// }
	// else{
	// 	echo "string";
	// }
?>