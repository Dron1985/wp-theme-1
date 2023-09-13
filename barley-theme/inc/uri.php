<?php
function barley_theme_images_uri($filename) {
    return sprintf('%s/dist/images/%s', get_template_directory_uri(), $filename);
}
function barley_theme_get_css_uri($filename) {
    return sprintf('%s/dist/css/%s.min.css', get_template_directory_uri(), $filename);
}
function barley_theme_get_js_uri($filename) {
    return sprintf('%s/dist/js/%s.min.js', get_template_directory_uri(), $filename);
}
