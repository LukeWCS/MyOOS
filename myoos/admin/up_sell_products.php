<?php
/* ----------------------------------------------------------------------

   MyOOS [Shopsystem]
   https://www.oos-shop.de

   Copyright (c) 2003 - 2018 by the MyOOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File:  xsell_products.php, v1  2002/09/11
   ----------------------------------------------------------------------
   Cross-Sell

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('OOS_VALID_MOD', 'yes');
require 'includes/main.php';

require 'includes/classes/class_currencies.php';
$currencies = new currencies();

$language = $_SESSION['language'];

$nPage = (!isset($_GET['page']) || !is_numeric($_GET['page'])) ? 1 : intval($_GET['page']); 
$action = (isset($_GET['action']) ? $_GET['action'] : '');

  switch($action) {
    case 'update_up':
      if ($_POST['product']) {
        foreach ($_POST['product'] as $temp_prod) {
          $products_up_selltable = $oostable['products_up_sell'];
          $dbconn->Execute("DELETE FROM $products_up_selltable WHERE up_sell_id = '" . $temp_prod . "' AND products_id = '" . $_GET['add_related_product_id'] . "'"); 
        }
      }

      $products_up_selltable = $oostable['products_up_sell'];
      $sort_start_result = $dbconn->Execute("SELECT sort_order FROM $products_up_selltable WHERE products_id = '" . $_GET['add_related_product_id'] . "' ORDER BY sort_order desc LIMIT 1"); 
      $sort_start = $sort_start_result->fields;

      $sort = (($sort_start['sort_order'] > 0) ? $sort_start['sort_order'] : '0');
      if ($_POST['up']){
        foreach ($_POST['up'] as $temp) {
          $sort++;
          $insert_array = array();
          $insert_array = array('products_id' => $_GET['add_related_product_id'],
                                'up_sell_id' => $temp,
                                'sort_order' => $sort);
          oos_db_perform($oostable['products_up_sell'], $insert_array); 
        }
      }
      $messageStack->add(UP_SELL_SUCCESS, 'success');
      break;

    case 'update_sort' :
      foreach ($_POST as $key_a => $value_a) {
        $products_up_selltable = $oostable['products_up_sell'];
        $dbconn->Execute("UPDATE $products_up_selltable SET sort_order = '" . $value_a . "' WHERE up_sell_id = '" . $key_a . "'");
      }
      $messageStack->add(SORT_UP_SELL_SUCCESS, 'success');
      break;
  }

  require 'includes/header.php';

?>
<!-- body //-->
<style>
.productmenutitle{
cursor:pointer;
margin-bottom: 0px;
background-color:orange;
color:#FFFFFF;
font-weight:bold;
font-family:ms sans serif;
width:100%;
padding:3px;
font-size:12px;
text-align:center;
/* / */border:1px solid #000000;/* */
}
.productmenutitle1{
cursor:pointer;
margin-bottom: 0px;
background-color: red;
color:#FFFFFF;
font-weight:bold;
font-family:ms sans serif;
width:100%;
padding:3px;
font-size:12px;
text-align:center;
/* */border:1px solid #000000;/* */
}
</style>
<script language="JavaScript1.2">

function cOn(td)
{
if(document.getElementById||(document.all && !(document.getElementById))) 
{
td.style.backgroundColor="#CCCCCC";
}
}

function cOnA(td) 
{
if(document.getElementById||(document.all && !(document.getElementById))) 
{
td.style.backgroundColor="#CCFFFF";
}
}

function cOut(td) 
{
if(document.getElementById||(document.all && !(document.getElementById))) 
{
td.style.backgroundColor="DFE4F4";
}
}
</script>

<div class="wrapper">
	<!-- Header //-->
	<header class="topnavbar-wrapper">
		<!-- Top Navbar //-->
		<?php require 'includes/menue.php'; ?>
	</header>
	<!-- END Header //-->
	<aside class="aside">
		<!-- Sidebar //-->
		<div class="aside-inner">
			<?php require 'includes/blocks.php'; ?>
		</div>
		<!-- END Sidebar (left) //-->
	</aside>
	
	<!-- Main section //-->
	<section>
		<!-- Page content //-->
		<div class="content-wrapper">

			<!-- Breadcrumbs //-->
			<div class="content-heading">
				<div class="col-lg-12">
					<h2><?php echo HEADING_TITLE; ?></h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<?php echo '<a href="' . oos_href_link_admin($aContents['default']) . '">' . HEADER_TITLE_TOP . '</a>'; ?>
						</li>
						<li class="breadcrumb-item">
							<?php echo '<a href="' . oos_href_link_admin(oos_selected_file('catalog.php'), 'selected_box=catalog') . '">' . BOX_HEADING_CATALOG . '</a>'; ?>
						</li>
						<li class="breadcrumb-item active">
							<strong><?php echo HEADING_TITLE; ?></strong>
						</li>
					</ol>
				</div>
			</div>
			<!-- END Breadcrumbs //-->
			
			<div class="wrapper wrapper-content">
				<div class="row">
					<div class="col-lg-12">				
<?php
  if ($_GET['add_related_product_id'] == ''){
?>

				<table class="table table-striped w-100">
					<thead class="thead-dark">
						<tr>
							<th width="75"><?php echo TABLE_HEADING_PRODUCT_ID;?></th>
							<th><?php echo TABLE_HEADING_PRODUCT_MODEL;?></th>
							<th><?php echo TABLE_HEADING_PRODUCT_NAME;?></th>
							<th nowrap><?php echo TABLE_HEADING_CURRENT_SELLS;?></th>
							<th colspan="2" nowrap class="text-center"><?php echo TABLE_HEADING_UPDATE_SELLS;?></th>
						</tr>	
					</thead>
<?php
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_result_raw = "SELECT p.products_id, p.products_model, pd.products_name, p.products_id
                            FROM $productstable p,
                                 $products_descriptiontable pd
                            WHERE p.products_id = pd.products_id AND
                                  pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'
                            ORDER BY p.products_id asc";
    $products_split = new splitPageResults($nPage, MAX_DISPLAY_SEARCH_RESULTS, $products_result_raw, $products_result_numrows);
    $products_result = $dbconn->Execute($products_result_raw);
    while ($products = $products_result->fields) {
?>
        <tr onClick=document.location.href="<?php echo oos_href_link_admin($aContents['up_sell_products'], 'add_related_product_id=' . $products['products_id']);?>">
          <td valign="top"><?php echo $products['products_id'];?></td>
          <td valign="top"><?php echo $products['products_model'];?></td>
          <td valign="top"><?php echo $products['products_name'];?></td>
          <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
      $productstable = $oostable['products'];
      $products_descriptiontable = $oostable['products_description'];
      $products_up_selltable = $oostable['products_up_sell'];
      $products_up_result = $dbconn->Execute("SELECT p.products_id, p.products_model, pd.products_name, p.products_id, up.products_id, up.up_sell_id, up.sort_order, up.id 
                                          FROM $productstable p,
                                               $products_descriptiontable pd,
                                               $products_up_selltable up
                                          WHERE up.up_sell_id = p.products_id
                                            AND up.products_id = '". $products['products_id'] . "'
                                            AND p.products_id = pd.products_id
                                            AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "' 
                                          ORDER BY up.sort_order asc");
      $i = 0;
      while ($products_up = $products_up_result->fields){
        $i++;
?>
        <tr>
          <td><?php echo $i . '.&nbsp;&nbsp;<b>' . $products_up['products_model'] . '</b>&nbsp;' . $products_up['products_name'];?></td>
        </tr>
<?php
        // Move that ADOdb pointer!
        $products_up_result->MoveNext();
      }
      // Close result set
      $products_up_result->Close();

      if ($i <= 0) {
?>
        <tr>
          <td>&nbsp;--&nbsp;</td>
        </tr>
<?php
      } else {
?>
        <tr>
          <td></td>
        </tr>
<?php
      }
?>
      </table></td>
      <td valign="top"><?php echo '<a href="' . oos_href_link_admin($aContents['up_sell_products'], oos_get_all_get_params(array('action')) . 'add_related_product_id=' . $products['products_id']);?>"><?php echo TEXT_EDIT_SELLS;?></a></td>
      <td valign="top" align="center"><?php echo (($i > 0) ? '<a href="' . oos_href_link_admin($aContents['up_sell_products'], oos_get_all_get_params(array('action')) . 'sort=1&add_related_product_id=' . $products['products_id']) .'">'.TEXT_SORT.'</a>' : '--')?></td>
    </tr>
<?php
      // Move that ADOdb pointer!
      $products_result->MoveNext();
    }

    // Close result set
    $products_result->Close();
?>
    <tr>
      <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBoxContent">
        <tr>
          <td class="smallText" valign="top"><?php echo $products_split->display_count($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $nPage, TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
          <td class="smallText" align="right"><?php echo $products_split->display_links($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $nPage, oos_get_all_get_params(array('page', 'info', 'x', 'y', 'cID', 'action'))); ?></td>
        </tr>
      </table></td>
    </tr>
  </table>
<?php
  } elseif ($_GET['add_related_product_id'] != '' && $_GET['sort'] == '') {
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_name_result = $dbconn->Execute("SELECT pd.products_name, p.products_model, p.products_image
                                          FROM $productstable p,
                                               $products_descriptiontable pd
                                          WHERE p.products_id = '" . $_GET['add_related_product_id'] . "'
                                            AND p.products_id = pd.products_id 
                                            AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'");
    $products_name = $products_name_result->fields;
?>
<?php echo oos_draw_form('id', 'update_up', $aContents['up_sell_products'], oos_get_all_get_params(array('action')) . 'action=update_up', 'post', TRUE);?>
	  
<table cellpadding="3" cellspacing="0" border="0" width="100%">
            <tr>
              <td valign="top" align="center" colspan="2"><span class="pageHeading"><?php echo TEXT_SETTING_SELLS.': '.$products_name['products_name'].' ('.TEXT_MODEL.': '.$products_name['products_model'].') ('.TEXT_PRODUCT_ID.': '.$_GET['add_related_product_id'].')';?></span></td>
            </tr>
            <tr>
              <td class="text-right"><?php echo oos_info_image($products_name['products_image'], $products_name['products_name']);?></td>
              <td align="right" valign="bottom"><?php echo oos_submit_button('update', IMAGE_UPDATE) . '<br /><br /><a href="'.oos_href_link_admin($aContents['up_sell_products'], 'men_id=catalog').'">' . oos_button('cancel', BUTTON_CANCEL) . '</a>';?></td>
            </tr>
          </table>

			<div class="table-responsive">		  
				<table class="table table-striped table-hover w-100">
					<thead class="thead-dark">
						<tr>
							<th width="75"><?php echo TABLE_HEADING_PRODUCT_ID;?></th>
							<th><?php echo TABLE_HEADING_PRODUCT_MODEL;?></th>
							<th><?php echo TABLE_HEADING_PRODUCT_IMAGE;?></th>
							<th><?php echo TABLE_HEADING_UP_SELL_THIS;?></th>
							<th><?php echo TABLE_HEADING_PRODUCT_NAME;?></th>
							<th><?php echo TABLE_HEADING_PRODUCT_PRICE;?></td>
						</tr>	
					</thead>
<?php
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_result_raw = "SELECT p.products_id, p.products_model, p.products_image, p.products_price, pd.products_name, p.products_id 
                            FROM $productstable p,
                                 $products_descriptiontable pd
                           WHERE p.products_id = pd.products_id
                             AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'
                           ORDER BY p.products_id asc";
    $products_split = new splitPageResults($nPage, MAX_DISPLAY_SEARCH_RESULTS, $products_result_raw, $products_result_numrows);
    $products_result = $dbconn->Execute($products_result_raw);
    while ($products = $products_result->fields) {
      $up_sold_result = $dbconn->Execute('SELECT * FROM '.$oostable['products_up_sell'].' WHERE products_id = "'.$_GET['add_related_product_id'].'" AND up_sell_id = "'.$products['products_id'].'"');
?>
        <tr>
          <td align="center"><?php echo $products['products_id'];?></td>
          <td align="center"><?php echo $products['products_model'];?></td>
          <td align="center"><?php echo oos_info_image($products['products_image'], $products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);?></td>
          <td><?php echo oos_draw_hidden_field('product[]', $products['products_id']) . oos_draw_checkbox_field('up[]', $products['products_id'], (($up_sold_result->RecordCount() > 0) ? true : false), '', ' onMouseOver="this.style.cursor=\'hand\'"');?><label onMouseOver="this.style.cursor='hand'"><?php echo TEXT_UP_SELL;?></label></td>
          <td><?php echo $products['products_name'];?></td>
          <td><?php echo $currencies->format($products['products_price']);?></td>
        </tr>
<?php
      // Move that ADOdb pointer!
      $products_result->MoveNext();
    }
    // Close result set
    $products_result->Close();
?>
      </table>
	  </div>
	  
	  </form>
	  
	  
	  <table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBoxContent">
        <tr>
          <td class="smallText" valign="top"><?php echo $products_split->display_count($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $nPage, TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>
          <td class="smallText" align="right"><?php echo $products_split->display_links($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $nPage, oos_get_all_get_params(array('page', 'info', 'x', 'y', 'cID', 'action'))); ?></td>
        </tr>
      </table>
<?php
  } elseif ($_GET['add_related_product_id'] != '' && $_GET['sort'] != '') {
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_name_result = $dbconn->Execute("SELECT pd.products_name, p.products_model, p.products_image 
                                          FROM $productstable p,
                                               $products_descriptiontable pd
                                          WHERE p.products_id = '" . $_GET['add_related_product_id'] . "'
                                            AND p.products_id = pd.products_id
                                            AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'");
    $products_name = $products_name_result->fields;
?>
  <table border="0" cellspacing="0" cellpadding="0" bgcolor="#999999" align="center">
    <tr>
      <td><?php echo oos_draw_form('id', 'update_sort', $aContents['up_sell_products'], oos_get_all_get_params(array('action')) . 'action=update_sort', 'post', TRUE);?><table cellpadding="1" cellspacing="1" border="0">
        <tr>
          <td colspan="6"><table cellpadding="3" cellspacing="0" border="0" width="100%">
            <tr>
              <td valign="top" align="center" colspan="2"><span class="pageHeading"><?php echo 'Setting up-sells for: '.$products_name['products_name'].' (Model: '.$products_name['products_model'].') (Product ID: '.$_GET['add_related_product_id'].')';?></span></td>
                </tr>
                <tr>
                  <td class="text-right"><?php echo oos_info_image($products_name['products_image'], $products_name['products_name']);?></td>
                  <td align="right" valign="bottom"><?php echo oos_submit_button('update', IMAGE_UPDATE) . '<br /><br /><a href="'.oos_href_link_admin($aContents['up_sell_products'], 'men_id=catalog').'">' . oos_button('cancel', BUTTON_CANCEL) . '</a>';?></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_ID;?></td>
              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_MODEL;?></td>
              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_IMAGE;?></td>
              <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PRODUCT_NAME;?></td>
              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_PRICE;?></td>
              <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_SORT;?></td>
            </tr>
<?php
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_up_selltable = $oostable['products_up_sell'];
    $products_result_raw = "SELECT p.products_id AS products_id, p.products_price, p.products_image, p.products_model, pd.products_name, p.products_id, up.products_id AS up_products_id, up.up_sell_id, up.sort_order, up.id 
                              FROM $productstable p,
                                   $products_descriptiontable pd,
                                   $products_up_selltable up
                             WHERE up.up_sell_id = p.products_id 
                               AND up.products_id = '" . $_GET['add_related_product_id'] . "'
                               AND p.products_id = pd.products_id 
                               AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'
                             ORDER BY up.sort_order asc";
    $products_split = new splitPageResults($nPage, MAX_DISPLAY_SEARCH_RESULTS, $products_result_raw, $products_result_numrows);
    $sort_order_drop_array = array();
    for ($i = 1; $i <= $products_result_numrows; $i++) {
      $sort_order_drop_array[] = array('id' => $i, 'text' => $i);
    }
    $products_result = $dbconn->Execute($products_result_raw);
    while ($products = $products_result->fields) {
?>
            <tr bgcolor='#DFE4F4'>
              <td align="center"><?php echo $products['products_id'];?></td>
              <td align="center"><?php echo $products['products_model'];?></td>
              <td align="center"><?php echo oos_info_image($products_name['products_image'], $products_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);?></td>
              <td align="center"><?php echo $products['products_name'];?></td>
              <td align="center"><?php echo $currencies->format($products['products_price']);?></td>
              <td align="center"><?php echo oos_draw_pull_down_menu($products['products_id'], $sort_order_drop_array, $products['sort_order']);?></td>
            </tr>
<?php
      // Move that ADOdb pointer!
      $products_result->MoveNext();
    }
    // Close result set
    $products_result->Close();
?>
          </table></form></td>
        </tr>
        <tr>
          <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBoxContent">
            <tr>
              <td class="smallText" valign="top"><?php echo $products_split->display_count($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $nPage, TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
              <td class="smallText" align="right"><?php echo $products_split->display_links($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $nPage, oos_get_all_get_params(array('page', 'info', 'x', 'y', 'cID', 'action'))); ?></td>
            </tr>
          </table></td>
        </tr>
      </table>
<?php
  }
?>
<!-- body_text_eof //-->

				</div>
			</div>
        </div>

		</div>
	</section>
	<!-- Page footer //-->
	<footer>
		<span>&copy; 2018 - <a href="https://www.oos-shop.de" target="_blank" rel="noopener">MyOOS [Shopsystem]</a></span>
	</footer>
</div>

<?php 
	require 'includes/bottom.php';
	require 'includes/nice_exit.php';
?>