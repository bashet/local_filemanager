<?php

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class upload_image_form extends moodleform {
    function definition() {
        $mform = $this->_form;

        $data           = $this->_customdata['data'];
        $options        = $this->_customdata['options'];

        $mform->addElement('filemanager', 'files_filemanager', get_string('files'), null, $options);
        $mform->addElement('hidden', 'returnurl', $data->returnurl);

        $this->add_action_buttons(true, get_string('savechanges'));

        $this->set_data($data);
    }
    function validation($data, $files) {
        global $CFG;

        $errors = array();
        $draftitemid = $data['files_filemanager'];
        $fileinfo = file_get_draft_area_info($draftitemid);
        if ($fileinfo['filesize'] > $CFG->userquota) {
            $errors['files_filemanager'] = get_string('userquotalimit', 'error');
        }

        return $errors;
    }
}


