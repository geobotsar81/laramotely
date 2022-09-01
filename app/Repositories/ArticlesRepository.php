<?php

namespace App\Repositories;

use App\Models\Article;

class ArticlesRepository
{
    /**
     * Save a article
     *
     * @param Array $data
     * @return void
     */
    public function save(array $data): void
    {
        $article = new Article();
        $article->title = $data["title"];
        $article->url = $data["url"];
        $article->category = $data["category"];
        $article->description = $data["description"];
        $article->posted_date = $data["date"];
        $article->image = $data["image"];
        $article->source = $data["source"];

        $foundUrl = $this->urlInDB($data["url"]);

        if (!$foundUrl["found"]) {
            $article->save();
        }
    }

    /**
     * Find if a url for a article exists in database
     *
     * @param string $url
     * @return array
     */
    public function urlInDB(string $url): array
    {
        $article = article::where("url", $url)->first();
        $found = !empty($article) ? true : false;

        return [
            "found" => $found,
            "article" => $article,
        ];
    }
}
