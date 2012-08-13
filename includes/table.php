<?php
	
function createTable($tableData, $options){
	#echo "<pre>";
	#print_r($tableData);
	#echo "</pre>";
	
	if(empty($tableData['row'])){
		$tableData['row'][0]['empty'] = "No data has been saved";
	}
	
	$colCount = count($tableData['row'][0]) + 2;
	$headerColCount = count($tableData['header']);
	$colspan = $colCount - $headerColCount; 
	
	$html = "<table class='data'><thead><tr>";
	foreach($tableData['header'] as $head){
		$html .= "<th colspan='$colspan'> $head </th>";
	}
	$html .= "</tr></thead><tbody>";

	foreach ($tableData['row'] as $key=>$value){
      if( isset($tableData['id'])){
         $html .= "<tr id='" . $tableData['id'][$key] ."'>";
      }else{
         $html .= "<tr>";
      }
      
		foreach($value as $title =>$data){
			$html .= "<td class='$title'>" . $data . "</td>";
		}
		$html .= "<td class='options'><a href='#' class='opt-icon'></a><ul>";
		
      // Row Options Setup -- Need ID
      foreach($options as $opt){
			$html .= "<li>". $opt . "</li>";
		}
		$html .= "</ul></td></tr>";
	}
	
	$html .= "<tbody></table>";
	
	return $html;
}
?> 





















