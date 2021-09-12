<?php
defined('INDEX_AUTH') or die('No direct access!');
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
                <button class="btn btn-danger" onclick="deleteItem()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </button>
                <button class="btn btn-info float-right mx-1" onclick="unCheckAll()">Hilangkan Semua Tanda</button>
                <button class="btn btn-warning float-right" onclick="checkAll()">Tandai Semua</button>
            </div>
        </div>
    </div>
</div>
<section id="result" class="d-flex flex-wrap mx-3">
    <div class="card mx-1 rounded" style="width: 32%; cursor: pointer">
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/folder.svg">
        <div class="card-body">
            <h5 class="card-title">Folder Files</h5>
            <p class="card-text">Berisi berbagai macam file yang berkaitan dengan arsip, laporan dll baik yang bersifat hasil <i>generate</i> maunpun file statis.</p>
            <button onclick="openFolder('files')" class="btn btn-primary">Masuk</button>
        </div>
    </div>
    <div class="card mx-1 rounded" style="width: 32%; cursor: pointer">
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/folder.svg">
        <div class="card-body">
            <h5 class="card-title">Folder Images</h5>
            <p class="card-text">Berisi file dan folder yang berkaitan dengan gambar seperti foto profil pengguna anggota maupun pemustaka serta gambar barcode.</p>
            <button onclick="openFolder('images')" class="btn btn-primary">Masuk</button>
        </div>
    </div>
    <div class="card mx-1 rounded" style="width: 32%; cursor: pointer">
        <img class="card-img-top w-25 mt-4 mx-auto block" src="modules/filemanager/assets/folder.svg">
        <div class="card-body">
            <h5 class="card-title">Folder Repository</h5>
            <p class="card-text">Berisi file dan folder yang berkaitan dengan penyimpnan file lampiran unggahan seperti PDF,DOCX, dll.</p>
            <button onclick="openFolder('repository')" class="btn btn-primary">Masuk</button>
        </div>
    </div>
</section>