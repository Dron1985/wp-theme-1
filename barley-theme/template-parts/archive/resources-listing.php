<?php
$args = array(
    'post_type'  => 'resources',
    'fields'     => 'all',
    'orderby'    => 'title',
    'order'      => 'ASC',
    'hide_empty' => true,
);
$content_types = get_terms( array('content-type'), $args );
$topics = get_practice_areas();
$link = get_post_type_archive_link('resources'); ?>
<div class="resources">
    <div class="container">
        <div class="filter-for-listing">
            <form id="resources-filter" action="#" novalidate="">
                <div class="select-holder">
                    <?php if (!empty($content_types)) : ?>
                        <div class="wrap ">
                            <label><?php echo __('Content Type', 'barley-theme'); ?></label>
                            <select name="content-type" id="content-type">
                                <option value="all"><?php echo __('All Content Types', 'barley-theme'); ?></option>
                                <?php foreach ($content_types as $type) :
                                    $selected = (!empty(get_query_var('content-type')) && get_query_var('content-type') == $type->slug ) ? 'selected' : ''; ?>
                                    <option value="<?php echo $type->slug; ?>" <?php echo $selected; ?>><?php echo $type->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($topics)) : ?>
                        <div class="wrap">
                            <label><?php echo __('Topics', 'barley-theme'); ?></label>
                            <select name="topic" id="topic">
                                <option value="all"><?php echo __('All Topics', 'barley-theme'); ?></option>
                                <?php foreach ($topics as $topic) :
                                    $selected = (!empty(get_query_var('topic')) && get_query_var('topic') == $topic->post_name) ? 'selected' : ''; ?>
                                    <option value="<?php echo $topic->post_name; ?>" <?php echo $selected; ?>><?php echo $topic->post_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="keyword-holder">
                    <label for="keyword-input"><?php echo __('Keyword', 'barley-theme'); ?></label>
                    <div class="wrap">
                        <input id="keyword-input" name="keyword-input" type="text" placeholder="ex. Lawyer">
                        <button class="button" type="submit">
                            <?php echo __('Search', 'barley-theme'); ?>
                            <?php get_template_part('template-parts/svg/btn-search'); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="resources-list">
            <?php if (have_posts()) :
                while (have_posts()) : the_post();
                    global $post;
                    set_query_var('post_id', $post->ID);
                    get_template_part('template-parts/archive/item-resource');
                endwhile;
            else:
                echo '<span class="no-results">No Results found</span>';
            endif; ?>
        </div>
        <?php global $wp_query;
        if ($wp_query->max_num_pages > 1) : ?>
            <div class="pagination with-border">
                <?php pagination(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>