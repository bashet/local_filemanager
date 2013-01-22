<?php
require('../../config.php');
require_once($CFG->dirroot.'/lib/filestorage/file_storage.php');

require_login();
if (isguestuser()) {
    die();
}

if (isset($_GET['img'])){
    $img = $_GET['img'];
    
    $contextid  = 1;
    $component  = 'local_filemanager';
    $filesarea  = 'images';
    $itemid     = 1;
    $fs = get_file_storage();
    $file = $fs->get_file($contextid, $component, $filesarea, $itemid,'/',$img);
    echo send_stored_file($file, 84000);
}else {
    echo 'file not found!';
}


