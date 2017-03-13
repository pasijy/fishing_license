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
 