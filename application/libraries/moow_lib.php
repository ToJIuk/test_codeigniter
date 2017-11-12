<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Inside library
 *
 * @author Alex Torrison
 */

class MOOW_lib {

    public function content_filter ($data, $level = 1) {
        if ($level == 1) {
            $data = htmlspecialchars($data);
            $data = strip_tags($data, "<br><b>");
        }

        return $data;
    }

    public function text_array_cut($text, $limitText = 1000) {
        $textArray = Array();
        $textLength = mb_strlen($text, 'utf-8');
        if ($textLength > $limitText) {
            $start = 0;
            while ($start <= $textLength) {
                if ($start + $limitText >= $textLength) {
                    $textArray[] = mb_substr($text, $start, $limitText, 'utf-8');
                    break;
                }
                $length = mb_strrpos(mb_substr($text, $start, $limitText, 'utf-8'), '<', 0, 'utf-8');
                if ($length === false) {
                    $length = mb_strrpos(mb_substr($text, $start, $limitText, 'utf-8'), ' ', 0, 'utf-8');
                    if ($length === false) {
                        $textArray[] = mb_substr($text, $start, $limitText, 'utf-8');
                        $length = $limitText;
                    }
                    else {
                        $textArray[] = mb_substr($text, $start, $length, 'utf-8');
                    }
                }
                else {
                    $textArray[] = mb_substr($text, $start, $length, 'utf-8');
                }
                $start = $start + $length;
            }
        }
        else {
            $textArray[] = $text;
        }

        return $textArray;
    }

    public function content_view($data, $short = false) {

        if ( ! $short)
        $data = str_replace('
',' <br />',$data);


        if ( ! $short) {
            $data = str_replace(
                "[[youtube]]",
                '<iframe class="tag_youtube" width="550" height="300" src="https://www.youtube.com/embed/',
                $data);
            $data = str_replace("[[/youtube]]", '" frameborder="0" allowfullscreen></iframe>', $data);

            $data = str_replace(
                "[[img_fright]]",
                '<img align="right" class="tag_text_img" width="550" alt="image" src="',
                $data);

            $data = str_replace(
                "[[img]]",
                '<img class="tag_text_img" width="550" alt="image" src="',
                $data);
            $data = str_replace("[[/img]]", '" />', $data);
        }
        if ( ! $short)
            $data = preg_replace("/ http:\/\/([\S]+)/", ' <a target="_blank" onclick="location.href=\'http://\\1\';return false;" rel="nofollow" href="http://\\1">http://\\1</a> ', $data);

        if ( ! $short)
            $data = preg_replace("/ https:\/\/([\S]+)/", ' <a target="_blank" onclick="location.href=\'http://\\1\';return false;" rel="nofollow" href="https://\\1">https://\\1</a> ', $data);

        if ( ! $short)
        $data = str_replace(
            "[[b]]",
            '<b>',
            $data);
        else
            $data = str_replace(
            "[[b]]",
            '',
            $data);
        if ( ! $short)
        $data = str_replace("[[/b]]",'</b>',$data);
        else $data = str_replace("[[/b]]",'',$data);
        return $data;


    }


}