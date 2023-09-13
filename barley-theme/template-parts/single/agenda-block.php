<?php $agenda = get_field('agenda_field');
if (!empty($agenda['days'])) : ?>
    <div class="agenda">
        <?php if (isset($agenda['title']) && !empty($agenda['title'])) : ?>
            <h4><?php echo $agenda['title']; ?></h4>
        <?php endif; ?>
        <div class="tabs-holder">
            <ul class="tabs-nav">
                <?php $i = 1;
                foreach ($agenda['days'] as $day) :
                    $active = ($i == 1) ? 'class="active"' : ''; ?>
                    <li <?php echo $active; ?>><a href="#"><?php echo $day['label']; ?></a></li>
                <?php $i++; endforeach; ?>
            </ul>
            <div class="tabs">
                <?php $j = 1;
                foreach ($agenda['days'] as $day) :
                    $class = ($j == 1) ? 'tab active' : 'tab';
                    if (!empty($day['info'])) : ?>
                        <div class="<?php echo $class; ?>">
                            <div class="accordion">
                                <?php foreach ($day['info'] as $info) : ?>
                                    <div class="accordion-item">
                                        <?php if (isset($info['time']) || isset($info['title'])) : ?>
                                            <h5>
                                                <?php if (isset($info['time']) && !empty($info['time'])) : ?>
                                                    <span class="date"><?php echo $info['time']; ?></span>
                                                <?php endif; ?>
                                                <?php if (isset($info['title']) && !empty($info['title'])) : ?>
                                                    <a href="#"><?php echo $info['title']; ?></a>
                                                <?php endif; ?>
                                            </h5>
                                        <?php endif; ?>
                                        <?php if (isset($info['description']) && !empty($info['description'])) : ?>
                                            <div class="accordion-info content">
                                                <?php echo $info['description']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif;
                    $j++;
                endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>