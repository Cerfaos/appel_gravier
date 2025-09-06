<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AboutContentController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\ContactController as BackendContactController;
use App\Http\Controllers\Backend\HomeContentController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\ItineraryController as BackendItineraryController;
use App\Http\Controllers\Backend\PpgController as BackendPpgController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SortieController as BackendSortieController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\PpgController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SortieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

Route::get('/verify', [AdminController::class, 'ShowVerification'])->name('custom.verification.form');

Route::post('/verify', [AdminController::class, 'VerificationVerify'])->name('custom.verification.verify');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'ProfileStore'])->name('profile.store');
    Route::post('/admin/password/update', [AdminController::class, 'PasswordUpdate'])->name('admin.password.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/all/review', 'AllReviews')->name('all.review');
        Route::get('/add/review', 'AddReview')->name('add.review');
        Route::post('/store/review', 'StoreReview')->name('store.review');
        Route::get('/edit/review/{id}', 'EditReview')->name('edit.review');
        Route::post('/update/review', 'UpdateReview')->name('update.review');
        Route::get('/delete/review/{id}', 'DeleteReview')->name('delete.review');
    });

    Route::controller(AboutContentController::class)->group(function () {
        Route::get('/about/content', 'index')->name('about.content.index');
        Route::get('/about/content/{key}/edit', 'edit')->name('about.content.edit');
        Route::put('/about/content/{key}', 'update')->name('about.content.update');
        Route::post('/about/content/reset', 'reset')->name('about.content.reset');
        Route::get('/about/content/preview', 'preview')->name('about.content.preview');
    });

    Route::controller(SliderController::class)->group(function () {
        Route::get('/get/slider', 'GetSlider')->name('get.slider');
        Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
        Route::get('/all/slider', 'AllSliders')->name('all.slider');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('/all/feature', 'AllFeature')->name('all.feature');
        Route::get('/add/feature', 'AddFeature')->name('add.feature');
        Route::post('/store/feature', 'StoreFeature')->name('store.feature');
        Route::get('/edit/feature/{id}', 'EditFeature')->name('edit.feature');
        Route::post('/update/feature', 'UpdateFeature')->name('update.feature');
        Route::get('/delete/feature/{id}', 'DeleteFeature')->name('delete.feature');
    });

    Route::controller(HomeContentController::class)->group(function () {
        Route::get('/home-content', 'index')->name('home-content.index');
        Route::get('/home-content/{id}/edit', 'edit')->name('home-content.edit');
        Route::put('/home-content/{id}', 'update')->name('home-content.update');
        Route::get('/home-content/slider/{id}/edit', 'editSlider')->name('home-content.edit-slider');
        Route::put('/home-content/slider/{id}', 'updateSlider')->name('home-content.update-slider');
    });

    Route::controller(BlogController::class)->group(function () {
        Route::get('/blog/category', 'AllBlogCategory')->name('all.blog.category');
        Route::get('/add/blog/category', 'AddBlogCategory')->name('add.blog.category');
        Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');
        Route::get('/show/blog/category/{id}', 'ShowBlogCategory')->name('show.blog.category');
        Route::get('/edit/blog/category/{id}', 'EditBlogCategory')->name('edit.blog.category');
        Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');

        Route::get('/blog/post', 'AllBlogPost')->name('all.blog.post');
        Route::get('/add/blog/post', 'AddBlogPost')->name('add.blog.post');
        Route::post('/store/blog/post', 'StoreBlogPost')->name('store.blog.post');
        Route::get('/show/blog/post/{id}', 'ShowBlogPost')->name('show.blog.post');
        Route::get('/edit/blog/post/{id}', 'EditBlogPost')->name('edit.blog.post');
        Route::post('/update/blog/post', 'UpdateBlogPost')->name('update.blog.post');
        Route::get('/delete/blog/post/{id}', 'DeleteBlogPost')->name('delete.blog.post');
        Route::get('/blog/post/details/{slug}', 'BlogPostDetails')->name('blog.post.details');
    });

});

// Routes publiques des itinéraires
Route::prefix('itineraires')->name('itineraries.')->group(function () {
    Route::get('/', [ItineraryController::class, 'index'])->name('index');
    Route::get('/{slug}', [ItineraryController::class, 'show'])->name('show');
});

// Routes publiques des sorties/expéditions
Route::prefix('sorties')->name('sorties.')->group(function () {
    Route::get('/', [SortieController::class, 'index'])->name('index');
    Route::get('/{slug}', [SortieController::class, 'show'])->name('show');
});

// Routes admin protégées (suivant le style Cerfaos existant)
Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    // Gestion des itinéraires dans l'admin (même style que vos routes reviews/sliders)
    Route::controller(BackendItineraryController::class)->group(function () {
        Route::get('/all/itinerary', 'index')->name('admin.all.itinerary');
        Route::get('/add/itinerary', 'create')->name('admin.add.itinerary');
        Route::post('/store/itinerary', 'store')->name('admin.store.itinerary');

        // EMERGENCY DEBUG ROUTE - NO VALIDATION
        Route::any('/debug/store/itinerary', function (\Illuminate\Http\Request $request) {
            \Log::emergency('DEBUG ROUTE HIT!', [
                'method' => $request->method(),
                'all_data' => $request->all(),
                'files' => $request->allFiles(),
            ]);

            return response()->json(['status' => 'debug route reached', 'data' => $request->all()]);
        })->name('admin.debug.store.itinerary');

        Route::get('/itinerary/{id}', 'show')->name('admin.show.itinerary');
        Route::get('/edit/itinerary/{id}', 'edit')->name('admin.edit.itinerary');
        Route::post('/update/itinerary', 'update')->name('admin.update.itinerary');
        Route::get('/delete/itinerary/{id}', 'destroy')->name('admin.delete.itinerary');

        // Actions supplémentaires
        Route::post('/publish/itinerary/{id}', 'publish')->name('admin.publish.itinerary');
        Route::post('/unpublish/itinerary/{id}', 'unpublish')->name('admin.unpublish.itinerary');
        Route::get('/delete/image/{id}', 'deleteImage')->name('admin.delete.image');
    });

    // Gestion des sorties/expéditions dans l'admin
    Route::controller(BackendSortieController::class)->group(function () {
        Route::get('/all/sortie', 'index')->name('admin.all.sortie');
        Route::get('/add/sortie', 'create')->name('admin.add.sortie');
        Route::post('/store/sortie', 'store')->name('admin.store.sortie');
        Route::get('/sortie/{id}', 'show')->name('admin.show.sortie');
        Route::get('/edit/sortie/{id}', 'edit')->name('admin.edit.sortie');
        Route::post('/update/sortie', 'update')->name('admin.update.sortie');
        Route::get('/delete/sortie/{id}', 'destroy')->name('admin.delete.sortie');

        // Actions supplémentaires
        Route::post('/publish/sortie/{id}', 'publish')->name('admin.publish.sortie');
        Route::post('/unpublish/sortie/{id}', 'unpublish')->name('admin.unpublish.sortie');
        Route::get('/delete/sortie/image/{id}', 'deleteImage')->name('admin.delete.sortie.image');
    });

    // Gestion des articles dans l'admin (style cohérent avec les autres contrôleurs)

    // Gestion PPG dans l'admin
    Route::controller(BackendPpgController::class)->group(function () {
        // Categories
        Route::get('/ppg/categories', 'categories')->name('admin.ppg.categories');
        Route::get('/ppg/categories/create', 'createCategory')->name('admin.ppg.categories.create');
        Route::post('/ppg/categories/store', 'storeCategory')->name('admin.ppg.categories.store');
        Route::get('/ppg/categories/{category}/edit', 'editCategory')->name('admin.ppg.categories.edit');
        Route::post('/ppg/categories/{category}/update', 'updateCategory')->name('admin.ppg.categories.update');
        Route::get('/ppg/categories/{category}/delete', 'deleteCategory')->name('admin.ppg.categories.delete');

        // Exercises
        Route::get('/ppg/exercises', 'exercises')->name('admin.ppg.exercises');
        Route::get('/ppg/exercises/create', 'createExercise')->name('admin.ppg.exercises.create');
        Route::post('/ppg/exercises/store', 'storeExercise')->name('admin.ppg.exercises.store');
        Route::get('/ppg/exercises/{exercise}', 'showExercise')->name('admin.ppg.exercises.show');
        Route::get('/ppg/exercises/{exercise}/edit', 'editExercise')->name('admin.ppg.exercises.edit');
        Route::post('/ppg/exercises/{exercise}/update', 'updateExercise')->name('admin.ppg.exercises.update');
        Route::get('/ppg/exercises/{exercise}/delete', 'deleteExercise')->name('admin.ppg.exercises.delete');

        // Programs
        Route::get('/ppg/programs', 'programs')->name('admin.ppg.programs');
        Route::get('/ppg/programs/create', 'createProgram')->name('admin.ppg.programs.create');
        Route::post('/ppg/programs/store', 'storeProgram')->name('admin.ppg.programs.store');
        Route::get('/ppg/programs/{program}', 'showProgram')->name('admin.ppg.programs.show');
        Route::get('/ppg/programs/{program}/edit', 'editProgram')->name('admin.ppg.programs.edit');
        Route::post('/ppg/programs/{program}/update', 'updateProgram')->name('admin.ppg.programs.update');
        Route::get('/ppg/programs/{program}/delete', 'deleteProgram')->name('admin.ppg.programs.delete');
    });

    // API Routes pour l'analyse GPX en temps réel
    Route::post('/api/gpx/analyze', [App\Http\Controllers\Api\GpxAnalysisController::class, 'analyze'])
        ->name('api.gpx.analyze');

});

// Routes publiques pour la mon histoire et le mon vélo
Route::get('/mon/histoire', [App\Http\Controllers\FrontendController::class, 'MonHistoire'])->name('mon.histoire');
Route::get('/mon/velo', [App\Http\Controllers\FrontendController::class, 'MonVelo'])->name('mon.velo');

// Routes PPG publiques
Route::get('/ppg', [PpgController::class, 'index'])->name('ppg');
Route::get('/ppg/fondation', [PpgController::class, 'fondation'])->name('ppg.fondation');
Route::get('/ppg/prepa', [PpgController::class, 'prepa'])->name('ppg.prepa');
Route::get('/ppg/recup', [PpgController::class, 'recup'])->name('ppg.recup');

Route::get('/blog', [App\Http\Controllers\FrontendController::class, 'BlogPage'])->name('blog.page');
Route::get('/blog/details/{slugOrId}', [App\Http\Controllers\FrontendController::class, 'BlogDetails'])->name('blog.details');

// Routes Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Routes Admin Contact
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::controller(BackendContactController::class)->group(function () {
        Route::get('/admin/contacts', 'index')->name('admin.contacts.index');
        Route::get('/admin/contacts/{id}', 'show')->name('admin.contacts.show');
        Route::post('/admin/contacts/{id}/update-status', 'updateStatus')->name('admin.contacts.update-status');
        Route::delete('/admin/contacts/{id}', 'destroy')->name('admin.contacts.destroy');
        Route::post('/admin/contacts/bulk-action', 'bulkAction')->name('admin.contacts.bulk-action');
    });
});
