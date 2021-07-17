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

// Rest/APi On Here
Http::fetchRequest();

// privileges checking
$can_read = utility::havePrivilege('filemanager', 'r');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

$page_title = 'Filemanager';

/* Action Area */

/* End Action Area */
// $contents = new SLiMSFilemanager\Action\LoadContent(SB.'files');


?>
<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title text-dark">
            <h2><?php echo $page_title; ?></h2>
            <h5 class="mt-2 pathMa,e"></h5>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-default">Daftar</a>
            </div>
        </div>
    </div>
</div>
<section id="result" class="d-flex flex-wrap mx-3">
    <div class="card mx-1 rounded" style="width: 32%; cursor: pointer" onclick="openFolder('files')">
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/folder.svg">
        <div class="card-body">
            <h5 class="card-title">Folder Files</h5>
            <p class="card-text">Berisi berbagai macam file yang berkaitan dengan arsip, laporan dll baik yang bersifat hasil <i>generate</i> maunpun file statis.</p>
            <a href="#" class="btn btn-primary">Masuk</a>
        </div>
    </div>
    <div class="card mx-1 rounded" style="width: 32%; cursor: pointer" onclick="openFolder('images')">
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/folder.svg">
        <div class="card-body">
            <h5 class="card-title">Folder Images</h5>
            <p class="card-text">Berisi file dan folder yang berkaitan dengan gambar seperti foto profil pengguna anggota maupun pemustaka serta gambar barcode.</p>
            <a href="#" class="btn btn-primary">Masuk</a>
        </div>
    </div>
    <div class="card mx-1 rounded" style="width: 32%; cursor: pointer" onclick="openFolder('repository')">
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/folder.svg">
        <div class="card-body">
            <h5 class="card-title">Folder Repository</h5>
            <p class="card-text">Berisi file dan folder yang berkaitan dengan penyimpnan file lampiran unggahan seperti PDF,DOCX, dll.</p>
            <a href="#" class="btn btn-primary">Masuk</a>
        </div>
    </div>
</section>
<script src="modules/filemanager/app.js" has-url="true" data-baseurl="<?= $_SERVER['PHP_SELF'] ?>"></script>