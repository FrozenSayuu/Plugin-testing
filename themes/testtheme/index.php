<?php
get_header();
?>

<h1>test</h1>

<?php
ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting (E_ALL);

echo do_shortcode('[search_bar_hello]');
echo do_shortcode('[comment_hello]');
?>

</div>