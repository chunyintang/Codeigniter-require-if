# Codeiginiter - Form validation rule for require if. 

This custum library is a custom form validation rule for require if. This functionality is made for when this a field will be required depending on another field. 
This functionality works for in the controller as well for in the config file. 

# Requirements 

Codeigniter 2.x Php 5.2 or above


# Installation

Just put copy the files into your server using the same folder structure. 


# Implementation

There are two different way to append this rule. You can do this in the 'controller' but also in the 'config' file. 
Both are supported


## Scenario:

So we have a form that has a radio button were you can select if you want to send a copy to yourself or someone else. 
So if you choose 'yes' with a value of '1', than the 'copy_mail' field will be required because the of the dependacy. So there is a possiblity that when you click on "no" with a value of "0" than the field won't be required. 

### Controller

```
$this->form_validation->set_rules('copy_to', 'Send Copy?', 'required');
$this->form_validation->set_rules('copy_email', 'Email address', 'required_if[copy_to,1]');
```

so above you will see the example, how the required_if works. You see there is two params 'copy_to' and '1'. The first param is on which field it depends and the second param is what the exact value needs to be. So for this example it is '1'.


### Config File

The same scenario but now in the config file

```
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

   $config = array(
      'form' => array(
         array(
               'field'   => 'copy_to', 
               'label'   => 'Send Copy?', 
               'rules'   => 'required'
            ),
         array(
               'field'   => 'copy_email', 
               'label'   => 'Email address',
               'rules'   => 'required_if[copy_to,1]'
         )
      )
   ); 
```

