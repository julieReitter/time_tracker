<?php

   class Form {
      
      public $elements = array();
      
      public function textField($name, $required=false, $value="", $error="") {
         $content = "<input type='text' name=$name id=$name value=$value >";
         $content .= "<span class='error'>$error</span>";
         $this -> elements[] = $content;
      }
      
      public function dropDown($name, $options = array(), $selected=array()){
         //Options is assoc id => val
         $content = "<select name=$name>";
         foreach($options as $key=>$value){
            $content .= "<option value='$key'";
            if(in_array($value, $selected)){
               $content .= "selected='selected'";
            }
            $content .= ">$value</option>";
         }
         $content .= "</select>";
         $this -> elements[] = $content;
      }
      
      public function hidden($name, $value=""){
         $content = "<input type='hidden' name=$name value=$value/>";
         $this -> elements[] = $content;
      }
      
      public function label ($for, $label){
         $content = "<label for=$for>$label</label>";
         $this -> elements[] = $content;
      }
      
      public function market ($html){
         $this -> elements[] = $html;
      }
      
      public function drawForm($name, $action, $submitValue){
         $form = "<form action=$action name=$name id=$name method='post'>";
         foreach ($this -> elements as $el){
            $form .= $el;
         }
         $form .= "<input type='submit' value=$submitValue >";
         $form .= "</form>";
         echo $form;
         //return $form;
      }
      
   }//close form class

?>