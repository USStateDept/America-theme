<?php
/**
  * This file adds the custom publicaton post type single post template to the America.gov Theme.
  *
  * @author Office of Design, Bureau of International Information Programs
  * @package America.gov
  * @subpackage Customizations
  */

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

remove_action( 'genesis_entry_header',   'genesis_do_post_title' );
remove_action( 'genesis_entry_content',  'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content',  'genesis_do_post_content' );

//* Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Remove the comments template
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

// add_action( 'genesis_entry_header', 'amgov_pubs_featured_image' );
add_action( 'genesis_entry_content', 'amgov_pubs_do_post_content' );
add_action( 'genesis_after_loop', 'amgov_pubs_do_related_content' );


function amgov_pubs_do_post_content() {
  global $post;
  
  amgov_pubs_featured_image(); 
  echo '<div class="publication-content">';
  genesis_do_post_title();
  genesis_do_post_content();  // need to  add tags
  amgov_pubs_add_downloadables();
  amggov_pubs_show_tags();
  echo '</div>';
}

function amgov_pubs_featured_image() {
  $args = array(
    'format' => 'url',
    'size' => 'publication',
    'num' => 0
  );
  if ( $image = genesis_get_image($args) ) {
    printf( '<div class="publication-featured-image"><img src="%s" alt="%s" /></div>', $image, the_title_attribute( 'echo=0' ) );
  }
}


function amgov_pubs_size( $fn ) {
    $bytes = sprintf('%u', filesize($fn));
    if ($bytes > 0) {
        $unit = intval(log($bytes, 1024));
        $units = array('B', 'KB', 'MB', 'GB');

        if (array_key_exists($unit, $units) === true) {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }
    }
    return $bytes;
}

function amgov_pubs_get_path( $fn ) {
  // get the first part of the upload base_dir and the last part of the file url
  // concatenate together to get the path to the file on disk
  $file_start = strpos( $fn, 'uploads' );
  $file_path = substr( $fn, $file_start );
  $base_dir = wp_upload_dir()['basedir'];
  $dir_start = strpos( $base_dir, 'uploads' );
  $dir_path = substr( $base_dir, 0, $dir_start );
  $full_path = $dir_path . $file_path;

  return  $full_path;
}

function amgov_pubs_get_values( $files ) {
  $formats = array();

  foreach ( $files as $file ) {
    $format = $file['format'];
    if( count($format) ) {
      $lang = $file['language'];
     if( isset($formats[$format]) ) {
        $formats[$format][$lang] = $file['file'];
      } else {
        $formats[$format] = array();
        $formats[$format][$lang] = $file['file'];
     }
    }
  }
  return $formats;
}

function amgov_pubs_add_downloadables() {
  $files = get_field( 'attach_files' );  
  
  if( $files ) {
    $formats = amgov_pubs_get_values( $files );
  
    echo '<div class="publication-container">';

    foreach( $formats as $format => $values ) {
      echo '<div class="publication-row">'; 
      echo '<div class="publication-column-header">' . $format . '</div>';
      foreach( $values as $lang => $path ) {
        $fn =  amgov_pubs_get_path( $path );
        $size = '<span>(' . amgov_pubs_size( $fn ) . ')</span>';

        echo '<div class="publication-column"><a href="' . $path . '" target="_NEW">' . $lang . '</a>  ' . $size . '</div>';
      }
      echo '</div>';
    }
   echo '</div>';
  }
}

function amggov_pubs_show_tags() {
  $posttags = get_the_tags();
  if ( $posttags ) {
    echo '<div class="publication-tags">';
    foreach( $posttags as $tag ) {
      echo $tag->name;
      if( end($posttags) !== $tag ) {
        echo ', '; 
      }
    }
    echo '</div>';
  }
}


function amgov_pubs_get_categories() {
  $cats = array();
  
  $categories = get_the_category();
  foreach( $categories as $category ) {
    $cats[] = $category->cat_ID;
  }

  return implode( ',', $cats );
}


function amgov_pubs_get_related() {
  $related = array();
  
  if( have_rows('related_pubs') ){

    while( have_rows('related_pubs') ) {
      the_row(); 
      $related[] = get_sub_field('related_pub');
    }
  }

  return $related;
}

function amgov_pubs_do_related_content() {
  $pubs_in_cat = array();
  
  $acf_related_pubs = amgov_pubs_get_related();
  $post_cats = amgov_pubs_get_categories ();

  $num_to_fetch = 6 - count( $acf_related_pubs );
 
  // if 6 related pubs were not entered, pull the remaining from the same category
  if( $num_to_fetch ) {
      $args = array (
        'post_type' => 'publication',
        'category'  => $post_cats
      );
      $pubs_in_cat = get_posts( $args );
  }
  $pubs = array_merge ($acf_related_pubs, $pubs_in_cat);
  
  // remove duplicates
  $final  = array();
  foreach ( $pubs as $current ) {
      if ( ! in_array($current, $final) ) {
          $final[] = $current;
      }
  }
  
  echo '<h3 class="entry-title">Suggested for you</h3>';  

  // render to screen
  foreach ( $final as $f ) {
     // amgov_pubs_display( $f );
     ?>
     <article class="related-pubs" id="post-<?php $f->ID ?>">
      <div class="entry-content">
        <div class="publication-featured-image">
           <?php 
           $url = get_permalink( $f->ID );
           $image = get_the_post_thumbnail( $f->ID, 'post-thumbnail', array( 'alt' => esc_attr( get_the_title($f->ID) ) ));
           echo sprintf( '<a href="%s" rel="bookmark">', esc_url( $url ) ) . $image . '</a>';
           ?>
        </div>
        <div class="publication-content">
          <h2 class="entry-title"><a href="<?php echo esc_url( $url ) ?>" rel="bookmark"><?php echo $f->post_title ?></a></h2>
           <?php if( taxonomy_exists('publication_type') ) { 
                    $formats = get_the_term_list( $f->ID, 'publication_type', '<div><span class="aasf-label">Format:</span> ', ', ', '</div>' );
                    if( $formats ) {
                      echo $formats;
                    }
                  } 
                  echo $f->post_excerpt; 
                  // $cats = get_the_term_list( $post->ID, 'category', '<div><span class="aasf-label">Subject:</span> ', ', ', '</div>' );
                  // if( $cats ) { 
                  //     echo $cats;
                  // }
              ?>
        </div>
      </div>
     </article>
     <?php
  }
}


//* Run the Genesis loop
genesis();