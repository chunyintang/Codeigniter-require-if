<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Form_validation extends CI_Form_validation {
 
 
  public function __construct($rules = array())
  {
    parent::__construct($rules);
    $this->CI =& get_instance();
    $this->_config_rules = $rules;
  }

  protected function _execute($row, $rules, $postdata = NULL, $cycles = 0)
  {
    
    parent::_execute( $row, $rules, $postdata, $cycles );
    
    $callback = FALSE;
    if ( ! in_array('required', $rules) AND is_null($postdata))
    {
      // Before we bail out, does the rule contain a callback?
      if(!preg_match("/required_if\[(.+?)\]/", implode(' ', $rules)) AND is_null($postdata)) 
      {
        if (preg_match("/(callback_\w+(\[.*?\])?)/", implode(' ', $rules), $match))
        {
          $callback = TRUE;
          $rules = (array('1' => $match[1]));
        }
        else
        {
          return;
        }
      }
    }
    
    if(preg_match("/required_if\[(.*?),(.*?)\]/", implode(' ', $rules), $matches) AND $callback == FALSE)
    {
      if(isset($_POST[$matches[1]])) {
        if($_POST[$matches[1]] == $matches[2] AND is_null($postdata)) {

          $message = sprintf("The %s field can not be empty", $this->_translate_fieldname($row['label']));

          $this->_field_data[$row['field']]['error'] = $message;
          if ( ! isset($this->_error_array[$row['field']]))
          {
            $this->_error_array[$row['field']] = $message;
          }
        }
      }
    } 
  }

  public function required_if($str, $param)
  {
    $field = explode(',',$param, 2)[0];
    $value = explode(',',$param, 2)[1];
    if(isset($_POST[$field])) {
      if($_POST[$field] == $value && is_null($str)) {
        $this->CI->form_validation->set_message('required_if', 'the %s field can not be empty');
        return false;
      } else {
        return true;
      }
    } else {
      return true;
    }
  }
}
