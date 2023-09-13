<?php
$type = get_field('testimonials_type');
$testimonials = get_field('testimonials_field');
if (!empty($testimonials)) :
    $wrap_begin = ($type == 'type2') ? '<div class="quote-info-holder">' : '';
    $wrap_end   = ($type == 'type2') ? '</div>' : '';?>
    <div class="testimonials-slider-holder">
        <div class="container">
            <div class="testimonials-slider">
                <?php foreach ($testimonials as $testimonial) : ?>
                    <div class="item">
                        <div class="holder">
                            <?php if (isset($testimonial['image']['sizes'])) : ?>
                                <div class="photo" style="background-image: url('<?php echo $testimonial['image']['sizes']['large']; ?>')"></div>
                            <?php endif; ?>
                            <?php echo $wrap_begin; ?>

                                <?php if ($type == 'type2' && isset($testimonial['title']) && !empty($testimonial['title'])) : ?>
                                    <h2 class="big-title"><?php echo $testimonial['title']; ?></h2>
                                <?php endif; ?>

                                <div class="quote-holder">
                                    <?php get_template_part('template-parts/svg/quote'); ?>
                                    <div class="quote">
                                        <div class="title">
                                            <?php if ($type == 'type2' && isset($testimonial['subtitle']) && !empty($testimonial['subtitle'])) : ?>                                            <h4></h4>
                                                <div class="subtitle"><?php echo $testimonial['subtitle']; ?></div>
                                            <?php endif; ?>

                                            <?php if (isset($testimonial['author']) && !empty($testimonial['author'])) : ?>
                                                <h4><?php echo $testimonial['author']; ?></h4>
                                            <?php endif; ?>

                                            <?php echo ($type == 'type1' && !empty($testimonial['short_desc'])) ? $testimonial['short_desc'] : ''; ?>
                                        </div>
                                        <?php if (isset($testimonial['quote']) && !empty($testimonial['quote'])) : ?>
                                            <blockquote>
                                                <?php echo $testimonial['quote']; ?>
                                            </blockquote>
                                        <?php endif; ?>

                                        <?php if ($type == 'type2' && isset($testimonial['button']['url']) && isset($testimonial['button']['title']) && !empty($testimonial['button']['title'])) :
                                            $target = (isset($testimonial['button']['target']) && !empty($testimonial['button']['target'])) ? 'target="'. $testimonial['button']['target'] .'"' : ''; ?>
                                            <a href="<?php echo $testimonial['button']['url']; ?>" class="button white" <?php echo $target; ?>>
                                                <?php echo $testimonial['button']['title']; ?>
                                                <?php set_query_var('color', 'black');
                                                get_template_part('template-parts/svg/arrow-right-2'); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php echo $wrap_end; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="testimonials-slider-nav"></div>
        </div>
    </div>
    <!--testimonials-slider-->
<?php endif; ?>