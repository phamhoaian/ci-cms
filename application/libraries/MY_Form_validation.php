<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @category
 * @package    MYNETS Form Validation Class
 * @author     KUNIHARU Tsujioka <kunitsuji@gmail.com>
 * @copyright  Copyright (c) 2008 KUNIHARU Tsujioka <kunitsuji@gmail.com>
 * @copyright  Copyright (c) 2006-2008 Usagi Project (URL:http://usagi-project.org)
 * @license    New BSD License
 */

// ------------------------------------------------------------------------

class MY_Form_validation extends CI_Form_validation {

    /**
     * Constructor
     *
     */
    function MY_Form_validation($rules = array())
    {
        parent::__construct();
    }
    
    // --------------------------------------------------------------------
    /**
     * Valid Email
     *
     * @access  public
     * @param   string
     * @return  bool
     */
    function valid_email($str)
    {
        return ( ! preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------

}
// END MYNETS Form Validation Class

/* End of file MYNETS_Form_validation.php */
/* Location: ./system/mynets/libraries/MYNETS_Form_validation.php */