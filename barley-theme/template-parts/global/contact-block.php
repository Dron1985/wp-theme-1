<?php
switch (true) {
    case is_post_type_archive('jobs'):
        $field = get_field('fields_careers', 'option');
        $type  = $field['type_block'];
        break;
    case is_post_type_archive('resources'):
        $field = get_field('fields_resources', 'option');
        $type  = $field['type_block'];
        break;
    case is_post_type_archive('events'):
        $field = get_field('fields_events', 'option');
        $type  = $field['type_block'];
        break;
    case is_home():
        $page_news = get_option('page_for_posts');
        $type      = get_field('news_type_block', $page_news);
        break;
    default:
        $type  = get_field('type_block');
}

$contacts = ($type == 'type1') ? get_field('fields_contact_box', 'option') : get_field('fields_contact_box_2', 'option');
$class = ($type == 'type1') ? 'contact-boxes' : 'contact-boxes align-center';

if (!empty($contacts) && $type !== 'hide') : ?>
    <div class="<?php echo $class; ?>">
        <div class="container">
            <div class="holder">
                <?php $i = 1;
                foreach ($contacts as $info) :
                    $class = ($i == 1) ? 'box' : 'box subscribe-box';
                    $tag   = ($type == 'type1') ? 'h2' : 'h3'?>
                    <div class="<?php echo $class; ?>">
                        <div class="wrap">
                            <?php echo (isset($info['title']) && !empty($info['title'])) ? '<'.$tag.'>'.$info['title'].'</'.$tag.'>' : ''; ?>
                            <?php echo $info['description']; ?>

                            <?php if ($info['type'] == 'email' && isset($info['email']) && !empty($info['email'])) : ?>
                                <a href="mailto:<?php echo $info['email']; ?>" class="email-link"><?php echo $info['email']; ?></a>
                            <?php elseif ($info['type'] == 'button' || $info['type'] == 'popup') :

                                if ($info['type'] == 'button') {
                                    $text   = (isset($info['button']['title']) && !empty($info['button']['title'])) ? $info['button']['title'] : '';
                                    $link   = (isset($info['button']['url'])) ? $info['button']['url'] : '';
                                    $target = (isset($info['button']['target']) && !empty($info['button']['target'])) ? 'target="'. $info['button']['target'] .'"' : '';
                                } elseif ($info['type'] == 'popup') {
                                    $text   = 'Subscribe';
                                    $link   = '#subscribe-popup';
                                    $target = '';
                                }

                                if (!empty($text) && !empty($link)) :
                                    $class = ($info['type'] == 'popup') ? 'button white popup-opener' : 'button white'; ?>
                                    <a href="<?php echo $link; ?>" class="<?php echo $class; ?>" <?php echo $target; ?>>
                                        <?php echo $text; ?>
                                        <?php get_template_part('template-parts/svg/arrow-right-3'); ?>
                                    </a>
                                <?php endif;
                            elseif ($info['type'] == 'social' && (isset($info['link_facebook']) || isset($info['link_twitter']) || isset($info['link_linkedin']))) : ?>
                                <ul class="social-list">
                                    <?php if (isset($info['link_facebook']) && !empty($info['link_facebook'])) : ?>
                                        <li>
                                            <a href="<?php echo $info['link_facebook']; ?>" target="_blank" rel="nofollow">
                                                <?php get_template_part('template-parts/svg/facebook'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (isset($info['link_twitter']) && !empty($info['link_twitter'])) : ?>
                                        <li>
                                            <a href="<?php echo $info['link_twitter']; ?>" target="_blank" rel="nofollow">
                                                <?php get_template_part('template-parts/svg/twitter'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (isset($info['link_linkedin']) && !empty($info['link_linkedin'])) : ?>
                                        <li>
                                            <a href="<?php echo $info['link_linkedin']; ?>" target="_blank" rel="nofollow">
                                                <?php get_template_part('template-parts/svg/linkedin'); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php $i++;
                endforeach; ?>
            </div>
        </div>
    </div>
    <!--contact-boxes-->
<?php endif;



