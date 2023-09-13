<?php $audio = get_field('audio_embed');
if (!empty($audio)) : ?>
    <div class="audio-player">
        <?php echo $audio; ?>
    </div>
    <!--audio embed end-->
<?php endif; ?>