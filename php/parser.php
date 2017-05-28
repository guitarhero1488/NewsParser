<?php

require_once('simple_html_dom.php');

class Parser
{
    public $news;
    public $words;

    function __construct($url)
    {
        $this->news  = $this->parsing($url);
        $this->words = $this->stat($this->news["title"]);
    }

    function parsing($url)
    {
        $months = [
            "января"   => "january",
            "февраля"  => "february",
            "марта"    => "march",
            "апреля"   => "april",
            "мая"      => "may",
            "июня"     => "juny",
            "июля"     => "july",
            "августа"  => "august",
            "сентября" => "september",
            "октября"  => "october",
            "ноября"   => "november",
            "декабря"  => "december"
        ];
        $html = file_get_html($url);
        $items = $html->find('div.items');
        $links = $items[0]->find('a');
        foreach($links as $a) {
            if($a->class != "b-link-external") {
                $time = $a->getElementByTagName('time');
                preg_match("/[а-я]+/", $time->datetime, $date);
                $date = preg_replace("/[а-я]+/", $months[$date[0]], $time->datetime);
                $news["date"][]  = date("Y-m-d H:i", strtotime($date));
                $a->children(0)->outertext='';
                $news["title"][] = $a->innertext;
                if($a->target == "_blank") {
                    $news["links"][] = $a->href;
                }
                else {
                    $news["links"][] = $url.$a->href;
                }
            }
        }
        return $news;
    }

    function stat($news)
    {
        foreach($news as $title) {
            $title = preg_replace("/(&nbsp;)+/", " ", $title);
            $str .= $title." ";
        }
        $words = explode(" ", $str);
        array_pop($words);
        return array_count_values($words);
    }
}

?>