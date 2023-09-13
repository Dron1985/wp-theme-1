<?php

use setasign\Fpdi\Fpdi;

require get_template_directory() . '/inc/fpdf/fpdf.php';
require get_template_directory() . '/inc/fpdi2/src/autoload.php';
require get_template_directory() . '/inc/fpdi2-parser/src/autoload.php';
require get_template_directory() . '/inc/fpdf/font/NeueHaasDisplayBold.php';
require get_template_directory() . '/inc/fpdf/font/NeueHaasDisplayRoman.php';
require get_template_directory() . '/inc/fpdf/font/NeueHaasDisplayLight.php';

if (!empty($_GET['download_pdf']) && !empty($_GET['type'])) {
    $type     = (!empty($_GET['type'])) ? $_GET['type'] : '';
    $post_obj = get_page_by_slug($_GET['download_pdf'], OBJECT, $_GET['type']);
    $page_id  = $post_obj->ID;
    $title    = get_the_title($page_id);
    $file_name = sanitize_title( $title).'.pdf';

    $GLOBALS['page_id'] = $page_id;

    if (isset($post_obj->ID) && $_GET['type'] == 'professionals') {
        $header    = get_field('fields_header', 'option');
        $main      = get_field('prof_main_info', $page_id);
        $contact   = get_field('contact_info', $page_id);
        $general   = get_field('general_info', $page_id);
        $accordion = get_accordion_info($page_id);
        $photo     = get_featured_img_info('medium_large', $page_id);
        $add_info  = get_field('team_additional_info', $page_id);
        $transaction = $add_info['transactions_field'];
    } elseif (isset($post_obj->ID) && $_GET['type'] == 'capability') {
        $content_blocks = get_field('capability_content', $page_id);
        $chairs         = get_field('capability_chairs', $page_id);
        $professionals  = get_leadership_by_id($page_id, $type);
        $practice_areas = get_areas_list($page_id, $type);
    }

    $news = get_latest_news($page_id, $type);
    $resources = get_resources_by_id($page_id, $type);

    function convert_to_normal_text($text) {
        $text_decode = html_entity_decode($text);
        $normal_characters = "a-zA-Z0-9\s`~!@#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]";
        $normal_text = preg_replace("/[^$normal_characters]/", '', $text_decode);

        return wp_strip_all_tags($normal_text);
    }

    class PDF extends FPDF {
        function Header() {
            // Select Arial bold 15
            $this->SetFont('Arial','B',22);

            // Set text color
            $this->SetTextColor(220, 50, 50);

            // Move to the right
            $this->Cell(140);

            // set logo
            $image = get_template_directory_uri().'/inc/images/print-pdf-logo.jpg';
            $this->Cell(0, 0, $this->Image($image, $this->GetX(), $this->GetY(), 50), 0, 0, 'R', false);

            // Line break
            $this->Ln(20);
        }

        function Footer() {
            global $GLOBALS;
            $title = get_the_title($GLOBALS['page_id']);
            $field = get_field('prof_main_info', $GLOBALS['page_id']);
            $text  = (isset($field['position']) && !empty($field['position'])) ? $title.' - '.$field['position'] : $title;
            $this->SetY(-15);
            $this->SetFont('Arial', '', 10);

            // Page number
            $this->Cell(0,10,$text.' | Barley Snyder - Page '.$this->PageNo().'/{nb}',0,0,'C');
        }

        //MultiCell with bullet
        function MultiCellBlt($w, $h, $blt, $txt, $border=0, $align='J', $fill=false) {
            //Get bullet width including margins
            $blt_width = $this->GetStringWidth($blt)+$this->cMargin*2;

            //Save x
            $bak_x = $this->x;

            //Output bullet
            $this->Cell($blt_width,$h,$blt,0,'',$fill);

            //Output text
            $this->MultiCell($w-$blt_width,$h,$txt,$border,$align,$fill);

            //Restore x
            $this->x = $bak_x;
        }

        function floatingImage($imgPath, $width,  $height) {
            $width  = ($width) ? $width : 50;
            $height = ($height) ? $height : 40;
            list($w, $h) = getimagesize($imgPath);
            $ratio = $w / $h;
            $imgWidth = $height * $ratio;
            $this->Image($imgPath, $this->GetX(), $this->GetY(), $width, $height);
            $this->x += $imgWidth;
        }
    }

    //create a FPDF object
    $pdf=new PDF();

    $pdf->AddFont('NeueHaasDisplayBold', 'B', 'NeueHaasDisplayBold.php');
    $pdf->AddFont('NeueHaasDisplayRoman', '', 'NeueHaasDisplayRoman.php');
    $pdf->AddFont('NeueHaasDisplayLight', '', 'NeueHaasDisplayLight.php');

    $pdf->AliasNbPages();

    //set document properties
    $pdf->SetTitle('Barley Snyder');

    //set font for the entire document
    $pdf->SetFont('NeueHaasDisplayRoman','',12);
    $pdf->SetTextColor(0,0,0);

    //set up a page
    $pdf->AddPage('P', 'A4');
    $pdf->SetX(10);

    if ($_GET['type'] == 'professionals') {
        $photo = $photo['src'];
        if (!empty($photo)) {
            $pdf->floatingImage($photo, 60, 60);
            $pdf->Ln(5);
        }

        $pdf->SetX(80);
        $pdf->SetFont('NeueHaasDisplayBold', 'B', 18);
        $pdf->Cell(0, 5, get_the_title($page_id), 0, '0', 'L', 0);
        $pdf->Ln(7);

        if (isset($main['position']) && !empty($main['position'])) {
            $pdf->SetX(80);
            $pdf->SetFont('NeueHaasDisplayRoman', '', 12);
            $pdf->Cell(0,7, $main['position'],'B',0,'L',0);
            $pdf->Ln(11);
        }

        if (isset($contact['office']) && !empty($contact['office'])) :
            $offices = '';
            $text = (count($contact['office']) > 1) ? 'Offices: ' : 'Office: ';
            $i = 1;
            foreach ($contact['office'] as $office) :
                $offices .= ($i < count($contact['office'])) ? $office->post_title.', ' : $office->post_title;
                $i++;
            endforeach;

            $pdf->SetX(80);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 5, $text, 0, 0, 'L', 0);
            $pdf->SetX(95);
            $pdf->SetFont('NeueHaasDisplayRoman', '', 12);
            $pdf->Cell(0, 5, $offices, 0, 0, 'L', 0);
            $pdf->Ln(8);
        endif;

        if (isset($contact['email']) && !empty($contact['email'])) :
            $pdf->SetX(80);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 5, 'Email: ', 0, 0, 'L', 0);
            $pdf->SetX(95);
            $pdf->SetFont('NeueHaasDisplayRoman', '', 12);
            $pdf->Cell(0, 5, $contact['email'], 0, 0, 'L', 0);
            $pdf->Ln(8);
        endif;

        if (isset($contact['phone']) && !empty($contact['phone'])) {
            $pdf->SetX(80);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 5, 'Tel: ', 0, 0, 'L', 0);
            $pdf->SetX(95);
            $pdf->SetFont('NeueHaasDisplayRoman', '', 12);
            $pdf->Cell(0,5, 'Tel: '.$contact['phone'], '', 0, 'L', 0);
            $pdf->Ln(8);
        }

        $pdf->Ln(20);
        $pdf->SetX(10);
        $pdf->SetFont('NeueHaasDisplayBold', 'B', 12);
        $pdf->Cell(0, 10, 'OVERVIEW:', 'B', 0, 'L', 0);
        $pdf->Ln(15);
        $post = get_post( $page_id );
        if (has_blocks( $post->post_content)) {
            $blocks = parse_blocks( $post->post_content );

            foreach($blocks as $block) {
                if (isset($block['blockName']) && $block['blockName'] == 'core/heading') {
                    $pdf->Ln(4);
                    $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
                    $pdf->Cell(0, 6, convert_to_normal_text($block['innerHTML']), 0, 0, 'L', 0);
                    $pdf->Ln(10);
                }

                if (isset($block['blockName']) && $block['blockName'] == 'core/paragraph') {
                    $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                    $breaks = array("<br />","<br>","<br/>");
                    $content = str_ireplace($breaks, "\r\n", $block['innerHTML']);
                    $pdf->MultiCell(185, 6, convert_to_normal_text($content), 0, 'L', 0);
                    $pdf->Ln(2);
                }

                if (isset($block['blockName']) && $block['blockName'] == 'core/list') {
                    $column_width = ($pdf->GetPageWidth()-30);
                    $arr_list = explode("<li>", $block['innerHTML']);
                    $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                    foreach ($arr_list as $list_item) {
                        if (!empty(wp_strip_all_tags($list_item))) {
                            $pdf->MultiCellBlt($column_width, 6, chr(149), convert_to_normal_text($list_item));
                        }
                        $pdf->Ln(3);
                    }
                }
            }
        }

        if (isset($general['education']) && !empty(array_filter($general['education']))) {
            if ($pdf->getY() >= 240) {
                $pdf->AddPage('P');
            }
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 12);
            $pdf->Cell(0, 10, 'EDUCATION:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($general['education'] as $education) :
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width,2, chr(149), convert_to_normal_text($education['text']));
                $pdf->Ln(5);
            endforeach;
            $pdf->Ln(5);
        }

        if (isset($general['admissions']) && !empty(array_filter($general['admissions']))) {
            if ($pdf->getY() >= 240) {
                $pdf->AddPage('P');
            }
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'ADMISSIONS:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($general['admissions'] as $admission) :
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width, 2, chr(149), convert_to_normal_text($admission['admission']));
                $pdf->Ln(5);
            endforeach;
            $pdf->Ln(5);
        }

        if (isset($general['capabilities']) && !empty(array_filter($general['capabilities']))) {
            if ($pdf->getY() >= 240) {
                $pdf->AddPage('P');
            }
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'PRACTICE AREAS:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($general['capabilities'] as $capability) :
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width, 2, chr(149), convert_to_normal_text($capability->post_title));
                $pdf->Ln(5);
            endforeach;
            $pdf->Ln(5);
        }

        if (isset($general['industries']) && !empty(array_filter($general['industries']))) {
            if ($pdf->getY() >= 240) {
                $pdf->AddPage('P');
            }
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'INDUSTRY GROUPS:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($general['industries'] as $industry) :
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width, 2, chr(149), convert_to_normal_text($industry->post_title));
                $pdf->Ln(5);
            endforeach;
            $pdf->Ln(5);
        }

        if (isset($general['communities']) && !empty(array_filter($general['communities']))) {
            if ($pdf->getY() >= 240) {
                $pdf->AddPage('P');
            }
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'COMMUNITY INVOLVEMENT:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($general['communities'] as $community) :
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width, 2, chr(149), convert_to_normal_text($community['title']));
                $pdf->Ln(5);
            endforeach;
            $pdf->Ln(5);
        }

        if (isset($accordion) && !empty(array_filter($accordion))) {
            $pdf->Ln(5);
            foreach ($accordion as $item) :
                if ($pdf->getY() >= 230) {
                    $pdf->AddPage('P');
                }
                if (!empty($item['title'])) {
                    $arr_list = explode("<li>", $item['description']);
                    $pdf->Ln(5);
                    $pdf->SetX(10);
                    $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
                    $pdf->Cell(0, 10, strtoupper($item['title']).':', 'B', 0, 'L', 0);
                    $pdf->Ln(12);
                    $column_width = ($pdf->GetPageWidth()-30);
                    $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                    foreach ($arr_list as $list_item) {
                        if (!empty(wp_strip_all_tags($list_item))) {
                            $pdf->MultiCellBlt($column_width, 6, chr(149), convert_to_normal_text($list_item));
                        }
                        $pdf->Ln(2);
                    }
                    $pdf->Ln(5);
                }
            endforeach;
            $pdf->Ln(5);
        }

        if (!empty($news)) {
            if ($pdf->getY() >= 240) {
                $pdf->AddPage('P');
            }
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'RELATED NEWS:', 'B', 0, 'L', 0);
            $pdf->Ln(12);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($news as $news_item) :
                if ($pdf->getY() >= 265) {
                    $pdf->AddPage('P');
                }
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width,6, chr(149), convert_to_normal_text(get_the_title($news_item->ID)));
                $pdf->SetX(14);
                $pdf->SetFont('NeueHaasDisplayLight', '', 10);
                $pdf->MultiCell($column_width, 4, get_the_date('F j, Y', $news_item->ID), 0, 'L', 0);
                $pdf->Ln(3);
            endforeach;
            $pdf->Ln(5);
        }

        if (!empty($resources)) {
            if ($pdf->getY() >= 240) {
                $pdf->AddPage('P');
            }
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'RELATED RESOURCES:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($resources as $resource) :
                if ($pdf->getY() >= 265) {
                    $pdf->AddPage('P');
                }
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width,6, chr(149), convert_to_normal_text(get_the_title($resource)));
                $pdf->SetX(14);
                $pdf->SetFont('NeueHaasDisplayLight', '', 10);
                $pdf->MultiCell($column_width, 4, get_the_date('F j, Y', $resource), 0, 'L', 0);
                $pdf->Ln(5);
            endforeach;
            $pdf->Ln(5);
        }

        if (isset($transaction['info']) && !empty($transaction['info'])) {
            if ($pdf->getY() >= 230) {
                $pdf->AddPage('P');
            }

            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'REPRESENTATIVE TRANSACTIONS:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $i = 1;
            foreach ($transaction['info'] as $item) :
                if ($pdf->getY() >= 250) {
                    $pdf->AddPage('P');
                }

                $pdf->SetX(10);
                $column_width = ($pdf->GetPageWidth() - 20);
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width, 6, chr(149), convert_to_normal_text($item['description']));
                $pdf->Ln(5);
                $i++;
            endforeach;
        }

    } elseif ($_GET['type'] == 'capability') {
        $pdf->SetX(10);
        $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
        $pdf->Cell(0, 10, strtoupper(html_entity_decode($title)), 'B', 0, 'L', 0);
        $pdf->Ln(15);
        $post = get_post( $page_id );
        if (has_blocks( $post->post_content)) {
            $blocks = parse_blocks( $post->post_content );

            foreach($blocks as $block) {
                if (isset($block['blockName']) && $block['blockName'] == 'core/heading') {
                    $pdf->Ln(4);
                    $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
                    $pdf->Cell(0, 6, convert_to_normal_text($block['innerHTML']), 0, 0, 'L', 0);
                    $pdf->Ln(10);
                }

                if (isset($block['blockName']) && $block['blockName'] == 'core/paragraph') {
                    $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                    $breaks = array("<br />","<br>","<br/>");
                    $content = str_ireplace($breaks, "\r\n", $block['innerHTML']);
                    $pdf->MultiCell(185, 6, convert_to_normal_text($content), 0, 'L', 0);
                    $pdf->Ln(2);
                }

                if (isset($block['blockName']) && $block['blockName'] == 'core/list') {
                    $column_width = ($pdf->GetPageWidth()-30);
                    $arr_list = explode("<li>", $block['innerHTML']);
                    $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                    foreach ($arr_list as $list_item) {
                        if (!empty(wp_strip_all_tags($list_item))) {
                            $pdf->MultiCellBlt($column_width, 6, chr(149), convert_to_normal_text($list_item));
                        }
                        $pdf->Ln(3);
                    }
                }
            }
        }

        if (!empty($chairs)) {
            if ($pdf->getY() >= 225) {
                $pdf->AddPage('P');
            }
            $title = (count($chairs) > 1) ? 'Chairs' : 'Chair';
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, strtoupper($title).':', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($chairs as $item) :
                $main  = get_field('prof_main_info', $item->ID);
                $field = get_field('contact_info', $item->ID);
                $photo = get_featured_img_info('medium_large', $item->ID);
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);

                if ($pdf->getY() >= 245) {
                    $pdf->AddPage('P');
                }

                if (!empty($photo['src'])) {
                    $pdf->floatingImage($photo['src'], 40, 40);
                    $pdf->Ln(5);
                }

                $pdf->SetX(60);
                $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
                $pdf->Cell(0, 5, get_the_title($item->ID), 0, '0', 'L', 0);
                $pdf->Ln(8);

                if (isset($main['position']) && !empty($main['position'])) {
                    $pdf->SetX(60);
                    $pdf->SetFont('NeueHaasDisplayRoman', '', 10);
                    $pdf->Cell(0,5, $main['position'],0,0,'L',0);
                    $pdf->Ln(8);
                }

                if (isset($field['phone']) && !empty($field['phone'])) {
                    $pdf->SetX(60);
                    $pdf->SetFont('NeueHaasDisplayRoman', '', 10);
                    $pdf->Cell(0,5, 'Tel: '.$field['phone'], '', 0, 'L', 0);
                    $pdf->Ln(8);
                }

                if (isset($field['email']) && !empty($field['email'])) {
                    $pdf->SetX(60);
                    $pdf->SetFont('NeueHaasDisplayRoman', '', 10);
                    $pdf->Cell(0, 5, 'Email: '.$field['email'], 0, 0, 'L', 0);
                    $pdf->Ln(8);
                }

                $pdf->Ln(15);

            endforeach;
            $pdf->Ln(5);
        }

        if (!empty($professionals)) {
            $new_arr = array();
            $i = 1;
            $j = 1;

            if ($pdf->getY() >= 220) {
                $pdf->AddPage('P');
            }
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'RELATED PROFESSIONALS:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            $pdf->SetFont('NeueHaasDisplayRoman', '', 9);
            foreach ($professionals as $professional) :
                $main  = get_field('prof_main_info', $professional['id']);
                $field = get_field('contact_info', $professional['id']);
                $photo = get_featured_img_info('medium_large', $professional['id']);

                if ($i == 4) {
                    $j++;
                    $i = 1;
                }

                if ($i <= 3) {
                    $new_arr[$j]['images'][] = $photo['src'];
                    $new_arr[$j]['titles'][] = $professional['title'];
                    $new_arr[$j]['positions'][] = $main['position'];
                    $new_arr[$j]['phones'][] = $field['phone'];
                    $new_arr[$j]['emails'][] = $field['email'];
                }
                $i++;
            endforeach;


            foreach ($new_arr as $key => $val) :
                if ($pdf->getY() >= 245) {
                    $pdf->AddPage('P');
                }

                if (!empty($val['images'])) {
                    if (isset($val['images'][0])) {
                        $pdf->floatingImage($val['images'][0], 40, 40);
                    }

                    if (isset($val['images'][1])) {
                        $pdf->SetX(75);
                        $pdf->floatingImage($val['images'][1], 40, 40);
                    }

                    if (isset($val['images'][2])) {
                        $pdf->SetX(140);
                        $pdf->floatingImage($val['images'][2], 40, 40);
                    }
                    $pdf->Ln(43);
                }


                if (!empty($val['titles'])) {
                    if (isset($val['titles'][0])) {
                        $pdf->SetX(10);
                        $pdf->Cell(0, 5, $val['titles'][0], 0, '0', 'L', 0);
                    }

                    if (isset($val['titles'][1])) {
                        $pdf->SetX(75);
                        $pdf->Cell(0, 5, $val['titles'][1], 0, '0', 'L', 0);
                    }

                    if (isset($val['titles'][2])) {
                        $pdf->SetX(140);
                        $pdf->Cell(0, 5, $val['titles'][2], 0, '0', 'L', 0);
                    }
                }

                if (!empty($val['positions'])) {
                    $pdf->Ln(6);
                    if (isset($val['positions'][0])) {
                        $pdf->SetX(10);
                        $pdf->Cell(0, 5, $val['positions'][0], 0, '0', 'L', 0);
                    }

                    if (isset($val['positions'][1])) {
                        $pdf->SetX(75);
                        $pdf->Cell(0, 5, $val['positions'][1], 0, '0', 'L', 0);
                    }

                    if (isset($val['positions'][2])) {
                        $pdf->SetX(140);
                        $pdf->Cell(0, 5, $val['positions'][2], 0, '0', 'L', 0);
                    }
                }

                if (!empty($val['phones'])) {
                    $pdf->Ln(6);
                    if (isset($val['phones'][0])) {
                        $pdf->SetX(10);
                        $pdf->Cell(0,5, 'Tel: '.$val['phones'][0], '', 0, 'L', 0);
                    }

                    if (isset($val['phones'][1])) {
                        $pdf->SetX(75);
                        $pdf->Cell(0,5, 'Tel: '.$val['phones'][1], '', 0, 'L', 0);
                    }

                    if (isset($val['phones'][2])) {
                        $pdf->SetX(140);
                        $pdf->Cell(0,5, 'Tel: '.$val['phones'][2], '', 0, 'L', 0);
                    }
                }

                if (!empty($val['emails'])) {
                    $pdf->Ln(6);
                    if (isset($val['emails'][0])) {
                        $pdf->SetX(10);
                        $pdf->Cell(0,5, 'Email: '.$val['emails'][0], '', 0, 'L', 0);
                    }

                    if (isset($val['emails'][1])) {
                        $pdf->SetX(75);
                        $pdf->Cell(0,5, 'Email: '.$val['emails'][1], '', 0, 'L', 0);
                    }

                    if (isset($val['emails'][2])) {
                        $pdf->SetX(140);
                        $pdf->Cell(0,5, 'Email: '.$val['emails'][2], '', 0, 'L', 0);
                    }
                }
                $pdf->Ln(15);
            endforeach;


            $pdf->Ln(2);
        }

        if (!empty($practice_areas)) {
            $pdf->Ln(5);
            $pdf->SetX(10);
            $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
            $pdf->Cell(0, 10, 'PRACTICE AREAS:', 'B', 0, 'L', 0);
            $pdf->Ln(15);
            $column_width = ($pdf->GetPageWidth()-30);
            foreach ($practice_areas['focus_areas'] as $practice) :
                $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                $pdf->MultiCellBlt($column_width, 6, chr(149), convert_to_normal_text($practice['title']));
                $pdf->Ln(2);
            endforeach;
            $pdf->Ln(5);
        }

        if (!empty(array_filter($content_blocks))) {
            foreach ($content_blocks as $key => $value) {
                if ($value['acf_fc_layout'] == 'testimonial_block' && isset($value['testimonials']) && !empty($value['testimonials'])) {
                    if ($pdf->getY() >= 240) {
                        $pdf->AddPage('P');
                    }
                    $pdf->Ln(5);
                    $pdf->SetX(10);
                    $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
                    $pdf->Cell(0, 10, 'TESTIMONIALS:', 'B', 0, 'L', 0);
                    $pdf->Ln(15);
                    $column_width = ($pdf->GetPageWidth()-30);
                    foreach ($value['testimonials'] as $testimonial) :
                        if ($pdf->getY() >= 235) {
                            $pdf->AddPage('P');
                        }

                        $padding = (isset($testimonial['logo']['sizes'])) ? 50 : 15;
                        if (isset($testimonial['logo']['sizes'])) {
                            $pdf->SetX(15);
                            $pdf->floatingImage($testimonial['logo']['sizes']['thumbnail'], 25, 20);
                            $pdf->Ln(3);
                        }

                        if (isset($testimonial['title']) && !empty($testimonial['title'])) {
                            $pdf->SetX($padding);
                            $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                            $pdf->MultiCell($column_width, 5, convert_to_normal_text($testimonial['title']), 0, 'L', 0);
                            $pdf->Ln(3);
                        }

                        if (isset($testimonial['subtitle']) && !empty($testimonial['subtitle'])) {
                            $pdf->SetX($padding);
                            $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                            $pdf->MultiCell($column_width, 5, convert_to_normal_text($testimonial['subtitle']), 0, 'L', 0);
                            $pdf->Ln(3);
                        }

                        $pdf->Ln(3);
                        $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                        $pdf->MultiCellBlt($column_width, 6, chr(149), convert_to_normal_text($testimonial['quote']));
                        $pdf->Ln(10);
                    endforeach;
                    $pdf->Ln(5);
                }

                if ($value['acf_fc_layout'] == 'info_block' && isset($value['transactions_field']['info']) && !empty($value['transactions_field']['info'])) {
                    if ($pdf->getY() >= 230) {
                        $pdf->AddPage('P');
                    }
                    $pdf->Ln(5);
                    $pdf->SetX(10);
                    $pdf->SetFont('NeueHaasDisplayBold', 'B', 11);
                    $pdf->Cell(0, 10, 'REPRESENTATIVE TRANSACTIONS:', 'B', 0, 'L', 0);
                    $pdf->Ln(15);
                    $i = 1;
                    foreach ($value['transactions_field']['info'] as $item) :
                        if ($pdf->getY() >= 250) {
                            $pdf->AddPage('P');
                        }

                        $pdf->SetX(10);
                        $column_width = ($pdf->GetPageWidth() - 20);
                        $pdf->SetFont('NeueHaasDisplayRoman', '', 11);
                        $pdf->MultiCellBlt($column_width, 6, chr(149), convert_to_normal_text($item['description']));
                        $pdf->Ln(5);
                        $i++;
                    endforeach;
                }
            }
        }

        $pdf->Ln(5);
    }

    //Output the document
    $pdf->Output($file_name,'I');
}