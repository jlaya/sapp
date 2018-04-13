<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: josue
 * Date: 22/04/17
 * Time: 07:33 AM
 */

class Rpdf {


    public function __construct()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    function load($params=NULL)

    {

        include_once APPPATH.'/libraries/mpdf/mpdf.php';


        if ($params == NULL)

        {

            $params = '"en-GB-x","A4","","",10,10,10,10,6,3';

        }


        return new mPDF($params);

    }

}
