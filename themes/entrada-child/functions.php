<?php
// Child function start here
add_action('wp_enqueue_scripts', 'entrada_child_scripts', 12);

function entrada_child_scripts()
{
    if (is_rtl()) {
        wp_enqueue_style('entrada-child-rtl', get_template_directory_uri() . "/rtl.css");
    }
}

// Function to remove call to retina images. Delete to use retina images
function entrada_dequeue_script()
{
    wp_dequeue_script('entrada-retina-js');
}
add_action('wp_print_scripts', 'entrada_dequeue_script', 100);

// Add your custom functions below this line and above closing php tag! //
