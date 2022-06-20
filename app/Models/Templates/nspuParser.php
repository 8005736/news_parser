<?php

namespace App\Models\Templates;

use App\Models\Parser;

class nspuParser extends Parser {
    public function getNews($dom) {
        $array = [];

        $elements = $dom->findMulti('.pcs-news-main-page-item');

        foreach ($elements as $key => $value) {
            $item = $value->findOne(".pks-news-main-page-item-name")->findOne("a");

            $result = [
                "url"   => $item->getAttribute("href"),
                "title" => $item->innerHtml()
            ];

            $array[] = $result;
        }

        return $array;
    }
}
