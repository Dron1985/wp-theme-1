<?php
$args = array(
    'post_type'  => 'jobs',
    'fields'     => 'all',
    'orderby'    => 'title',
    'order'      => 'ASC',
    'hide_empty' => true,
);
$positions = get_terms( array('job-position'), $args );
$locations = get_locations();
$link = get_post_type_archive_link('jobs'); ?>
<div class="open-positions">
    <div class="container">
        <?php if (!empty($positions) || !empty($locations)) : ?>
            <div class="filter-for-listing">
                <form id="jobs-filter" action="#" novalidate="">
                    <div class="select-holder">
                        <?php if (!empty($positions)) : ?>
                            <div class="wrap">
                                <label><?php echo __('Position', 'barley-theme'); ?></label>
                                <select name="position" id="position">
                                    <option value="all"><?php echo __('All Positions', 'barley-theme'); ?></option>
                                    <?php foreach ($positions as $position) :
                                        $selected = (!empty(get_query_var('position')) && get_query_var('position') == $position->slug ) ? 'selected' : ''; ?>
                                        <option value="<?php echo $position->slug; ?>" <?php echo $selected; ?>><?php echo $position->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($locations)) : ?>
                            <div class="wrap">
                                <label><?php echo __('Location', 'barley-theme'); ?></label>
                                <select name="location" id="location">
                                    <option value="all"><?php echo __('All Locations', 'barley-theme'); ?></option>
                                    <?php foreach ($locations as $location) :
                                        $selected = (!empty(get_query_var('location')) && get_query_var('location') == $location->post_name ) ? 'selected' : ''; ?>
                                        <option value="<?php echo $location->ID; ?>" <?php echo $selected; ?>><?php echo $location->post_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="wrap">
                            <button class="button" type="submit"><?php echo __('Apply Filters', 'barley-theme'); ?>
                                <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
        <div class="search-results-list">
            <?php if (have_posts()) :
                while (have_posts()) : the_post();
                    global $post;
                    set_query_var('post_id', $post->ID);
                    get_template_part('template-parts/archive/item-job');
                endwhile;
            else:
                echo '<span class="no-results">No Results found</span>';
            endif; ?>
        </div>
        <?php global $wp_query;
        if ($wp_query->max_num_pages > 1) : ?>
            <div class="pagination @@alter-class">
                <?php pagination(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!--open-positions-->