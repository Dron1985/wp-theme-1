<?php
$field = get_field('work_benefit_field');
if (!empty($field['benefits'])) : ?>
    <div class="work-benefits">
        <div class="container">
            <?php if (isset($field['title']) && !empty($field['title'])) : ?>
                <h2><?php echo $field['title']; ?></h2>
            <?php endif; ?>
            <div class="work-benefits-list">
                <?php foreach ($field['benefits'] as $benefit) : ?>
                    <div class="item">
                        <?php if (isset($benefit['icon']['sizes'])) : ?>
                            <div class="icon">
                                <img src="<?php echo $benefit['icon']['sizes']['thumbnail']; ?>" alt="<?php echo $benefit['icon']['alt']; ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (isset($benefit['title']) && !empty($benefit['title'])) : ?>
                            <h5><?php echo $benefit['title']; ?></h5>
                        <?php endif; ?>
                        <?php echo $benefit['description']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!--work-benefits-->
<?php endif; ?>