<?php $newsletter= get_field('newsletter_field');
if (!empty($newsletter)) : ?>
    <div class="container">
        <div class="article popup-info newsletter-signup">
            <div class="subscribe-popup">
                <?php if (isset($newsletter['title']) && !empty($newsletter['title'])) : ?>
                    <h3><?php echo $newsletter['title']; ?></h3>
                <?php endif; ?>

                <?php if (isset($newsletter['newsletter_form']) && !empty($newsletter['newsletter_form'])) : ?>
                    <div class="form-holder">
                        <?php echo do_shortcode($newsletter['newsletter_form']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>