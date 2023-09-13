<?php $about = get_field('home_about_field');
if (!empty($about)) : ?>
    <div class="info-image-section">
        <?php if (isset($about['bg_img']['sizes'])) : ?>
            <div class="image" style="background-image: url(<?php echo $about['bg_img']['sizes']['full-hd']; ?>)"></div>
        <?php endif; ?>
        <div class="info">
            <div class="container">
                <div class="holder">
                    <?php if (isset($about['subtitle']) || isset($about['title'])) : ?>
                        <h2>
                            <?php if (isset($about['subtitle']) && !empty($about['subtitle'])) : ?>
                                <span class="subtitle"><?php echo $about['subtitle']; ?></span>
                            <?php endif; ?>
                            <?php echo (!empty($about['title'])) ? $about['title'] : ''; ?>
                        </h2>
                    <?php endif; ?>

                    <div class="description">
                        <?php echo (isset($about['description']) && !empty($about['description'])) ? $about['description'] : ''; ?>

                        <?php if (isset($about['button']['url']) && isset($about['button']['title']) && !empty($about['button']['title'])) :
                            $target = (isset($about['button']['target']) && !empty($about['button']['target'])) ? 'target="'. $about['button']['target'] .'"' : ''; ?>
                            <a href="<?php echo $about['button']['url']; ?>" class="button" <?php echo $target; ?>>
                                <?php echo $about['button']['title']; ?>
                                <?php set_query_var('color', 'white');
                                get_template_part('template-parts/svg/arrow-right-2'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--info-image-section-->
<?php endif; ?>