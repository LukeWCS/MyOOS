<?php
/* ----------------------------------------------------------------------

   MyOOS [Shopsystem]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2014 by the MyOOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */


  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) OR die( 'Direct Access to this location is not allowed.' );

  class plugin_event {
    var $aEventPlugins, $aPlugins;

	public function __construct() {
      $this->aEventPlugins = explode(';', MODULE_PLUGIN_EVENT_INSTALLED);
    }

    function getInstance() {
      $this->aPlugins = array();

      foreach ($this->aEventPlugins as $event) {
        $this->load_plugin($event);
      }
    }


    function load_plugin($sInstance, $sPluginPath = '') {

      $sName = 'oos_event_' . $sInstance;

      if (!class_exists($sName)) {
        if (empty($sPluginPath)) {
/*
          $dbconn =& oosDBGetConn();
          $oostable =& oosDBGetTables();

          $sql = "SELECT path FROM plugins WHERE name = '" . oos_db_input($sInstance) . "'";
          $path_result = $dbconn->Execute($sql); 

          if ($path_result->RecordCount() > 0) {
            $sPluginPath = $path_result->fields['path']
          }
*/

          if (empty($sPluginPath)) {
            $sPluginPath = $sName;
          }
        }


        $sPluginPath = oos_var_prep_for_os($sPluginPath);
        $sName = oos_var_prep_for_os($sName);

        if (file_exists('includes/plugins/' . $sPluginPath . '/' . $sName . '.php')) {
          include_once 'includes/plugins/' . $sPluginPath . '/' . $sName . '.php';
        }

        if (isset($_SESSION['language']) &&  file_exists('includes/plugins/' . $sPluginPath . '/lang/' . oos_var_prep_for_os($_SESSION['language']) . '.php')) {
          include_once 'includes/plugins/' . $sPluginPath . '/lang/' . oos_var_prep_for_os($_SESSION['language']) . '.php';
        } elseif (file_exists('includes/plugins/' . $sPluginPath . '/lang/' . DEFAULT_LANGUAGE . '.php')) {
          include_once 'includes/plugins/' . $sPluginPath . '/lang/' . DEFAULT_LANGUAGE . '.php';
        }

        if (!class_exists($sName)) {
          return FALSE;
        }
      }

      if (@call_user_func(array('oos_event_' . $sInstance, 'create_plugin_instance'))) {
        $this->aPlugins[] = $sName;
      }

      return true;
    }


    function introspect() {
      $this->aPlugins = array();

      foreach ($this->aEventPlugins as $event) {
        $this->get_intro($event);
      }
    }


    function get_intro($event) {
      @call_user_func(array('oos_event_' . $event, 'intro'));
    }


    function installed_plugin($event) {
       return in_array($event, $this->aEventPlugins);
    }
  }

