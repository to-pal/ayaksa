<?php
/**
 * @package Sj Extra Slider
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;

// Include the helper functions only once
require_once __DIR__ . '/core/helper.php';

$idbase = $params->get('catid');
$cacheid = md5(serialize(array ($idbase, $module->module)));
$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class = 'SjExtrasliderHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = $cacheid;
$items = JModuleHelper::moduleCache($module, $params, $cacheparams);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_sj_extraslider', $params->get('layout', 'default'));?>

