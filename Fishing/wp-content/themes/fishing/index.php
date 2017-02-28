<?php
    get_header();
?>

<h1>Fishing License</h1>
<?php
if (have_posts()) {
    while(have_posts()){
        the_post();
        the_content();
        
    }
}
?>

<?php
    get_footer();
?>