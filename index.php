<?php
/*
 *File created by Abdul Bashet
 *Email: a_bashet@yahoo.com
 *
 *This file is able to demonestrate a file manager.
 */

require('../../config.php');
require_once("$CFG->dirroot/local/filemanager/uploaderform.php");

require_login();
if (isguestuser()) {
    die();
}

$returnurl = optional_param('returnurl', '', PARAM_URL);

if (empty($returnurl)) {
    $returnurl = new moodle_url('/local/filemanager/');
}

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_url('/local/filemanager/');
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_filemanager'));
$PAGE->set_heading(get_string('pluginname', 'local_filemanager'));
$PAGE->set_pagelayout('mydashboard');
$PAGE->navbar->add(get_string('pluginname', 'local_filemanager'));


$data = new stdClass();
$data->returnurl = $returnurl;
$options = array('subdirs'=>0, 'maxbytes'=>$CFG->userquota, 'maxfiles'=>10, 'accepted_types'=>array('*.png', '*.jpg', '*.gif','*.jpeg'));
file_prepare_standard_filemanager($data, 'files', $options, $context, 'local_filemanager', 'images', '1');

$mform = new upload_image_form(null, array('data'=>$data, 'options'=>$options));

if ($mform->is_cancelled()) {
    redirect($returnurl);
} else if ($formdata = $mform->get_data()) {
    $formdata = file_postupdate_standard_filemanager($formdata, 'files', $options, $context, 'local_filemanager', 'images', '1');
    redirect($returnurl);
}



echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
