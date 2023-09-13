<?php
$topics = get_practice_areas();
$link = get_post_type_archive_link('events'); ?>
<div class="upcoming-events">
    <div class="container">
        <div class="filter-for-listing">
            <form id="events-filter" action="#" novalidate="">
                <div class="select-holder">
                    <?php if (!empty($topics)) : ?>
                        <div class="wrap">
                            <label><?php echo __('Topics', 'barley-theme'); ?></label>
                            <select name="topic" id="topic">
                                <option value="all"><?php echo __('All Topics', 'barley-theme'); ?></option>
                                <?php foreach ($topics as $topic) :
                                    $selected = (!empty(get_query_var('topic')) && get_query_var('topic') == $topic->post_name ) ? 'selected' : ''; ?>
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
        <div class="events-list">
            <?php if (have_posts()) :
                while (have_posts()) : the_post();
                    global $post;
                    set_query_var('post_id', $post->ID);
                    get_template_part('template-parts/archive/item-event');
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