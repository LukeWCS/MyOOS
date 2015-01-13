<?php
/* ----------------------------------------------------------------------
   $Id: define_language.php,v 1.1 2007/06/08 17:14:41 r23 Exp $

   MyOOS [Shopsystem]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2015 by the MyOOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: define_language.php,v 1.13 2003/02/14 19:27:39 dgw_ 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/main.php';

  if (!isset($_GET['lngdir'])) $_GET['lngdir'] = $_SESSION['language'];

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {  
      case 'save':
        if (isset($_GET['lngdir']) && isset($_GET['filename'])) {
          if ($_GET['filename'] == $_GET['lng_dir'] . '.php') {
            $file = OOS_ABSOLUTE_PATH . 'includes/languages/' . $_GET['filename'];
          } else {
            $file = OOS_ABSOLUTE_PATH . 'includes/languages/' . $_GET['lngdir'] . '/' . $_GET['filename'];
          }
          if (file_exists($file)) {
            if (file_exists('bak' . $file)) {
              @unlink('bak' . $file);
            }

            @rename($file, 'bak' . $file);

            $new_file = fopen($file, 'w');
            $file_contents = stripslashes($_POST['file_contents']);
            fwrite($new_file, $file_contents, strlen($file_contents));
            fclose($new_file);
          }
          oos_redirect_admin(oos_href_link_admin($aContents['define_language'], 'lngdir=' . $_GET['lngdir']));
        }
        break;
    }
  }

  $languages_array = array();
  $languages = oos_get_languages();
  $lng_exists = false;
  for ($i = 0, $n = count($languages); $i < $n; $i++) {
    if ($languages[$i]['iso_639_2'] == $_GET['lngdir']) $lng_exists = true;

    $languages_array[] = array('id' => $languages[$i]['iso_639_2'],
                               'text' => $languages[$i]['name']);
  }

  if (!$lng_exists) $_GET['lngdir'] = $_SESSION['language'];

  $no_js_general = true;
  require 'includes/header.php'; 
?>
<div id="wrapper">
	<?php require 'includes/blocks.php'; ?>
		<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom">
			<?php require 'includes/menue.php'; ?>
			</div>

			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
<!-- body_text //-->
	<table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr><?php echo oos_draw_form('lng', $aContents['define_language'], '', 'get'); ?>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', '1', HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_pull_down_menu('lngdir', $languages_array, '', 'onChange="this.form.submit();"'); ?></td>
          </form></tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if (isset($_GET['lngdir']) && isset($_GET['filename'])) {
    if ($_GET['filename'] == $_GET['lngdir'] . '.php') {
      $file = OOS_ABSOLUTE_PATH . 'includes/languages/' . $_GET['filename'];
    } else {
      $file = OOS_ABSOLUTE_PATH . 'includes/languages/' . $_GET['lngdir'] . '/' . $_GET['filename'];
    }
    if (file_exists($file)) {
      $file_array = file($file);
      $file_contents = implode('', $file_array);

      $file_writeable = true;
      if (!is_writeable($file)) {
        $file_writeable = false;
        $messageStack->reset();
        $messageStack->add(sprintf(ERROR_FILE_NOT_WRITEABLE, $file), 'error');
        echo $messageStack->output();
      }

?>
          <tr><?php echo oos_draw_form('language', $aContents['define_language'], 'lngdir=' . $_GET['lngdir'] . '&filename=' . $_GET['filename'] . '&action=save'); ?>
            <td><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><b><?php echo $_GET['filename']; ?></b></td>
              </tr>
              <tr>
                <td class="main"><?php echo oos_draw_textarea_field('file_contents', 'soft', '80', '20', $file_contents, (($file_writeable) ? '' : 'readonly')); ?></td>
              </tr>
              <tr>
                <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td align="right"><?php if ($file_writeable) { echo oos_image_swap_submits('save','save_off.gif', IMAGE_SAVE) . '&nbsp;<a href="' . oos_href_link_admin($aContents['define_language'], 'lngdir=' . $_GET['lngdir']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>'; } else { echo '<a href="' . oos_href_link_admin($aContents['define_language'], 'lngdir=' . $_GET['lngdir']) . '">' . oos_image_swap_button('back','back_off.gif', IMAGE_BACK) . '</a>'; } ?></td>
              </tr>
            </table></td>
          </form></tr>
<?php
    } else {
?>
          <tr>
            <td class="main"><b><?php echo TEXT_FILE_DOES_NOT_EXIST; ?></b></td>
          </tr>
          <tr>
            <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td><?php echo '<a href="' . oos_href_link_admin($aContents['define_language'], 'lngdir=' . $_GET['lngdir']) . '">' . oos_image_swap_button('back','back_off.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>
<?php
    }
  } else {
    $filename = $_GET['lngdir'] . '.php';
?>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText"><a href="<?php echo oos_href_link_admin($aContents['define_language'], 'lngdir=' . $_GET['lngdir'] . '&filename=' . $filename); ?>"><b><?php echo $filename; ?></b></a></td>
<?php
    $dir = dir(OOS_ABSOLUTE_PATH . 'includes/languages/' . $_GET['lngdir']);
    $left = false;
    if ($dir) {
      $file_extension = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '.'));
      while ($file = $dir->read()) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          echo '                <td class="smallText"><a href="' . oos_href_link_admin($aContents['define_language'], 'lngdir=' . $_GET['lngdir'] . '&filename=' . $file) . '">' . $file . '</a></td>' . "\n";
          if (!$left) {
            echo '              </tr>' . "\n" .
                 '              <tr>' . "\n";
          }
          $left = !$left;
        }
      }
      $dir->close();
    }
?>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
          </tr>
<?php
  }
?>
        </table></td>
      </tr>
    </table>
<!-- body_text_eof //-->

				</div>
			</div>
        </div>

	</div>
</div>


<?php 
	require 'includes/bottom.php';
	require 'includes/nice_exit.php';
?>