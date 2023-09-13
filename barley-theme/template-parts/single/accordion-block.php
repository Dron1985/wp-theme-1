<?php
$accordion = get_field('accordion_field');
if (!empty($accordion)) : ?>
    <div class="accordion">
        <?php foreach ($accordion as $item) : ?>
            <div class="accordion-item">
                <?php if (isset($item['title']) && !empty($item['title'])) : ?>
                    <h5><a href="#"><?php echo $item['title']; ?></a></h5>
                <?php endif; ?>
                <div class="accordion-info content">
                    <?php echo $item['description']; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>