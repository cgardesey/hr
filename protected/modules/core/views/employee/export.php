<?php
		
		date_default_timezone_set('Asia/Kolkata');
		require_once 'PHPExcel/Classes/PHPExcel.php';
		include 'protected/modules/core/views/employee/reports.php';
		
		$filename = 'Employees Report'; //your file name
		$objPHPExcel = new PHPExcel();
		/*********************Add column headings START**********************/
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A1', 'Employee Code')
					->setCellValue('B1', 'Employee Name')
					->setCellValue('C1', 'Email')
					->setCellValue('D1', 'Mobile Number');
		$con = mysqli_connect('localhost','root','','hrms_basic');
		/*********************Add column headings END**********************/
		$departmentid = $model->departmentid;
		$divisionid = $model->divisionid;
		$jobcategoryid = $model->jobcategoryid;


		if (isset($departmentid)) {
			$select_statement = "select * from employee LEFT JOIN department ON employee.departmentid = department.departmentid";
		}
		if (isset($divisionid)) {
			$select_statement = "select * FROM  
			( select * FROM employee as T1 LEFT JOIN department as T2 ON T1.departmentid=T2.departmentid) as T12 
			LEFT JOIN department as T3 ON T12.divisionid = T3.divisionid";
		}
		if (isset($jobcategoryid)) {
			$select_statement = "select * FROM
			(select * FROM  
			( select * FROM employee as T1 LEFT JOIN department as T2 ON T1.departmentid=T2.departmentid) as T12 
			LEFT JOIN department as T3 ON T12.divisionid=T3.divisionid )as T34 
			LEFT JOIN jobcategory as T4 ON T34.jobcategoryid = T4.jobcategoryid";
		}

		$query = mysql_query($con, $select_statement);
		$i = 2;
		while ($row = mysql_fetch_array($query)) {
			$code = $['employee_code'];
			$name = $['employee_lastname'].' '.$['employee_middlename'].' '.$['employee_lastname'];
			$email = $['employee_email'];
			$phone = $['employee_phone'];

			$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$i, $code)
					->setCellValue('B'.$i, $name)
					->setCellValue('C'.$i, $email)
					->setCellValue('D'.$i, $phone);
					$i = $i + 1;
			# code...
		}
		// You can add this block in loop to put all ur entries.Remember to change cell index i.e "A2,A3,A4" dynamically 
		/*********************Add data entries START**********************/
		// $objPHPExcel->setActiveSheetIndex(0) 
		// 			->setCellValue('A2', 'Dinesh Belakare')
		// 			->setCellValue('B2', 'dineshluck1@gmail.com')
		// 			->setCellValue('C2', '07-08-2015')
		// 			->setCellValue('D2', '5')
		// 			->setCellValue('E2', 'No');
		/*********************Add data entries END**********************/
		
		/*********************Autoresize column width depending upon contents START**********************/
        foreach(range('A','D') as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		/*********************Autoresize column width depending upon contents END***********************/
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true); //Make heading font bold
		
		/*********************Add color to heading START**********************/
		$objPHPExcel->getActiveSheet()
					->getStyle('A1:D1')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('99ff99');
		/*********************Add color to heading END***********************/
		
		$objPHPExcel->getActiveSheet()->setTitle('userReport'); //give title to sheet
		$objPHPExcel->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;Filename=$filename.xls");
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
?>