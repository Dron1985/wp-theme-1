<?php
$benefits = get_field('job_benefits_field');

if (!empty($benefits['benefits'])) : ?>
    <div class="job-benefits">
        <?php if (isset($benefits['title']) && !empty($benefits['title'])) : ?>
            <h4><?php echo $benefits['title']; ?></h4>
        <?php endif; ?>
        <div class="job-benefits-list">
            <?php foreach ($benefits['benefits'] as $benefit) : ?>
                <div class="item">
                    <?php if (isset($benefit['title']) && !empty($benefit['title'])) : ?>
                        <h6><?php echo $benefit['title']; ?></h6>
                    <?php endif; ?>
                    <?php echo $benefit['description']; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!--job-details-->
<?php endif;