<?php
switch (true) {
    case is_post_type_archive('jobs'):
        $fields   = get_field('fields_careers', 'option');
        $benefits = $fields['benefits_field'];
        break;
    default:
        $benefits = get_field('benefits_field');
}

if (!empty($benefits['benefits'])) : ?>
    <div class="benefits">
        <div class="container">
            <div class="holder">
                <?php if (isset($benefits['title']) && !empty($benefits['title'])) : ?>
                    <h2><?php echo $benefits['title']; ?></h2>
                <?php endif; ?>
                <ul>
                    <?php foreach ($benefits['benefits'] as $benefit) : ?>
                        <li>
                            <div class="icon">
                                <img src="<?php echo $benefit['icon']['sizes']['thumbnail']; ?>" alt="<?php echo $benefit['icon']['alt']; ?>">
                            </div>
                            <?php echo $benefit['description']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <!--benefits-->
<?php endif;