<?
/** when supplied with a video name, logs the record 
silently fail on all errors without feedback
**/

require 'lib.php';
require 'config.php';

/** displays 0 records and exits the process */
function display_fail() {
	echo 0;
	die;
}

if( !isset( $_GET['v'] ) ) {
	// no video passed, nothing to log
	display_fail();
}

// we only want the file name without extension as the same video could have multiple extensions
// run through parse url to clean up any unexpected path arguments
list( $video_name ) = explode( '.', basename( parse_url( $_GET['v'], PHP_URL_PATH ) ) );

if( empty( $video_name ) ){
	display_fail();
}

try {
	$db = new SimpleDB( $db['dsn'], $db['username'], $db['password'] );

	// The date could be calculated in the database using NOW() in the sql or ON INSERT UPDATE TIMESTAMP in the column definition
	// I prefer always using php to calculate the date to avoid issues in cases where the sql server is in a different timezone
	// an upgrade would also store IP/SESSION_ID or other identifier to allow tracking of unique views
	$video = array( 'file' => $video_name, 'stamp' => SimpleDb::sqlDateTime() );
	$db->insert( 'video_views', $video );

} catch( Exception $e ) {
	//something went wrong with the db connection or insert
	//upgrade would log error for future debug
	display_fail();
}

$sql = 'SELECT COUNT(*) AS count FROM video_views WHERE file = :video';

$results = $db->select( $sql, array( ':video' => $video_name ) );

if( count( $results ) == 0 ) {
	//we should have results, so if there are none, that indicates another error
	display_fail();
}

//display the number of views the video has had
echo $results[0]['count'];

