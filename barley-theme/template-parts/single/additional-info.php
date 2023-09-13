<?php
$field = get_field('program_additional_field');
if (!empty($field['info'])) : ?>
    <div class="additional-info">
        <div class="container">
            <?php if (isset($field['title']) && !empty($field['title'])) : ?>
                <h2><?php echo $field['title']; ?></h2>
            <?php endif; ?>
            <ul class="list-additional-info">
                <?php foreach ($field['info'] as $info) : ?>
                    <li>
                        <h4><?php echo $info['title']; ?></h4>
                        <?php get_template_part('template-parts/svg/arrow-right'); ?>
                        <?php echo $info['description']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!--additional-info-->
<?php endif; ?>