<?php

require('../../config.php');

require_once($CFG->dirroot.'/lib/filelib.php');



require_login();
if (isguestuser()) {
    die();
}



global $CFG, $DB, $USER, $OUTPUT;

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_url('/local/filemanager/');
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_filemanager'));
$PAGE->set_heading(get_string('pluginname', 'local_filemanager'));
$PAGE->set_pagelayout('mydashboard');
$PAGE->navbar->add(get_string('pluginname', 'local_filemanager'));

$my_images = '';
$count_image = $DB->count_records_sql("SELECT COUNT('x') FROM {files} where component = 'local_filemanager' and filesize != 0");
$my_images .= '<br>Total image found to show: '. $count_image;

$records = $DB->get_records_sql("SELECT * FROM {files} where component = 'local_filemanager' and filesize != 0");
foreach ($records as $record){
    $path = file_encode_url($CFG->wwwroot.'/local/filemanager/image.php?img=',$record->filename);
    $my_images .= '<h2>Image name: '.$record->filename.'</h2>';
    $my_images .= "<br /><img src=\"$path\" alt=\"\" />";
}


echo $OUTPUT->header();
echo $my_images;
echo $OUTPUT->footer();
