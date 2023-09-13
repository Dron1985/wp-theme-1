<?php $field = get_field('home_info_field');
if (!empty($field)) : ?>
    <div class="info-boxes">
        <div class="container">
            <div class="holder">
                <?php foreach ($field as $item) : ?>
                    <div class="item">
                        <?php if (isset($item['image']['sizes'])) : ?>
                            <div class="photo" style="background-image: url('<?php echo $item['image']['sizes']['medium']; ?>')"></div>
                        <?php endif; ?>
                        <div class="info">
                            <?php if (isset($item['title']) && !empty($item['title'])) : ?>
                                <h3><?php echo $item['title']; ?></h3>
                            <?php endif; ?>
                            <?php echo (isset($item['description']) && !empty($item['description'])) ? $item['description'] : ''; ?>

                            <?php if (isset($item['button']['url']) && isset($item['button']['title']) && !empty($item['button']['title'])) :
                                $target = (isset($item['button']['target']) && !empty($item['button']['target'])) ? 'target="'. $item['button']['target'] .'"' : ''; ?>
                                <a href="<?php echo $item['button']['url']; ?>" class="button white" <?php echo $target; ?>>
                                    <?php echo $item['button']['title']; ?>
                                    <?php set_query_var('color', '#791F1F');
                                    get_template_part('template-parts/svg/arrow-right-2'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!--info-boxes-->
<?php endif; ?>