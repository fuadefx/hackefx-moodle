<?php  // Moodle configuration file

// If values are hardcoded in config.php, add config.php to .gitignore to avoid committing
// sensitive information to version control.

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = getenv('MOODLE_DOCKER_DBTYPE');
$CFG->dblibrary = 'native';
$CFG->dbhost    = getenv('MOODLE_DOCKER_DBHOST');  // Fixed: removed extra semicolon
$CFG->dbname    = getenv('MOODLE_DOCKER_DBNAME');
$CFG->dbuser    = getenv('MOODLE_DOCKER_DBUSER');
$CFG->dbpass    = getenv('MOODLE_DOCKER_DBPASS');
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => getenv('MOODLE_DOCKER_DBPORT'),
  'dbsocket' => '',
);

$CFG->sslproxy = false;
$host = getenv('MOODLE_DOCKER_WEB_HOST') ?: 'localhost';
$scheme = getenv('MOODLE_DOCKER_WEB_SCHEME') ?: 'http';
$port = getenv('MOODLE_DOCKER_WEB_PORT');

// Build wwwroot properly
if (!empty($port) && $port !== '80' && $port !== '443') {
    $CFG->wwwroot = "{$scheme}://{$host}:{$port}";
} else {
    $CFG->wwwroot = "{$scheme}://{$host}";
}

if ($scheme == 'https') {
    $CFG->sslproxy = true;
}

$CFG->dataroot  = '/var/www/moodledata';
$CFG->admin     = 'admin';
$CFG->directorypermissions = 0777;
$CFG->smtphosts = 'mailpit:1025';
$CFG->noreplyaddress = 'noreply@example.com';

require_once(__DIR__ . '/lib/setup.php');
