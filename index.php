<?php
/**
 * @Created by          : Drajat Hasan
 * @Date                : 2021-07-17 20:28:30
 * @File name           : index.php
 */

use SLiMSFilemanager\Action\Http;

// key to authenticate
if (!defined('INDEX_AUTH')) {
  define('INDEX_AUTH', '1');
}

// key to get full database access
define('DB_ACCESS', 'fa');

if (!defined('SB')) {
    // main system configuration
    require '../../../sysconfig.inc.php';
    // start the session
    require SB.'admin/default/session.inc.php';
}

// IP based access limitation
require LIB . 'ip_based_access.inc.php';
// set dependency
require SB.'admin/default/session_check.inc.php';
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require __DIR__ . '/helpers.php';
require __DIR__ . '/autoload.php';
// end dependency

// Create system config
createSysconf();

// Load system settings
utility::loadSettings($dbs);

// Rest/APi On Here
Http::fetchRequest();

// privileges checking
$can_read = utility::havePrivilege('filemanager', 'r');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

$page_title = 'Filemanager';

// View area
echo View((isset($_GET['view']) ? $_GET['view'] : 'Main'));
?>
<!-- Javascript -->
<script src="modules/filemanager/app.js" has-url="true" data-ds="<?= DS ?>" data-baseurl="<?= $_SERVER['PHP_SELF'] ?>"></script>