<?php echo (is_singular('events') || is_singular('post')) ? '<div class="title">Share</div>' : '<div>'; ?>
    <ul class="social-list">
        <li>
            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.facebook.com/sharer.php?u=<?php echo get_the_permalink(); ?>')" rel="nofollow">
                <?php get_template_part('template-parts/svg/facebook'); ?>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php echo get_the_permalink(); ?>')" rel="nofollow">
                <?php get_template_part('template-parts/svg/twitter'); ?>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="javascript:genericSocialShare('https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_the_permalink(); ?>')" rel="nofollow">
                <?php get_template_part('template-parts/svg/linkedin'); ?>
            </a>
        </li>
        <li>
            <a href="mailto:?subject=<?php echo rawurlencode(get_the_title()); ?>&body=<?php echo get_the_permalink(); ?>">
                <?php get_template_part('template-parts/svg/mail'); ?>
            </a>
        </li>
    </ul>
<?php echo (is_singular('events') || is_singular('post')) ? '' : '</div>'; ?>