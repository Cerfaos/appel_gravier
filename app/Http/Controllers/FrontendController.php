<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Sortie;
use App\Models\BlogPost;
use App\Services\CacheService;

class FrontendController extends Controller
{
    protected CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function index()
    {
        // Récupérer le premier slider ou créer un slider par défaut
        $slider = Slider::first();
        
        if (!$slider) {
            $slider = Slider::create([
                'title' => 'Découvrez l\'Aventure qui vous attend',
                'description' => 'Explorez les sentiers de montagne, campez sous les étoiles et reconnectez-vous avec la nature. Des aventures outdoor inoubliables vous attendent avec Cerfaos.',
                'image' => 'upload/no_image.jpg',
                'link' => '#'
            ]);
        }

        // Features supprimées - non utilisées dans la nouvelle landing page

        $latestItineraries = $this->cacheService->getPopularItineraries(3);

        // Récupérer les dernières sorties/expéditions avec cache
        $latestSorties = cache()->remember('latest_sorties_3', 1800, function () {
            return Sortie::where('status', 'published')
                ->with(['featuredImage', 'user'])
                ->latest('published_at')
                ->take(3)
                ->get();
        });

        // Récupérer les derniers articles de blog
        $latestBlogPosts = BlogPost::with('blogCategory')
        ->latest()
        ->take(3)
        ->get();

        return view('home.index', compact('slider', 'latestItineraries', 'latestSorties', 'latestBlogPosts'));
    }

    public function MonHistoire()
    {
        return view('home.histoire.histoire_page');
    }

    public function MonVelo()
    {
        return view('home.velo.velo_page');
    }

    public function BlogPage()
    {
        $posts = \App\Models\BlogPost::with('blogCategory')->latest()->get();
        $categories = \App\Models\BlogCategory::latest()->get();
        
        return view('home.blog.list_blog', compact('posts', 'categories'));
    }

    public function BlogDetails($slugOrId)
    {
        // Essayer d'abord par slug, puis par ID si le slug n'existe pas
        $blog = \App\Models\BlogPost::where('post_slug', $slugOrId)->with('blogCategory')->first();
        
        if (!$blog) {
            // Si pas trouvé par slug, essayer par ID
            $blog = \App\Models\BlogPost::where('id', $slugOrId)->with('blogCategory')->first();
        }
        
        if (!$blog) {
            abort(404);
        }
        
        $blogcat = \App\Models\BlogCategory::latest()->get();
        $recentpost = \App\Models\BlogPost::where('id', '!=', $blog->id)->latest()->limit(4)->get();
        
        return view('home.blog.blog_details', compact('blog', 'blogcat', 'recentpost'));
    }
}
