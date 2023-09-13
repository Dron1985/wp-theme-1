<?php $video = get_field('video_field');
if (isset($video['image']['sizes'])) : ?>
    <div class="video-holder">
        <div class="poster" style="background-image: url('<?php echo $video['image']['sizes']['large']; ?>')">
            <?php if (isset($video['video_link']) && !empty($video['video_link'])) : ?>
                <a href="<?php echo $video['video_link']; ?>" class="play-button"></a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>