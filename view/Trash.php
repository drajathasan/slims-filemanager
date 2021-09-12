<?php
defined('INDEX_AUTH') or die('No direct access!');

use SLiMSFilemanager\Action\Trash;

$Trash = Trash::init();
?>

<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title text-dark">
            <h2><?php echo $page_title; ?></h2>
            <h5 class="mt-2 pathName">Tempat Sampah</h5>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-default">Menu Utama</a>
            </div>
            <div class="actionArea">
                <?php if ($_SESSION['uid'] == '1'): ?>
                <button class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </button>
                <button class="btn btn-success" title="restore" onclick="restore()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                    </svg>
                </button>
                <?php endif; ?>
                <button class="btn btn-info float-right mx-1" onclick="unCheckAll()">Hilangkan Semua Tanda</button>
                <button class="btn btn-warning float-right" onclick="checkAll()">Tandai Semua</button>
            </div>
        </div>
    </div>
</div>
<section id="result" class="d-flex flex-wrap mx-3">
    <?php foreach($Trash->bin() as $Data): ?>
    <div class="card mx-1 rounded" style="width: 19%; cursor: pointer">
        <input type="checkbox" class="checkItem mx-2 my-3" data-path="<?= $Data['name'] ?>"/>
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/<?= $Data['icon'] ?>">
        <div class="card-body text-center">
            <span class="block card-title font-weight-bold text-dark text-center filelabel"><?= $Data['name'] ?></span>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (count($Trash->bin()) < 1): ?>
        <div class="w-100 text-danger p-2 rounded-lg font-weight-bold text-center" style="background: lightgrey">Tidak ada data</div>
    <?php endif; ?>
</div>