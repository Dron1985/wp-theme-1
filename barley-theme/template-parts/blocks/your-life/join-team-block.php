<?php
$join_team = get_field('join_team_field');
if (!empty($join_team)) : ?>
    <div class="info-image-section">
        <?php if (isset($join_team['bg_img']['sizes'])) : ?>
            <div class="image" style="background-image: url('<?php echo $join_team['bg_img']['sizes']['full-hd']; ?>')"></div>
        <?php endif; ?>
        <div class="info">
            <div class="container">
                <div class="holder">
                    <?php if (isset($join_team['title']) && !empty($join_team['title'])) : ?>
                        <h2><?php echo $join_team['title']; ?></h2>
                    <?php endif; ?>
                    <div class="description">
                        <?php echo $join_team['description']; ?>
                        <?php if (isset($join_team['button']['url']) && isset($join_team['button']['title']) && !empty($join_team['button']['title'])) :
                            $target = (isset($join_team['button']['target']) && !empty($join_team['button']['target'])) ? 'target="'. $join_team['button']['target'] .'"' : ''; ?>
                            <a href="<?php echo $join_team['button']['url']; ?>" class="button" <?php echo $target; ?>>
                                <?php echo $join_team['button']['title']; ?>
                                <?php get_template_part('template-parts/svg/arrow-right-2'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--info-image-section-->
<?php endif; ?>