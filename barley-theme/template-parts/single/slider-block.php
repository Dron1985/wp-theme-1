<?php $slider = get_field('resource_slider');
if (!empty($slider)) : ?>
    <div class="images-slider-wrap">
        <button class="slick-btn button-prev" style="">
            <svg width="15" height="28" viewBox="0 0 15 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 27L0.999999 14L14 1" stroke="white"></path>
            </svg>
        </button>
        <button class="slick-btn button-next" style="">
            <svg width="15" height="28" viewBox="0 0 15 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L14 14L1 27" stroke="white"></path>
            </svg>
        </button>
        <div class="images-slider">
            <?php foreach ($slider as $slide) :
                if (isset($slide['image']['sizes'])) : ?>
                    <div class="item">
                        <figure>
                            <div class="image" style="background-image: url('<?php echo $slide['image']['sizes']['large']; ?>')"></div>
                            <?php if (isset($slide['caption']) && !empty($slide['caption'])) : ?>
                                <figcaption><?php echo $slide['caption']; ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    </div>
                <?php endif;
            endforeach; ?>
        </div>
        <div class="images-slider-nav"></div>
    </div>
    <!--images-slider-->
<?php endif; ?>