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


function america_generate_srcset( $id, $names, $sizes ) {
	$markup = 'srcset="';
	$length = count( $names );
	$last = $length - 1;

  for ( $i=0; $i<$length; $i++ ) {
		if ( $i === $last ) {
			$markup .= wp_get_attachment_image_src($id, $names[$i], $icon = false)[0] . ' ' . $sizes[$i] . 'w" ' ;
		} else {
			$markup .= wp_get_attachment_image_src($id, $names[$i], $icon = false)[0] . ' ' . $sizes[$i] . 'w, ' ;
		}
	}

	return $markup;
}


function america_generate_sizes( $min_widths, $sizes ) {
	$markup = 'sizes="';
	$length = count( $min_widths );
	$last = $length - 1;

	for ( $i=0; $i<$length; $i++ ) {
		if ( $i === $last ) {
			$markup .= '(min-width:' . $min_widths[$i] . 'em) ' . $sizes[$i] . 'px, '. $sizes[$length] .'px"';
		} else {
			$markup .= '(min-width:' . $min_widths[$i] . 'em) ' . $sizes[$i] . 'px, ';
		}
	}

  return $markup;
}
