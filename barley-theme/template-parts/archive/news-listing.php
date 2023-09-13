<?php
$args = array(
    'post_type'  => 'post',
    'fields'     => 'all',
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => true,
);
$content_types = get_terms( array('category'), $args );
$topics        = get_practice_areas();
$attorneys     = get_leadership_by_id();
$page_news     = get_option('page_for_posts');
$link          = get_the_permalink($page_news); ?>
<div class="latest-news">
    <div class="container">
        <div class="filter-for-listing">
            <form id="news-filter" action="#" novalidate="">
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
                                    $selected = (!empty(get_query_var('topic')) && get_query_var('topic') == $topic->post_name ) ? 'selected' : ''; ?>
                                    <option value="<?php echo $topic->post_name; ?>" <?php echo $selected; ?>><?php echo $topic->post_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($attorneys)) : ?>
                        <div class="wrap">
                            <label><?php echo __('Attorney', 'barley-theme'); ?></label>
                            <select name="attorney" id="attorney">
                                <option value="all"><?php echo __('All Attorneys', 'barley-theme'); ?></option>
                                <?php foreach ($attorneys as $attorney) :
                                    $selected = (!empty(get_query_var('attorney')) && get_query_var('attorney') == $attorney['slug'] ) ? 'selected' : ''; ?>
                                    <option value="<?php echo $attorney['slug']; ?>" <?php echo $selected; ?>><?php echo $attorney['title']; ?></option>
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
        <div class="news-grid">
            <div class="news-list">
                <?php if (have_posts()) :
                    $i = 1;
                    while (have_posts()) : the_post();
                        global $post;
                        if ($i == 7) {
                            echo '</div>';
                            get_template_part('template-parts/global/subscribe');
                            echo '<div class="news-list">';
                            $i = 0;
                        }

                        set_query_var('post_id', $post->ID);
                        get_template_part('template-parts/archive/item-news');
                        $i++;
                    endwhile;
                else:
                    echo '<span class="no-results">No Results found</span>';
                endif; ?>
            </div>
        </div>

        <?php global $wp_query;
        if ($wp_query->max_num_pages > 1) : ?>
            <div class="pagination top-indent">
                <?php pagination(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>