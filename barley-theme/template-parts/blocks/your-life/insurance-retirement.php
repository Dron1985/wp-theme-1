<?php
$field = get_field('insurance_retirement');
if (!empty($field['info'])) : ?>
    <div class="plans">
        <div class="container">
            <div class="holder">
                <?php if (isset($field['title']) && !empty($field['title'])) : ?>
                    <h2><?php echo $field['title']; ?></h2>
                <?php endif; ?>
                <div class="marked-list">
                    <ul>
                        <?php foreach ($field['info'] as $item) : ?>
                            <li> <?php echo $item['title']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--plans-->
<?php endif; ?>