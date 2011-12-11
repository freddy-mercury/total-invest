<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty index modifier plugin
 *
 * Type:     modifier<br>
 * Name:     index<br>
 * Purpose:  designate index value for empty variables
 * @link http://smarty.php.net/manual/en/language.modifier.index.php
 *          index (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_default($string, $default = '')
{
    if (!isset($string) || $string === '')
        return $default;
    else
        return $string;
}

/* vim: set expandtab: */

?>
