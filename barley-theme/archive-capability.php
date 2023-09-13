<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package barley-theme
 */

get_header();
$args = array(
    'post_type'  => 'capability',
    'fields'     => 'all',
    'orderby'    => 'title',
    'order'      => 'ASC',
    'hide_empty' => true,
);
$categories = get_terms( array('capability-category'), $args );
$fields = get_field('fields_capabilities', 'option');
$field = $fields['hero_field']; ?>
    <main class="main">
        <?php get_template_part('template-parts/global/hero-section'); ?>
        <div class="practice-areas">
            <div class="container">
                <div class="holder sticky-element-wrap">
                    <aside class="practice-areas-filter sticky-element">
                        <div class="accordion holder-for-sticky">
                            <?php foreach ($categories as $category):
                                if ($field['hide_sidebar'] == true) :
                                    $capabilities = get_capability_by_term($category->slug); ?>
                                    <div class="accordion-item">
                                        <h5><a href="#"><?php echo $category->name; ?></a></h5>
                                        <div class="accordion-info">
                                            <ul class="jcf-scrollable">
                                                <?php foreach ($capabilities as $capability) : ?>
                                                    <li><a href="#"><?php echo get_the_title($capability); ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="accordion-item">
                                        <h5><?php echo $category->name; ?></h5>
                                    </div>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </aside>
                    <!--filter-->
                    <div class="practice-areas-content">
                        <?php foreach ($categories as $category):
                            $capabilities = get_capability_by_term($category->slug); ?>
                            <div class="practice-area-section" id="<?php echo $category->slug; ?>">
                                <h2><?php echo $category->name; ?></h2>
                                <div class="practice-areas-list">
                                    <?php foreach ($capabilities as $capability) :
                                        $image = get_featured_img_info('medium', $capability->ID);
                                        $areas = get_areas_list($capability->ID); ?>
                                        <div class="item">
                                            <?php if (isset($image['src'])) : ?>
                                                <div class="image" style="background-image: url('<?php echo $image['src'] ?>')"></div>
                                            <?php endif; ?>
                                            <div class="description">
                                                <div class="info">
                                                    <h4><?php echo get_the_title($capability->ID); ?></h4>
                                                    <?php echo (get_the_excerpt($capability->ID)) ? '<p>'.get_the_excerpt($capability->ID).'</p>' : ''; ?>
                                                    <a href="<?php echo get_the_permalink($capability->ID); ?>" class="button">
                                                        <?php echo __('Learn More', 'barley-theme'); ?>
                                                        <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
                                                    </a>
                                                </div>
                                                <?php if (isset($areas['focus_areas']) && !empty($areas['focus_areas']) && $field['show_focus_areas'] == true) : ?>
                                                    <div class="focus-areas content">
                                                        <h5><?php echo __('Focus Areas', 'barley-theme'); ?></h5>
                                                        <ul class="jcf-scrollable">
                                                            <?php foreach ($areas['focus_areas'] as $item) : ?>
                                                                <li><a href="<?php echo get_the_permalink($item['id']); ?>"><?php echo $item['title']; ?></a></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <!--practice-areas-list-->
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!--listing-->
                </div>
            </div>
        </div>
    </main>
<?php get_footer();