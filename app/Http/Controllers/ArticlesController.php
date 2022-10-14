<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\ArticlesRepository;

class ArticlesController extends Controller
{
    protected $articlesRepo;

    public function __construct()
    {
        $this->articlesRepo = new ArticlesRepository();
    }

    /**
     * Display the home page with the jpbs
     *
     * @return Response
     */
    public function show(): Response
    {
        $page = getPageFromSlug("laravel-news");
        $data = [];

        if (!empty($page)) {
            $data = ["title" => $page->title . " - Laramotely", "description" => $page->meta_description, "url" => route("news.show")];
        }

        return Inertia::render("News/Index", $data)->withViewData(["title" => "Laramotely - " . $page->title, "description" => $page->meta_description, "url" => route("job.home")]);
    }

    /**
     * Return all the jobs for the home page based on the search criteria
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request["page"];
        $search = $request->get("search", "");
        $category = $request->get("category", "");

        $articles = Article::where(function ($query) use ($search) {
            $query
                ->where("title", "LIKE", "%{$search}%")
                ->orWhere("category", "LIKE", "%{$search}%")
                ->orWhere("description", "LIKE", "%{$search}%");
        });

        if (!empty($category)) {
            if ($category != "all") {
                $articles = $articles->where("category", $category);
            }
        }

        $articles = $articles->orderBy("posted_date", "desc")->paginate(12);

        return response()->json($articles);
    }
}
