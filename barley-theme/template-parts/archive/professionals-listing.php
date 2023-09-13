<?php
$args = array(
    'post_type'  => 'professionals',
    'fields'     => 'all',
    'orderby'    => 'title',
    'order'      => 'ASC',
    'hide_empty' => true,
);
$schools        = get_terms(array('category-school'), $args);
$colleges       = get_terms(array('category-college'), $args);
$positions      = get_positions();
$practice_areas = get_practice_areas();
$offices        = get_locations();
$link = get_post_type_archive_link('professionals'); ?>

<section class="professionals">
    <div class="container">
        <div class="filter-for-listing">
            <form id="professionals-filter" action="#" novalidate="">
                <div class="select-holder">
                    <div class="wrap">
                        <label for="name"><?php echo __('Search by Name', ''); ?></label>
                        <input id="name" name="name" type="text">
                    </div>
                    <?php if (!empty($offices)) : ?>
                        <div class="wrap">
                            <label><?php echo __('Office', 'barley-theme'); ?></label>
                            <select name="office" id="office">
                                <option value="all"><?php echo __('All Offices', 'barley-theme'); ?></option>
                                <?php foreach ($offices as $location) :
                                    $selected = (!empty(get_query_var('location')) && get_query_var('location') == $location->post_name ) ? 'selected' : ''; ?>
                                    <option value="<?php echo $location->ID; ?>" <?php echo $selected; ?>><?php echo $location->post_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($positions)) : ?>
                        <div class="wrap">
                            <label><?php echo __('Position', 'barley-theme'); ?></label>
                            <select name="position" id="position">
                                <option value="all"><?php echo __('All Positions', 'barley-theme'); ?></option>
                                <?php foreach ($positions as $position) :
                                    $selected = (!empty(get_query_var('position')) && get_query_var('position') == $position ) ? 'selected' : ''; ?>
                                    <option value="<?php echo $position; ?>" <?php echo $selected; ?>><?php echo $position; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($practice_areas)) : ?>
                        <div class="wrap">
                            <label><?php echo __('Practice Areas', 'barley-theme'); ?></label>
                            <select name="practice-area" id="practice-area">
                                <option value="all"><?php echo __('All Practice Areas', 'barley-theme'); ?></option>
                                <?php foreach ($practice_areas as $item) :
                                    $selected = (!empty(get_query_var('practice-area')) && get_query_var('practice-area') == $item->post_name ) ? 'selected' : ''; ?>
                                    <option value="<?php echo $item->post_name; ?>" <?php echo $selected; ?>><?php echo $item->post_title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="add-filters">
                    <a href="#" class="add-more"><span><?php echo __('Select Education', 'barley-theme'); ?></span></a>
                    <div class="add-filters-holder">
                        <div class="select-holder">
                            <?php if (!empty($schools)) : ?>
                                <div class="wrap">
                                    <label><?php echo __('Law School', 'barley-theme'); ?></label>
                                    <select name="law-school" id="law-school">
                                        <option value="all"><?php echo __('All Law Schools', 'barley-theme'); ?></option>
                                        <?php foreach ($schools as $school) :
                                            $selected = (!empty(get_query_var('position')) && get_query_var('position') == $school->slug ) ? 'selected' : ''; ?>
                                            <option value="<?php echo $school->slug; ?>" <?php echo $selected; ?>><?php echo $school->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($colleges)) : ?>
                                <div class="wrap">
                                    <label><?php echo __('College', 'barley-theme'); ?></label>
                                    <select name="college" id="college">
                                        <option value="all"><?php echo __('All Colleges', 'barley-theme'); ?></option>
                                        <?php foreach ($colleges as $college) :
                                            $selected = (!empty(get_query_var('college')) && get_query_var('college') == $college->slug ) ? 'selected' : ''; ?>
                                            <option value="<?php echo $college->slug; ?>" <?php echo $selected; ?>><?php echo $college->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="actions-wrap">
                    <button class="button" type="submit">
                        <?php echo __('Search', 'barley-theme'); ?>
                        <?php get_template_part('template-parts/svg/btn-search'); ?>
                    </button>
                    <button type="reset" class="clear">
                        <span><?php echo __('Clear', 'barley-theme'); ?></span>
                    </button>
                </div>
            </form>
        </div>

        <div class="alphabet-filter">
            <label><?php echo __('Search by Last Name', 'barley-theme'); ?></label>
            <ul class="alphabet-list">
                <li><a href="#">A</a></li>
                <li><a href="#">B</a></li>
                <li><a href="#">C</a></li>
                <li><a href="#">D</a></li>
                <li><a href="#">E</a></li>
                <li><a href="#">F</a></li>
                <li><a href="#">G</a></li>
                <li><a href="#">H</a></li>
                <li><a href="#">I</a></li>
                <li><a href="#">J</a></li>
                <li><a href="#">K</a></li>
                <li><a href="#">L</a></li>
                <li><a href="#">M</a></li>
                <li><a href="#">N</a></li>
                <li><a href="#">O</a></li>
                <li><a href="#">P</a></li>
                <li><a href="#">Q</a></li>
                <li><a href="#">R</a></li>
                <li><a href="#">S</a></li>
                <li><a href="#">T</a></li>
                <li><a href="#">U</a></li>
                <li><a href="#">V</a></li>
                <li><a href="#">W</a></li>
                <li><a href="#">X</a></li>
                <li><a href="#">Y</a></li>
                <li><a href="#">Z</a></li>
            </ul>
            <div class="search-result"></div>
        </div>
        <div class="team-list">
            <?php if (have_posts()) :
                while (have_posts()) : the_post();
                    global $post;
                    set_query_var('post_id', $post->ID);
                    get_template_part('template-parts/archive/item-professional');
                endwhile;
            else:
                echo '<span class="no-results">No Results found</span>';
            endif; ?>
        </div>
        <div class="more">
            <?php global $wp_query;
            if ($wp_query->max_num_pages > 1) : ?>
                <button class="load-more" href="javascript:void(0)" data-paged="2" style="display: none">
                    <?php get_template_part('template-parts/svg/load-more'); ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>
<!--professionals-->