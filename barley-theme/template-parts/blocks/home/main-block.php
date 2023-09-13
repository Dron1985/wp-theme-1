<?php $main = get_field('home_main_field');
$bg_img = (isset($main['bg_img']['sizes'])) ? 'style="background-image: url('.$main['bg_img']['sizes']['full-hd'].')"' : ''; ?>
<section class="hero-section">
    <div class="photo" <?php echo $bg_img; ?>>
        <?php if (isset($main['video_link']) && !empty($main['video_link'])) : ?>
            <iframe width="420" height="315" src="<?php echo $main['video_link']; ?>?autoplay=1&loop=1&playlist=njX2bu-_Vw4&mute=1&controls=0"></iframe>
        <?php endif; ?>
    </div>
    <div class="info-holder">
        <div class="container">
            <div class="info-holder-wrap">
                <?php if (isset($main['label']) && !empty($main['label'])) : ?>
                    <div class="subtitle"><?php echo $main['label']; ?></div>
                <?php endif; ?>

                <?php if (isset($main['title']) && !empty($main['title'])) : ?>
                    <h1><?php echo $main['title']; ?></h1>
                <?php endif; ?>

                <?php echo $main['description']; ?>
            </div>
        </div>
    </div>
    <?php if (isset($main['type_alerts']) && $main['type_alerts'] == true) :
        $alerts = ($main['type_alerts'] == 'manual') ? $main['alerts'] : get_alerts_list();
        if (!empty($alerts)) : ?>
            <div class="news-alert">
                <div class="container">
                    <div class="news-alert-holder">
                        <button class="clear"><span><?php echo __('Close', 'barley-theme'); ?></span></button>
                        <div class="news-alert-slider">
                            <?php foreach ($alerts as $alert) :
                                if ($main['type_alerts'] == 'manual') {
                                    $link   = (isset($alert['link']['url'])) ? $alert['link']['url'] : '';
                                    $title  = (isset($alert['link']['title']) && !empty($alert['link']['title'])) ? $alert['link']['title'] : '';
                                    $target = (isset($alert['link']['target']) && !empty($alert['link']['target'])) ? 'target="'. $alert['link']['target'] .'"' : '';
                                    $alert_id = url_to_postid($link);
                                } else {
                                    $link   = get_the_permalink($alert);
                                    $title  = get_the_title($alert);
                                    $target = '';
                                    $alert_id = $alert;
                                }

                                $type_alert = get_alert_type($alert_id); ?>
                                <div class="item">
                                    <?php if (!empty($type_alert)) : ?>
                                        <div class="subtitle"><?php echo $type_alert; ?></div>
                                    <?php endif; ?>
                                    <h3 class="h6">
                                        <a href="<?php echo $link; ?>"><?php echo $title; ?></a>
                                    </h3>
                                    <a href="<?php echo $link; ?>" class="learn-more" <?php echo $target; ?>>
                                        <span><?php echo __('Read Article', 'barley-theme'); ?></span>
                                        <?php set_query_var('color', '#7A7A7A');
                                        get_template_part('template-parts/svg/arrow-right-2'); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($alerts) > 1) : ?>
                            <div class="news-alert-slider-nav">
                                <div class="nav-count"><i class="current"></i>/<i class="amount"></i></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif;
    endif; ?>
</section>
<!--hero section-->