<?php

//* Untility function to get file size
function america_remote_filesize($url) {
	static $regex = '/^Content-Length: *+\K\d++$/im';

	if ( !$fp = @fopen( $url, 'rb' ) ) {
		return false;
	}

	if ( isset( $http_response_header ) && preg_match( $regex, implode( "\n", $http_response_header ), $matches ) ) {
		return (int)$matches[0];
	}

	return strlen(stream_get_contents($fp));
}


//* Utility function to format file size
function america_format_file_size( $size ) {
	if ( $size >= 1000000000 ) {
		$fileSize = round( $size / 1000000000, 1 ) . 'GB';
	} elseif ( $size >= 1000000 ) {
		$fileSize = round( $size / 1000000, 1) . 'MB';
	} elseif ( $size >= 1000 ){
		$fileSize = round( $size / 1000, 1 ) . 'KB';
	} else {
		$fileSize = $size . ' bytes';
	}
	return $fileSize;
}


// Sends errors/output to log file (wp-content/debug.log)
if (!function_exists('america_debug')) {
    function america_debug ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}