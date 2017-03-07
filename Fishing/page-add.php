<?php
    /*
    Template Name: Submission Form
    */
?>
<?php
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {
 
    if (isset ($_POST['title'])) {
        $title =  $_POST['title'];
    } else {
        echo 'Please enter a license number';
    }
    if (isset ($_POST['expiration'])) {
        $expiration = $_POST['expiration'];
    } else {
        echo 'Please enter expiration date';
    }
 
    $tags = $_POST['post_tags'];
    $additional = $_POST['additional'];
 
    $type = trim($_POST['Type']);
    $post = array(
        'post_title'    => $title,
        'post_content'  => $expiration,
        'post_status'   => 'publish',
        'tax_input'    => array($type),
        'comment_status' => 'closed',
        'post_author' => '2',
        );
    
    $post_id = wp_insert_post($post);
    wp_set_post_terms($post_id,$type,'Type',true);
    add_post_meta($post_id, 'metatestimage', $image, false);
 
    if (!function_exists('wp_generate_attachment_metadata')){
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    }
    if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                return "upload error : " . $_FILES[$file]['error'];
            }
                $attach_id = media_handle_upload( $file, $post_id );
            }   
    }
    if ($attach_id > 0){
        update_post_meta($post_id,'_thumbnail_id',$attach_id);
    }
    wp_redirect( home_url('/view/') );
    exit();
}
 
?>
<?php get_header() ?>
 
<div id="container">
    <div id="map"></div>
    <div id="content" role="main">
        <form id="new_post" name="new_post" class="post_work" method="post" enctype="multipart/form-data">
            <p>
                <label for="title">License number</label><br />
                <input type="text" id="title" class="required" value="" tabindex="1" size="20" name="title" />
            </p>
            <p>
                <label for="expiration">Expiration date</label><br />
                <input type="text" id="expiration" class="required" tabindex="1" size="20" name="expiration">
            </p>
 
            <p>
                <label for="image">Image of your license</label>
                <input type="file" value="" id="file" tabindex="20" name="file" />
            </p>
                
            <input type="hidden" name="post_type" id="post_type" value="domande" />
            <input type="hidden" name="action" value="post" />
 
            <p><input type="submit" value="Submit" tabindex="6" id="submit" name="submit" />
            </p>
                
            <p>
                Latitude<br />
                <input type="text" size="20" maxlength="50" name="displayLat" id="displayLat" value="">
            <br />
                Longitude<br />
                <input type="text" size="20" maxlength="50" name="displayLong" id="displayLong">
            <br />
            </p>
                
           <?php wp_nonce_field( 'new-post' ); ?>
        </form>
 <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAChPtF6RJfEKNQ5BZhr8dJVuig3jywtkQ"></script>

        <script>
            var map = null;
                  function initMap() {
        // Create a map object and specify the DOM element for display.
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          scrollwheel: false,
          zoom: 8
        });
                      google.maps.event.addListener(map, 'click', function(event) {
            document.getElementById('displayLat').value = event.latLng.lat();
            document.getElementById('displayLong').value = event.latLng.lng(); 
            });
      }
                    
            
            initMap();
        </script>
 
    </div>
</div>

<?php get_footer(); ?>