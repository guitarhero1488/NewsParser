<?php

require_once('simple_html_dom.php');

class Parser
{
    public $news;

    function __construct($url)
    {
        $this->news  = $this->parsePage($url);
    }

    function parsePage($url)
    {
        $months = [
            "января"   => "january",
            "февраля"  => "february",
            "марта"    => "march",
            "апреля"   => "april",
            "мая"      => "may",
            "июня"     => "june",
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
                preg_match("/[июня|а-я]+/", $time->datetime, $date); // не хотел так делать, но с переходом на июнь слово "июня" стало невалидным для регулярки.....
                $date = preg_replace("/[июня|а-я]+/", $months[$date[0]], $time->datetime);
                $a->children(0)->outertext='';
                $title = preg_replace("/(&nbsp;)+/", " ", $a->innertext);
                
                $news[$i]["title"] = $title;
                if($a->target == "_blank") {
                    $news[$i]["link"] = $a->href;
                } else {
                    $news[$i]["link"] = $url.$a->href;
                }
                $news[$i]["date"] = date("Y-m-d H:i:s", strtotime($date));
            }
        }
        return $news;
    }
}
