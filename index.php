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
            <h5 class="mt-2 pathName"></h5>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-default">Menu Utama</a>
            </div>
            <div class="actionArea d-none">
                <button id="back-btn" onclick="backPage(this)" class="btn btn-primary" to="/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-1 bi bi-arrow-left-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg>
                    Kembali
                </button>
                <?php if ($_SESSION['uid'] == '1'): ?>
                <button class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </button>
                <?php endif; ?>
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
            <button onclick="openFolder('files')" class="btn btn-primary">Masuk</button>
        </div>
    </div>
    <div class="card mx-1 rounded" style="width: 32%; cursor: pointer" onclick="openFolder('images')">
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/folder.svg">
        <div class="card-body">
            <h5 class="card-title">Folder Images</h5>
            <p class="card-text">Berisi file dan folder yang berkaitan dengan gambar seperti foto profil pengguna anggota maupun pemustaka serta gambar barcode.</p>
            <button onclick="openFolder('images')" class="btn btn-primary">Masuk</button>
        </div>
    </div>
    <div class="card mx-1 rounded" style="width: 32%; cursor: pointer" onclick="openFolder('repository')">
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/folder.svg">
        <div class="card-body">
            <h5 class="card-title">Folder Repository</h5>
            <p class="card-text">Berisi file dan folder yang berkaitan dengan penyimpnan file lampiran unggahan seperti PDF,DOCX, dll.</p>
            <button onclick="openFolder('repository')" class="btn btn-primary">Masuk</button>
        </div>
    </div>
</section>
<script src="modules/filemanager/app.js" has-url="true" data-ds="<?= DS ?>" data-baseurl="<?= $_SERVER['PHP_SELF'] ?>"></script>