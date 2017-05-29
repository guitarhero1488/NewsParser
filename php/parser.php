<?php

require_once('simple_html_dom.php');

class Parser
{
    public $news;
    public $words;

    function __construct($url)
    {
        $this->news  = $this->parsing($url);
        $this->words = $this->stat($this->news);
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
                $i++;
                $time = $a->getElementByTagName('time');
                preg_match("/[а-я]+/", $time->datetime, $date);
                $date = preg_replace("/[а-я]+/", $months[$date[0]], $time->datetime);
                $a->children(0)->outertext='';
                $title = preg_replace("/(&nbsp;)+/", " ", $a->innertext);
                
                $news[$i]["title"] = $title;
                if($a->target == "_blank") {
                    $news[$i]["link"] = $a->href;
                } else {
                    $news[$i]["link"] = $url.$a->href;
                }
                $news[$i]["date"] = date("Y-m-d H:i", strtotime($date));
            }
        }
        return $news;
    }

    function stat($news)
    {
        foreach($news as $item) {
            $i++;
            $list = explode(" ", $item["title"]);
            $words[$i][] = $list;
        }
        return $words;
    }
}
