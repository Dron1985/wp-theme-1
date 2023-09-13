<?php

class CustomMenuWalker extends Walker_Nav_Menu{

    function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = esc_attr($class_names);

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li class="object '.$class_names.'" ' . $id . $value.'>';

        $myurl = $item->url;

        $attributes  = ! empty( $item->attr_title ) ? ' title="'   . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="'  . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'     . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'    . esc_attr( $myurl            ) .'"' : '';

        $item_output = $args->before;

        $item_output .= '<a'. $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

        $item_output .= "\n";
    }

    function end_el(&$output, $item, $depth = 0, $args = Array()) {
        $output .=  '</li>';
    }

    function start_lvl(&$output, $depth = 0, $args = Array()) {
        $indent = str_repeat("\t", $depth);
        $output .= $indent.'<div class="sub-menu">';
        $output .= '<ul>';

    }

    function end_lvl(&$output, $depth = 0, $args = Array()) {
        $indent = str_repeat("\t", $depth);
        $output .= '</ul>';
        $output .= '</div>';
    }
}