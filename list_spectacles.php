<?php
require_once('include/require.php');
require_once('include/lib/IteratorPresenter.class.php');
define('NB_BY_PAGE',6);
define('MAX_PAGER',5);

$spectacles = new Spectacles();
//update database
$spectacles->update_spectacles();

$zip_code =  0;
$offset = 0;
$nb_by_page = 6;
$spectacles_result = array();

if(isset($_REQUEST['zip_code'])){
  $zip_code = intval($_REQUEST['zip_code']);
}

if (isset($_REQUEST['offset'])){
  $offset = $_REQUEST['offset'];
}

if($spectacles->is_valid_zip_code($zip_code)) {
  $spectacles_result['spectacles'] = $spectacles->find_spectacles_by_zip_code($zip_code,NB_BY_PAGE,$offset);
} else {
  $spectacles->limitData(NB_BY_PAGE,$offset);
  $spectacles_result['spectacles'] = $spectacles->findData();
}

$spectacles_result['pages'] = new IteratorPresenter($spectacles->pagerData(MAX_PAGER)['pages']); // reformat the numeric array to an associative array
// print_r($spectacles);
// exit();
$spectacles_result['zip_code'] = $zip_code;

render_template('list_spectacles',$spectacles_result);
