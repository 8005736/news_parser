<?php

namespace App\Models;
use voku\helper\HtmlDomParser;

class Parser {
    public $parent_id;

    public function parse($parseFavicons = false) {
        $universities = $this->getUniversities();

        foreach ($universities as $key => $university) {
            $this->parent_id = $university->id;

            $dom = HtmlDomParser::file_get_html($university->url);
            $classname = 'App\Models\Templates\\' . $university->class;
            $class = new $classname();

            if ($parseFavicons) {
                $link = $class->getFavicon($dom);

                if ($link) {
                    $this->createFavicon($university, $link);
                }
            } else {
                $news = $class->getNews($dom);

                foreach ($news as $key => $value) {
                    $this->createNews($value);
                }
            }
        }
    }

    public function getFavicon($dom) {
        $result = "";
        $links = $dom->getElementsByTagName("link");

        foreach ($links as $key => $value) {
            if ($value->getAttribute("type") == "image/x-icon") {
                $result = $value->getAttribute("href");
            }

            if ($value->getAttribute("type") == "image/png") {
                $result = $value->getAttribute("href");
            }
        }

        return $result;
    }

    public function getUniversities() {
        // парсим включенных и тех, у кого прописан класс парсера
        $items = University::whereNotNull("class")->where("is_active", 1)->get();

        return $items;
    }

    public function createNews($item) {
        $row = UniversityNews::firstOrCreate([
            "url"       => $item["url"],
            "title"     => $item["title"],
            "parent_id" => $this->parent_id,
            "date"      => now()->startOfDay() // ставим дату на начало дня, чтобы не дублировать
        ]);
    }

    public function createFavicon($university, $link) {
        $university->favicon = $link;
        $university->save();
    }
}
