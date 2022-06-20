<?php

namespace App\Models\Templates;

use App\Models\Parser;

class rsvpuParser extends Parser {
    public function getNews($dom) {
        $array = [];

        $elements = $dom->findOne(".newsblock")->findMulti('.localNewsArtc');

        foreach ($elements as $key => $value) {
            $item = $value->findOne(".newsname")->findOne("a");

            $result = [
                "url"   => $item->getAttribute("href"),
                "title" => $item->innerHtml()
            ];

            $array[] = $result;
        }

        return $array;
    }
}
