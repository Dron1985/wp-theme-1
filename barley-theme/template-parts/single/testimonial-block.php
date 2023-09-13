<?php
$testimonials = get_sub_field('testimonials');
if (!empty($testimonials)) : ?>
    <div id="testimonials" class="clients-testimonials">
        <div class="container">
            <?php if (get_sub_field('title')) : ?>
                <div class="h2"><?php echo get_sub_field('title'); ?></div>
            <?php endif; ?>
            <?php if (is_singular('capability')) : ?>
                <div class="clients-testimonials-print">
                    <?php foreach ($testimonials as $testimonial) : ?>
                        <div class="item">
                            <div class="holder">
                                <div class="info">
                                    <div class="heading">
                                        <?php if (isset($testimonial['logo']['sizes'])) : ?>
                                            <div class="logo">
                                                <img src="<?php echo $testimonial['logo']['sizes']['thumbnail']; ?>" alt="<?php echo $testimonial['logo']['alt']; ?>">
                                            </div>
                                        <?php endif; ?>
                                        <div class="wrap">
                                            <?php if (isset($testimonial['subtitle']) && !empty($testimonial['subtitle'])) : ?>
                                                <p><?php echo $testimonial['subtitle']; ?></p>
                                            <?php endif; ?>
                                            <?php if (isset($testimonial['title']) && !empty($testimonial['title'])) : ?>
                                                <h3><?php echo $testimonial['title']; ?></h3>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if (isset($testimonial['quote']) && !empty($testimonial['quote'])) : ?>
                                        <blockquote>
                                            <?php echo $testimonial['quote']; ?>
                                        </blockquote>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="slider-holder">
                <div class="clients-testimonials-slider">
                    <?php foreach ($testimonials as $testimonial) : ?>
                        <div class="item">
                            <div class="holder">
                                <?php if (isset($testimonial['image']['sizes'])) : ?>
                                    <div class="photo-wrap">
                                        <?php get_template_part('template-parts/svg/quote'); ?>
                                        <div class="photo" style="background-image: url('<?php echo $testimonial['image']['sizes']['medium']; ?>')"></div>
                                    </div>
                                <?php endif; ?>
                                <div class="info">
                                    <div class="heading">
                                        <?php if (isset($testimonial['logo']['sizes'])) : ?>
                                            <div class="logo">
                                                <img src="<?php echo $testimonial['logo']['sizes']['thumbnail']; ?>" alt="<?php echo $testimonial['logo']['alt']; ?>">
                                            </div>
                                        <?php endif; ?>
                                        <div class="wrap">
                                            <?php if (isset($testimonial['subtitle']) && !empty($testimonial['subtitle'])) : ?>
                                                <p><?php echo $testimonial['subtitle']; ?></p>
                                            <?php endif; ?>
                                            <?php if (isset($testimonial['title']) && !empty($testimonial['title'])) : ?>
                                                <h3><?php echo $testimonial['title']; ?></h3>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if (isset($testimonial['quote']) && !empty($testimonial['quote'])) : ?>
                                        <blockquote>
                                            <?php echo $testimonial['quote']; ?>
                                        </blockquote>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="testimonials-slider-nav"></div>
            </div>
            <?php if (get_sub_field('description')) : ?>
                <div class="disclaimer">
                    <?php echo get_sub_field('description'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!--Testimonials-->
<?php endif; ?>