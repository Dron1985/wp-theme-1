<?php $content = get_field('content_field');
if (!empty($content)) : ?>
    <div class="content-block">
        <div class="container">
            <div class="content">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    <!--content-block-->
<?php endif; ?>