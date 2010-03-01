<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* to_xml Plugin for Code Igniter
   version for PHP 4 and above  */

function to_xml($object, $element_name)
{
	header("Content-Type: text/xml; charset=utf-8;");
	header("Content-Disposition: attachment; filename=$element_name.xml");

   $obj =& get_instance();
   
   /* determine whether the $object is a table name or query result */
   switch (TRUE){
   case is_string($object): // treat object as a tablename
      $query = $obj->db->get($object);
      $total = count($query->result_array());
      $fields = $obj->db->field_names($object);
      break;
   case !is_string($object): // treat object as an Active Record query result
      $query = $object;
      $total = $object->num_rows();
      $field_list = $object->field_data();
      foreach($field_list as $key=>$value)
      {
          if ($key = 'name') // only keep name metadata
          {
            $fields[] = current($value);
          }
      }
      break;
   }
   
   /* Prepare XML Writer  */
   $obj->xmlwriter4 = new Xmlwriter4();
   $xml = $obj->xmlwriter4;

   /* Start XML */  
   $xml->push('newsletter_information', array('total' => $total));
   
   /* Create an element for each query result */
   foreach ($query->result_array() as $row)
   {
      foreach ($fields as $field)
      {
         $allfields[$field] = $row[$field];
      }
      $xml->emptyelement($element_name, $allfields);
   } //end loop through query
     
   /* close XML and output */
   $xml->pop();
   print $xml->getXml();
}

// Xmlwriter class by Simon Willison, 16th April 2003
// Based on Lars Marius Garshol's Python XMLWriter class
class Xmlwriter4 {
    var $xml;
    var $indent;
    var $stack = array();
    function Xmlwriter4($indent = '   ') {
        $this->indent = $indent;
        $this->xml = '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
    }
    function _indent() {
        for ($i = 0, $j = count($this->stack); $i < $j; $i++) {
            $this->xml .= $this->indent;
        }
    }
    function push($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        $this->xml .= ">\r\n";
        $this->stack[] = $element;
    }
    function element($element, $content, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        $this->xml .= '>'.htmlentities($content).'</'.$element.'>'."\r\n";
    }
    function emptyelement($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';
        }
        $this->xml .= " />\r\n";
    }
    function pop() {
        $element = array_pop($this->stack);
        $this->_indent();
        $this->xml .= "</$element>\r\n";
    }
    function getXml() {
        return $this->xml;
    }
}
?>