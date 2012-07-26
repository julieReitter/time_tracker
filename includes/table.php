<?php
	
function createTable($tableData, $options){
	#echo "<pre>";
	#print_r($tableData);
	#echo "</pre>";
	
	if(empty($tableData['row'])){
		$tableData['row'][0]['empty'] = "No data has been saved";
	}
	
	$colCount = count($tableData['row'][0]) + 1;
	$headerColCount = count($tableData['header']);
	$colspan = $colCount - $headerColCount; 
	
	$html = "<table class='data'><thead><tr>";
	foreach($tableData['header'] as $head){
		$html .= "<th colspan='$colspan'> $head </th>";
	}
	$html .= "</tr></thead><tbody>";

	foreach ($tableData['row'] as $key=>$value){
		$html .= "<tr>";
		foreach($value as $title =>$data){
			$html .= "<td class='$title'>" . $data . "</td>";
		}
		$html .= "<td class='options'><ul>";
		foreach($options as $opt){
			$html .= "<li>". $opt . "</li>";
		}
		$html .= "</ul></td></tr>";
	}
	
	$html .= "<tbody></table>";
	
	return $html;
}

?>