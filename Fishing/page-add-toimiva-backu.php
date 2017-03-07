<?php
    /*
    Template Name: Testing Submission Form
    */
?>
<?php
// Check if the form was submitted
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {
 
        // Do some minor form validation to make sure there is content
        if (isset ($_POST['title'])) {
                $title =  $_POST['title'];
        } else {
                echo 'Please enter a license number';
        }
        if (isset ($_POST['description'])) {
                $description = htmlentities(trim(stripcslashes($_POST['description'])));
    } else {
        echo 'Please enter the content';
        }
 
        $tags = $_POST['post_tags'];
        $additional = $_POST['additional'];
 
        // Add the content of the form to $post as an array
        $type = trim($_POST['Type']);
        $post = array(
                'post_title'    => $title,
                'post_content'  => $description,
                'post_category' =>   array($_POST['cat']),  // Usable for custom taxonomies too
                'post_status'   => 'pending',                     // Choose: publish, preview, future, etc.
                'tags_input'    => array($tags),
                'tax_input'    => array( $type),
                'comment_status' => 'closed',
                'post_author' => '2',
                'additional'    =>   $additional,
 
        );
        $post_id = wp_insert_post($post);
        wp_set_post_terms($post_id,$type,'Type',true);
        add_post_meta($post_id, 'metatestemail', $listingemail, false);
        add_post_meta($post_id, 'metatestphone', $listingphone, false);
        
 
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
                //and if you want to set that image as Post  then use:
                update_post_meta($post_id,'_thumbnail_id',$attach_id);
            }
    wp_redirect( home_url('/view/') ); // redirect to home page after submit
        exit();
}
 // end IF
 
?>
<?php get_header() ?>
 
            <div id="container">
                <div id="content" role="main">
                         <form id="new_post" name="new_post" class="post_work" method="post" enctype="multipart/form-data">
                                <p><label for="title">License number</label><br />
                                        <input type="text" id="title" class="required" value="" tabindex="1" size="20" name="title" />
                                </p>
                                <p><label for="description">Description</label><br />
                                        <textarea id="description" type="text" class="required" tabindex="3" name="description" cols="50" rows="6"></textarea>
                                </p>
 
                                <fieldset class="category">
                                        <label for="cat">Type</label>
                                        <?php wp_dropdown_categories( 'tab_index=10&taxonomy=category&hide_empty=0' ); ?>
                                </fieldset>
 
                                <fieldset class="listingemail">
                                        <label for="listingemail">Add image of you license</label>
                                        <input type="file" value="" id="file" tabindex="20" name="file" />
                                </fieldset>
 
                                <fieldset class="listingphone">
                                        <label for="listingphone">Additional info</label>
                                        <input type="text" value="" id="additional" tabindex="20" name="additional" />
                                </fieldset>
 
 
                            <p>Tags<input type="text" value="" tabindex="35" name="post_tags" id="post_tags" /></p>
                            <input type="hidden" name="post_type" id="post_type" value="domande" />
                            <input type="hidden" name="action" value="post" />
 
                            <p align="right"><input type="submit" value="Submit" tabindex="6" id="submit" name="submit" /></p>
                            
                            Lat 1<input type="text" size="20" maxlength="50" name="displayLat" id="displayLat" value="">
                            <br />
                            Long 1<input type="text" size="20" maxlength="50" name="displayLong" id="displayLong">
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
 
<!--SUBMIT POST END-->
 
                </div><!-- .content -->
            </div><!-- #container -->
 
<?php get_footer(); ?>