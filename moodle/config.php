<?php  // Moodle configuration file

// If values are hardcoded in config.php, add config.php to .gitignore to avoid committing
// sensitive information to version control.

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = getenv('MOODLE_DOCKER_DBTYPE');
$CFG->dblibrary = 'native';
$CFG->dbhost    = getenv('MOODLE_DOCKER_DBHOST');;
$CFG->dbname    = getenv('MOODLE_DOCKER_DBNAME');
$CFG->dbuser    = getenv('MOODLE_DOCKER_DBUSER');
$CFG->dbpass    = getenv('MOODLE_DOCKER_DBPASS');
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => getenv('MOODLE_DOCKER_DBPORT'),
  'dbsocket' => '',
);

if (getenv('MOODLE_DOCKER_DBTYPE') === 'sqlsrv') {
    $CFG->dboptions['extrainfo'] = [
        // Disable Encryption for now on sqlsrv.
        // It is on by default from msodbcsql18.
        'Encrypt' => false,
    ];
}

if (empty($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = 'localhost';
}
if (strpos($_SERVER['HTTP_HOST'], '.gitpod.io') !== false) {
    // Gitpod.io deployment.
    $CFG->wwwroot   = 'https://' . $_SERVER['HTTP_HOST'];
    $CFG->sslproxy = true;
    // To avoid registration form.
    $CFG->site_is_public = false;
} else {
    // Docker deployment.
    $host = 'localhost';
    if (!empty(getenv('MOODLE_DOCKER_WEB_HOST'))) {
        $host = getenv('MOODLE_DOCKER_WEB_HOST');
    }
    $CFG->wwwroot   = "http://{$host}";
    $port = getenv('MOODLE_DOCKER_WEB_PORT');
    if (!empty($port)) {
        // Extract port in case the format is bind_ip:port.
        $parts = explode(':', $port);
        $port = end($parts);
        if ((string)(int)$port === (string)$port) { // Only if it's int value.
            $CFG->wwwroot .= ":{$port}";
        }
    }
}

$CFG->dataroot  = '/var/www/moodledata';
$CFG->admin     = 'admin';
$CFG->directorypermissions = 0777;
$CFG->smtphosts = 'mailpit:1025';
$CFG->noreplyaddress = 'noreply@example.com';

// Debug options - possible to be controlled by flag in future..
// $CFG->debug = (E_ALL); // DEBUG_DEVELOPER
// $CFG->debugdisplay = 1;
// $CFG->debugstringids = 1; // Add strings=1 to url to get string ids.
// $CFG->perfdebug = 15;
// $CFG->debugpageinfo = 1;
// $CFG->allowthemechangeonurl = 1;
// $CFG->passwordpolicy = 0;
// $CFG->cronclionly = 0;
// $CFG->pathtophp = '/usr/local/bin/php';

require_once(__DIR__ . '/lib/setup.php');
