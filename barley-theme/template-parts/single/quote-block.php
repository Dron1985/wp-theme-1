<?php $quote = get_field('quote_field');
if (!empty($quote)) : ?>
    <div class="quote-holder">
        <?php get_template_part('template-parts/svg/quote'); ?>
        <div class="quote">
            <div class="title">
                <?php if (isset($quote['author']) || isset($quote['position'])) : ?>
                    <div class="title">
                        <?php echo (isset($quote['author']) && !empty($quote['author'])) ? '<h4>'.$quote['author'].'</h4>' : ''; ?>
                        <?php echo (isset($quote['position']) && !empty($quote['position'])) ? '<p>'.$quote['position'].'</p>' : ''; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (isset($quote['text']) && !empty($quote['text'])) : ?>
                <blockquote>
                    <?php echo $quote['text']; ?>
                </blockquote>
            <?php endif; ?>
        </div>
    </div>
    <!--quote-holder-->
<?php endif; ?>