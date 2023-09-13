<?php

echo '<ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">';
echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
echo '<a itemprop="item" href="' . get_bloginfo('url') . '" title="home"><span itemprop="name">Home</span><meta itemprop="position" content="1" /></a>';
echo '</li>';
$current_type = get_post_type();
if ($current_type == 'page') {
    $parents = get_post_ancestors(get_the_ID());
    $count = count($parents)+1;
    if ($parents) {
        for ($i = count($parents) - 1; $i >= 0; $i--) {
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a itemprop="item" href="' . get_permalink($parents[$i]) . '" title="' . get_the_title($parents[$i]) . '"><span itemprop="name">' . get_the_title($parents[$i]) . '</span><meta itemprop="position" content="'.$i.'" /></a>';
            echo '</li>';
        }
    }

    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<span itemprop="name">' . get_the_title() . '</span><meta itemprop="position" content="'.$count.'" />';
    echo '</li>';
} else {
    if ($current_type == 'post' || $current_type == 'program' || $current_type == 'success-story') {
        $insights = get_option('page_for_posts');
        $title = get_the_title($insights);
        $url = get_the_permalink($insights);
    } else {
        $current_obj = get_post_type_object($current_type);
        $title = $current_obj->labels->name;
        $url = get_post_type_archive_link($current_type);
    }

    $current_taxonomies = get_object_taxonomies($current_type);

    if ($current_taxonomies && $current_taxonomies[0] != 'programs-category' && $current_taxonomies[0] != 'category') {
        $current_terms = get_the_terms(get_the_ID(), $current_taxonomies[0]);

        if ($current_terms) {
            $current_term = array_shift($current_terms);

            $page_link = add_query_arg( array(
                $current_term->taxonomy => $current_term->slug
            ), $url);

            if ($current_term->term_id != 1) {
                echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a itemprop="item" href="' . $page_link . '" title="' . $current_term->name . '"><span itemprop="name">' . $current_term->name . '</span><meta itemprop="position" content="2" /></a>';
                echo '</li>';
            }
        }
    }

    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<span itemprop="name">' . $title . '</span><meta itemprop="position" content="3" />';
    echo '</li>';

}

echo '</ul>';