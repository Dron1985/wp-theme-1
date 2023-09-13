<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package barley-theme
 */

get_header();
    $fields = get_field('fields_404', 'option');
    if (is_array($fields) && !empty(array_filter($fields))) :
        $bg_img = (isset($fields['image']['sizes'])) ? 'style="background-image: url('.$fields['image']['sizes']['full-hd'].')"' : ''; ?>
        <main class="main">
            <div class="error-page" <?php echo $bg_img; ?>>
                <div class="container">
                    <div class="wrap">
                        <?php if (!empty($fields['title'])) : ?>
                            <h1><?php echo $fields['title']; ?></h1>
                        <?php endif; ?>
                        <?php echo $fields['text']; ?>
                    </div>
                    <?php if (isset($fields['text_btn']) && !empty($fields['text_btn'])) : ?>
                        <a href="<?php echo site_url(); ?>" class="button white"><?php echo $fields['text_btn']; ?>
                            <?php get_template_part('template-parts/svg/'); ?>
                            <svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.1543 4C0.878154 4 0.654297 4.22386 0.654297 4.5C0.654297 4.77614 0.878155 5 1.1543 5L1.1543 4ZM16.1996 4.85355C16.3949 4.65829 16.3949 4.34171 16.1996 4.14645L13.0177 0.964465C12.8224 0.769203 12.5058 0.769203 12.3105 0.964465C12.1153 1.15973 12.1153 1.47631 12.3105 1.67157L15.139 4.5L12.3105 7.32843C12.1153 7.52369 12.1153 7.84027 12.3105 8.03553C12.5058 8.2308 12.8224 8.2308 13.0177 8.03553L16.1996 4.85355ZM1.1543 5L15.8461 5L15.8461 4L1.1543 4L1.1543 5Z" fill="black"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    <?php endif;
get_footer();