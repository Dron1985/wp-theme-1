<?php
$programs = get_field('program_info_field');
if (!empty($programs['programs'])) : ?>
    <div class="development-programs">
        <div class="container">
            <div class="holder">
                <div class="nav-holder">
                    <?php if (isset($programs['title']) && !empty($programs['title'])) : ?>
                        <h2><?php echo $programs['title']; ?></h2>
                    <?php endif; ?>
                    <ul class="development-programs-nav">
                        <?php $i = 1;
                        foreach ($programs['programs'] as $program) :
                            $class = ($i == 1) ? 'class="active"' : '';
                            if (isset($program['title']) && !empty($program['title'])) : ?>
                                <li <?php echo $class; ?>><button><?php echo $program['title']; ?></button></li>
                            <?php endif;
                        $i++;
                        endforeach; ?>
                    </ul>
                </div>
                <div class="development-programs-slider">
                    <?php foreach ($programs['programs'] as $program) : ?>
                        <div class="item">
                            <?php if (isset($program['image']['sizes'])) : ?>
                                <div class="image" style="background-image: url('<?php echo $program['image']['sizes']['medium_large']; ?>')"></div>
                            <?php endif; ?>
                            <?php if (isset($program['title']) && !empty($program['title'])) : ?>
                                <h4><?php echo $program['title']; ?></h4>
                            <?php endif; ?>
                            <?php echo $program['description']; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!--development-programs-->
<?php endif; ?>