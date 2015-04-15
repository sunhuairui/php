<?php
require_once dirname(__FILE__) . '/PHPExcel.php';

function export_csv($data = '', $filename = '',$sheet = false) {
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 ->setLastModifiedBy("Maarten Balliauw")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");					 
	$filename = empty ( $filename ) ? date ( 'YmdHis' ) : $filename ; 
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
        
        /**以下是数据导出文件名乱码的解决 auth@changzhengfei start **/
        $ua = $_SERVER["HTTP_USER_AGENT"]; 
        $encoded_filename = urlencode($filename.'.xls');
        $encoded_filename = str_replace("+", "%20", $encoded_filename);
        header('Content-Type: application/octet-stream');
        if (preg_match("/MSIE/", $ua)) {  
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        } else if (preg_match("/Firefox/", $ua)) {  
            header('Content-Disposition: attachment; filename*="utf8\'\'' . $encoded_filename . '"');
        } else {  
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        }
        /**以下是数据导出文件名乱码的解决 auth@changzhengfei end **/
        
        //header('Content-Disposition: attachment;filename='.$filename.'.xls'); //old header
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	$Line = array(
	'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
	);
	if(!$sheet){
		foreach ( $data as $k=>$v ) {
		    $u=$k+1;
		    $s = count($v);
		    for($i=0;$i<$s;$i++){
		    	    $n = $Line[$i].$u;
		    	    $va = array_values($v);
		    		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue($n,$va[$i]);
		    }  
	  } 

		/*// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A4', 'Miscellaneous glyphs')
		            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		*/
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
	}else {
	  	$f=0;
	  	foreach ( $data as $t=>$u )
	  	 {
	  		foreach ( $u as $k=>$v )
	  		{
			    $u=$k+1;
			    $s = count($v);
			    for($i=0;$i<$s;$i++){
			    	    $n = $Line[$i].$u;
			    	    $va = array_values($v);
			    		$objPHPExcel->setActiveSheetIndex($f)
			            ->setCellValue($n,$va[$i]);
			            if($data[$t][$k][1]!=$data[$t][$k-1][1]&&$k!=0){
                                        $objPHPExcel->getActiveSheet()->getStyle($n)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                                        $objPHPExcel->getActiveSheet()->getStyle($n)->getFill()->getStartColor()->setARGB('FFFF00');
                                    }
			    } 
	  		} 
	  		
	  		
		/*// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A4', 'Miscellaneous glyphs')
		            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		*/
		// Rename worksheet
		$objPHPExcel->createSheet();$objPHPExcel->getSheet($f)->setTitle($t);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex($f);
	  	$f++;
	  	}
	  	$f=0;
	  }
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}

/**导出数据到excel文件并下载 有样式(标题头、边框、表头加粗、左右居中、垂直居中、表格高宽)
 * auth@changzhengfei
 * $fileName 文件名称（不带后缀）
 * $headArr  文件表头（一维数组）
 * $data     主体数据（二维数组）
 * at 2015/04/02
 */
function getExcel($fileName,$headArr,$data){
    error_reporting(E_ALL);
    header("content-Type: text/html; charset=utf-8");
    date_default_timezone_set('Asia/Shanghai');
    $objPHPExcel = new PHPExcel(); 
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
     //设置标题行 第一行
        $key = ord("A");
        $row_num=count($headArr);//总列数
        $k=$key + $row_num -1;//最后一列ASCII值
        $columRowA = chr($k);//最后一列字母值
        $rowEndKey=$columRowA.'1';//第一行最后一格的编号
        $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$rowEndKey);//合并单元格
        $objPHPExcel->getActiveSheet()->getColumnDimension(A)->setWidth(30);//设置表格宽度
        $objPHPExcel->setActiveSheetIndex(0) ->setCellValue(A1, $fileName); //赋值标题头
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);//设置表格高度
        $objPHPExcel->getActiveSheet()->getStyle($columRowA.'1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//第一行最后一格右边框
        $objPHPExcel->getActiveSheet()->getStyle(A1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//左右居中
        $objPHPExcel->getActiveSheet()->getStyle(A1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
        $objPHPExcel->getActiveSheet()->getStyle(A1)->getFont()->setBold(true);//字体加粗
         //设置表头 第二行
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'2', $v); //赋值表头
            //$objPHPExcel->getActiveSheet()->getColumnDimension(A)->setWidth(30);//设置表格宽度
            $objPHPExcel->getActiveSheet()->getColumnDimension()->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setWidth(30);//设置表格宽度
            $objPHPExcel->getActiveSheet()->getRowDimension($colum)->setRowHeight(20);//设置表格高度
            $objPHPExcel->getActiveSheet()->getStyle($colum.'2')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle($colum.'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
            $objPHPExcel->getActiveSheet()->getStyle($colum.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//左右居中
            $objPHPExcel->getActiveSheet()->getStyle($colum.'2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//上边框
            $objPHPExcel->getActiveSheet()->getStyle($colum.'2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//下边框
            $objPHPExcel->getActiveSheet()->getStyle($colum.'2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//右边框
            $objPHPExcel->getActiveSheet()->getStyle($colum.'2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//左边框
            $key += 1;
        }
        //主体数据 从第三行开始
        $column = 3;
        $objActSheet = $objPHPExcel->getActiveSheet();
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j.$column, $value);//赋值主体数据
                $objPHPExcel->getActiveSheet()->getStyle($colum.'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中
                $objPHPExcel->getActiveSheet()->getStyle($j.$column)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//左右居中
                $objPHPExcel->getActiveSheet()->getStyle($j.$column)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//上边框
                $objPHPExcel->getActiveSheet()->getStyle($j.$column)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//下边框
                $objPHPExcel->getActiveSheet()->getStyle($j.$column)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//右边框
                $objPHPExcel->getActiveSheet()->getStyle($j.$column)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);//左边框
                $span++;
            }
            $column++;
        }
 
    //重命名表
    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    
    $objPHPExcel->setActiveSheetIndex(0);
    if($fileName){
        $fileName = iconv("utf-8", "gbk", $fileName);
    }else{
        $fileName = 'ExportData_' . date ( 'YmdHis' );
    }
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/octet-stream"); 
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$fileName.'.xls"');
    header('Cache-Control: max-age=0'); 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit; 
}

