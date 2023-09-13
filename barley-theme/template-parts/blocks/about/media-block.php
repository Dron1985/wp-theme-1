<?php
$media = get_field('media_field');
if (!empty($media)): ?>
    <div class="media-section">
        <div class="container">
            <div class="heading">
                <?php if (isset($media['title']) && !empty($media['title'])) : ?>
                    <h2><?php echo $media['title']; ?></h2>
                <?php endif; ?>
                <?php echo $media['description']; ?>
            </div>
            <?php if (isset($media['image']['sizes'])) : ?>
                <div class="video-holder">
                    <div class="poster" style="background-image: url('<?php echo $media['image']['sizes']['full-hd']; ?>')">
                        <?php if (isset($media['video_link']) && !empty($media['video_link'])) : ?>
                            <a href="<?php echo $media['video_link']; ?>" class="play-button"></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!--media-section-->
<?php endif;