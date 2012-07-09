<?php
	
function createTable($tableData, $options){
	#echo "<pre>";
	#print_r($tableData);
	#echo "</pre>";
	
	$html = "<table><thead><tr>";
	foreach($tableData['header'] as $head){
		$html .= "<th> $head </th>";
	}
	$html .= "</tr></thead><tbody>";
	foreach ($tableData['row'] as $key=>$value){
		$html .= "<tr>";
		foreach($value as $title =>$data){
			$html .= "<td class='$title'>" . $data . "<td>";
		}
		foreach($options as $opt){
			$html .= "<td class='options'>". $opt . "</td>";
		}
		$html .= "</tr>";
	}
	$html .= "<tbody></table>";
	
	return $html;
}

?>