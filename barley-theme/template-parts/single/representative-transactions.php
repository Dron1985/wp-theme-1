<?php
if (is_singular('professionals')) {
    $fields = get_field('team_additional_info');
    $field  = $fields['transactions_field'];
} elseif (is_singular('capability')) {
    $field  = get_sub_field('transactions_field');
} else {
    $field  = get_field('transactions_field');
}

if (!empty($field['info']) || empty($field['gallery'])) : ?>
    <section id="representative" class="representative-transactions">
        <div class="container">
            <div class="heading">
                <?php if (isset($field['title']) && !empty($field['title'])) : ?>
                    <h2><?php echo $field['title']; ?></h2>
                <?php endif; ?>
                <?php if (isset($field['pdf_file']['url'])) : ?>
                    <a href="<?php echo $field['pdf_file']['url']; ?>" class="back-link" target="_blank">
                        <?php get_template_part('template-parts/svg/arrow-left'); ?>
                        <span><?php echo __('Download PDF', 'barley-theme'); ?></span>
                    </a>
                <?php endif; ?>
            </div>
            <?php if (isset($field['info']) && !empty($field['info'])) : ?>
                <div class="info-list">
                    <?php foreach ($field['info'] as $info) : ?>
                        <div class="item">
                            <div class="ico">
                                <?php get_template_part('template-parts/svg/checkbox'); ?>
                            </div>
                            <?php if (isset($info['image']['sizes'])) : ?>
                                <img src="<?php echo $info['image']['sizes']['medium_large']; ?>" alt="<?php echo $info['image']['alt']; ?>">
                            <?php endif; ?>
                            <?php echo $info['description']; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($field['gallery']) && !empty($field['gallery'])) : ?>
                <div class="representative-transactions-slider">
                    <?php foreach ($field['gallery'] as $img) : ?>
                        <div class="item">
                            <img src="<?php echo $img['sizes']['medium_large']; ?>" alt="<?php echo $img['alt']; ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!--representative-transactions-->
<?php endif; ?>