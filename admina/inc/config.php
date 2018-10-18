<?php
date_default_timezone_set('Asia/Jakarta');
ini_set( "display_errors", true );
define( "HOST", "localhost" );
//nama database
define( "DATABASE_NAME", "feeder_free_production" );
define( "DB_USERNAME", "root" );

define( "PORT", 3306);
//password mysql
define( "DB_PASSWORD", "" );
//dir admin
define( "DIR_ADMIN", "feeder-production/admina/");
//main directory
define( "DIR_MAIN", "feeder-production/");

define ('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']."/".DIR_MAIN);

define('DB_CHARACSET', 'utf8');

require_once ('Database.php');
require_once ('Datatable.php');
require_once ('My_pagination.php');
require_once ('url.php');
require_once ('DTable.php');
require_once ('Table_Clean.php');

$db=new Database("mysql");

//postgre
//$pgs=new Database("pgsql");

//pagination
$pg=New My_pagination();
$dtable = new TableData();

$new_table = new DTable("mysql");
$clean = new Table_Clean("mysql");

function handleException( $exception ) {
  echo  $exception->getMessage();
}

set_exception_handler( 'handleException' );


?>
