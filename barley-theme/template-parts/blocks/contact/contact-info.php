<?php
$contact_info = get_field('contact_info');
if (!empty($contact_info)): ?>
    <div class="leadership-details">
        <?php foreach ($contact_info as $info) : ?>
            <div class="box">
                <?php if (isset($info['title']) && !empty($info['title'])) : ?>
                    <h3><?php echo $info['title']; ?></h3>
                <?php endif; ?>

                <?php if (isset($info['type']) && $info['type'] == 'type1') : ?>
                    <div class="person-contacts">
                        <?php if (isset($info['full_name']) && !empty($info['full_name'])) : ?>
                            <h4><?php echo $info['full_name']; ?></h4>
                        <?php endif; ?>

                        <?php if (isset($info['position']) && !empty($info['position'])) : ?>
                            <div class="person-post"><?php echo $info['position']; ?></div>
                        <?php endif; ?>

                        <?php if (isset($info['phone']) || isset($info['email'])) : ?>
                            <ul>
                                <?php if (isset($info['phone']) && !empty($info['phone'])) : ?>
                                    <li><a href="<?php echo phone_url($info['phone']); ?>"><?php echo $info['phone']; ?></a></li>
                                <?php endif; ?>

                                <?php if (isset($info['email']) && !empty($info['email'])) : ?>
                                    <li><a href="mailto:<?php echo $info['email']; ?>"><?php echo $info['email']; ?></a></li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php else :
                    echo $info['description']; ?>

                    <?php if (isset($info['button']['url']) && isset($info['button']['title']) && !empty($info['button']['title'])) :
                    $target = (isset($info['button']['target']) && !empty($info['button']['target'])) ? 'target="'. $info['button']['target'] .'"' : ''; ?>
                        <a href="<?php echo $info['button']['url']; ?>" class="button" <?php echo $target; ?>>
                            <?php echo $info['button']['title']; ?>
                            <?php get_template_part('template-parts/svg/arrow-right'); ?>
                        </a>
                    <?php endif;
                endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <!--leadership-details-->
<?php endif;