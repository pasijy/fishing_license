<?php
    /*
    Template Name: Testing Submission Form
    */
?>
<?php
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {
 
        if (isset ($_POST['title'])) {
            $title =  $_POST['title'];
        } else {
            echo 'Please enter a license number';
        }
        if (isset ($_POST['description'])) {
            $description = $_POST['description'];
        } else {
            echo 'Please enter an expiration date';
        }
 
        $tags = $_POST['post_tags'];
        $additional = $_POST['additional'];
 
        $type = trim($_POST['Type']);
        $post = array(
                'post_title'    => $title,
                'post_content'  => $description,
                'post_status'   => 'pending', 
                'tax_input'    => array( $type),
                'comment_status' => 'closed',
                'post_author' => '2'
 
        );
        $post_id = wp_insert_post($post);
        wp_set_post_terms($post_id,$type,'Type',true);
        
 
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
        <div id="content" role="main">
 
        <form id="new_post" name="new_post" class="post_work" method="post" enctype="multipart/form-data">
            <p>
                <label for="title">License number</label><br />
                <input type="text" id="title" class="required" value="" tabindex="1" size="20" name="title" />
            </p>
            <p>
                <label for="description">License expiration date</label><br />
                <input id="description" type="text" class="required" value="" tabindex="1" name="description" size="20">
            </p>
 
            <p>
                <label for="license">Add image of your license</label><br />
                <input type="file" value="" id="file" tabindex="20" name="file" />
            </p>
  

            <p><input type="submit" value="Submit" tabindex="6" id="submit" name="submit" />
            </p>
                        
            Lat 1
            <input type="text" size="20" maxlength="50" name="displayLat" id="displayLat" value="">
            <br />
            Long 1
            <input type="text" size="20" maxlength="50" name="displayLong" id="displayLong">
            <br />
            
            <?php wp_nonce_field( 'new-post' ); ?>
        </form>
 
        <script>
            var multi_selector = new MultiSelector( document.getElementById( 'attachment_list' ), 8 );
            multi_selector.addElement( document.getElementById( 'attachment' ) );
                            
            google.maps.event.addListener(map, 'click', function(event) {
            document.getElementById('displayLat').value = event.latLng.lat();
            document.getElementById('displayLong').value = event.latLng.lng(); 
            });
            [huge_it_maps id="1"]
        </script>
 
        </div>
    </div>
 
<?php get_footer(); ?>