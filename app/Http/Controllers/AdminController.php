<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Itinerary;
use App\Models\Sortie;
use App\Models\BlogPost;
use App\Models\Review;
use App\Models\Feature;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with enhanced statistics
     */
    public function Dashboard()
    {
        $stats = $this->getDashboardStats();
        $recentActivities = $this->getRecentActivities();
        $performanceMetrics = $this->getPerformanceMetrics();
        
        return view('admin.index-outdoor', compact('stats', 'recentActivities', 'performanceMetrics'));
    }
    
    /**
     * Display the modern ultra admin dashboard
     */
    public function UltraDashboard()
    {
        $stats = $this->getDashboardStats();
        $recentActivities = $this->getRecentActivities();
        $performanceMetrics = $this->getPerformanceMetrics();
        $systemHealth = $this->getSystemHealth();
        $analyticsData = $this->getAnalyticsData();
        
        return view('admin.index-ultra', compact('stats', 'recentActivities', 'performanceMetrics', 'systemHealth', 'analyticsData'));
    }
    
    /**
     * Get comprehensive dashboard statistics
     */
    private function getDashboardStats()
    {
        return Cache::remember('admin_dashboard_stats', 300, function () {
            $currentMonth = Carbon::now();
            $previousMonth = Carbon::now()->subMonth();
            
            return [
                'total_users' => User::count(),
                'total_itineraries' => Itinerary::count(),
                'total_sorties' => Sortie::count(),
                'total_blog_posts' => BlogPost::count(),
                'total_reviews' => Review::count(),
                'total_features' => Feature::count(),
                
                // Growth metrics
                'users_this_month' => User::whereMonth('created_at', $currentMonth->month)->count(),
                'itineraries_this_month' => Itinerary::whereMonth('created_at', $currentMonth->month)->count(),
                'sorties_this_month' => Sortie::whereMonth('created_at', $currentMonth->month)->count(),
                
                // Popular content
                'popular_itineraries' => Itinerary::orderBy('created_at', 'desc')->limit(5)->get(),
                'recent_sorties' => Sortie::with('user')->orderBy('created_at', 'desc')->limit(5)->get(),
                'latest_reviews' => Review::orderBy('created_at', 'desc')->limit(5)->get(),
                
                // System metrics
                'storage_used' => $this->getStorageUsage(),
                'cache_hit_rate' => $this->getCacheHitRate(),
                'avg_response_time' => $this->getAverageResponseTime(),
            ];
        });
    }
    
    /**
     * Get recent activities for dashboard
     */
    private function getRecentActivities()
    {
        $activities = collect();
        
        // Recent itineraries
        $recentItineraries = Itinerary::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'itinerary',
                    'title' => "Nouvel itinéraire: {$item->title}",
                    'user' => $item->user->name ?? 'Système',
                    'time' => $item->created_at,
                    'icon' => 'map',
                    'color' => 'text-blue-500'
                ];
            });
        
        // Recent sorties
        $recentSorties = Sortie::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'sortie',
                    'title' => "Nouvelle sortie: {$item->title}",
                    'user' => $item->user->name ?? 'Système',
                    'time' => $item->created_at,
                    'icon' => 'compass',
                    'color' => 'text-green-500'
                ];
            });
        
        // Recent blog posts
        $recentPosts = BlogPost::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'blog_post',
                    'title' => "Nouvel article: {$item->post_title}",
                    'user' => 'Admin',
                    'time' => $item->created_at,
                    'icon' => 'edit',
                    'color' => 'text-purple-500'
                ];
            });
        
        return $activities
            ->merge($recentItineraries)
            ->merge($recentSorties)
            ->merge($recentPosts)
            ->sortByDesc('time')
            ->take(10)
            ->values();
    }
    
    /**
     * Get performance metrics
     */
    private function getPerformanceMetrics()
    {
        return [
            'database_queries' => DB::getQueryLog() ? count(DB::getQueryLog()) : 0,
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak_memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
            'uptime' => $this->getSystemUptime(),
            'active_users' => $this->getActiveUsersCount(),
        ];
    }
    
    /**
     * Get storage usage statistics
     */
    private function getStorageUsage()
    {
        try {
            $totalSpace = disk_total_space(storage_path());
            $freeSpace = disk_free_space(storage_path());
            $usedSpace = $totalSpace - $freeSpace;
            
            return [
                'total' => $this->formatBytes($totalSpace),
                'used' => $this->formatBytes($usedSpace),
                'free' => $this->formatBytes($freeSpace),
                'percentage' => round(($usedSpace / $totalSpace) * 100, 2)
            ];
        } catch (\Exception $e) {
            return [
                'total' => 'N/A',
                'used' => 'N/A',
                'free' => 'N/A',
                'percentage' => 0
            ];
        }
    }
    
    /**
     * Get cache hit rate
     */
    private function getCacheHitRate()
    {
        // This is a simplified implementation
        // In production, you'd want to use a proper cache analytics solution
        return \random_int(75, 95); // Simulated cache hit rate
    }
    
    /**
     * Get average response time
     */
    private function getAverageResponseTime()
    {
        // This is a simplified implementation
        // In production, you'd track this with proper monitoring
        return \random_int(150, 300); // Simulated response time in ms
    }
    
    /**
     * Get system uptime
     */
    private function getSystemUptime()
    {
        try {
            $uptime = shell_exec('uptime -p');
            return $uptime ? trim($uptime) : 'N/A';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
    
    /**
     * Get active users count (users active in last 24 hours)
     */
    private function getActiveUsersCount()
    {
        return User::where('updated_at', '>=', Carbon::now()->subDay())->count();
    }
    
    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
    
    /**
     * Global search functionality
     */
    public function GlobalSearch(Request $request)
    {
        $query = $request->get('q');
        $limit = $request->get('limit', 10);
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json(['results' => []]);
        }
        
        $results = [];
        
        // Search itineraries
        $itineraries = Itinerary::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'itinerary',
                    'title' => $item->title,
                    'subtitle' => substr($item->description, 0, 100) . '...',
                    'url' => route('admin.itinerary.show', $item->id),
                    'icon' => 'map',
                    'color' => 'text-blue-500'
                ];
            });
        
        // Search sorties
        $sorties = Sortie::where('title', 'LIKE', "%{$query}%")
            ->orWhere('experience', 'LIKE', "%{$query}%")
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'sortie',
                    'title' => $item->title,
                    'subtitle' => 'Sortie du ' . $item->created_at->format('d/m/Y'),
                    'url' => route('admin.sorties.show', $item->id),
                    'icon' => 'compass',
                    'color' => 'text-green-500'
                ];
            });
        
        // Search blog posts
        $blogPosts = BlogPost::where('post_title', 'LIKE', "%{$query}%")
            ->orWhere('short_description', 'LIKE', "%{$query}%")
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'blog_post',
                    'title' => $item->post_title,
                    'subtitle' => $item->short_description,
                    'url' => route('blog.post.show', $item->id),
                    'icon' => 'edit',
                    'color' => 'text-purple-500'
                ];
            });
        
        // Search users
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'user',
                    'title' => $item->name,
                    'subtitle' => $item->email,
                    'url' => route('admin.user.show', $item->id),
                    'icon' => 'user',
                    'color' => 'text-gray-500'
                ];
            });
        
        $results = collect()
            ->merge($itineraries)
            ->merge($sorties)
            ->merge($blogPosts)
            ->merge($users)
            ->take($limit);
        
        return response()->json(['results' => $results]);
    }
    
    /**
     * Get system notifications
     */
    public function GetNotifications()
    {
        $notifications = collect();
        
        // System notifications
        $systemChecks = $this->performSystemChecks();
        foreach ($systemChecks as $check) {
            if (!$check['status']) {
                $notifications->push([
                    'type' => 'warning',
                    'title' => 'Alerte Système',
                    'message' => $check['message'],
                    'time' => now(),
                    'icon' => 'alert-triangle',
                    'color' => 'text-yellow-500'
                ]);
            }
        }
        
        // Recent user registrations
        $recentUsers = User::where('created_at', '>=', Carbon::now()->subDay())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        foreach ($recentUsers as $user) {
            $notifications->push([
                'type' => 'info',
                'title' => 'Nouvel utilisateur',
                'message' => "{$user->name} s'est inscrit",
                'time' => $user->created_at,
                'icon' => 'user-plus',
                'color' => 'text-green-500'
            ]);
        }
        
        // Recent content
        $recentItineraries = Itinerary::where('created_at', '>=', Carbon::now()->subDay())
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        foreach ($recentItineraries as $itinerary) {
            $notifications->push([
                'type' => 'success',
                'title' => 'Nouvel itinéraire',
                'message' => "Itinéraire '{$itinerary->title}' publié",
                'time' => $itinerary->created_at,
                'icon' => 'map',
                'color' => 'text-blue-500'
            ]);
        }
        
        return $notifications->sortByDesc('time')->take(10)->values();
    }
    
    /**
     * Perform system health checks
     */
    private function performSystemChecks()
    {
        $checks = [];
        
        // Check storage space
        $storage = $this->getStorageUsage();
        $checks[] = [
            'name' => 'storage',
            'status' => $storage['percentage'] < 90,
            'message' => $storage['percentage'] >= 90 ? 'Espace de stockage faible (' . $storage['percentage'] . '%)' : 'Espace de stockage OK'
        ];
        
        // Check database connection
        try {
            DB::connection()->getPdo();
            $checks[] = [
                'name' => 'database',
                'status' => true,
                'message' => 'Base de données connectée'
            ];
        } catch (\Exception $e) {
            $checks[] = [
                'name' => 'database',
                'status' => false,
                'message' => 'Erreur de connexion à la base de données'
            ];
        }
        
        // Check cache
        try {
            Cache::put('health_check', 'ok', 60);
            $cacheStatus = Cache::get('health_check') === 'ok';
            $checks[] = [
                'name' => 'cache',
                'status' => $cacheStatus,
                'message' => $cacheStatus ? 'Cache fonctionnel' : 'Erreur de cache'
            ];
        } catch (\Exception $e) {
            $checks[] = [
                'name' => 'cache',
                'status' => false,
                'message' => 'Erreur de cache'
            ];
        }
        
        return $checks;
    }
    
    /**
     * Clear application cache
     */
    public function ClearCache()
    {
        try {
            Cache::flush();
            
            $notification = [
                'message' => 'Cache vidé avec succès',
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            Log::error('Cache clear failed: ' . $e->getMessage());
            
            $notification = [
                'message' => 'Erreur lors du vidage du cache',
                'alert-type' => 'error'
            ];
        }
        
        return redirect()->back()->with($notification);
    }
    
    /**
     * Export system data
     */
    public function ExportData(Request $request)
    {
        $type = $request->get('type', 'all');
        $format = $request->get('format', 'json');
        
        $data = [];
        
        switch ($type) {
            case 'users':
                $data = User::all();
                break;
            case 'itineraries':
                $data = Itinerary::with(['user', 'images', 'gpxPoints'])->get();
                break;
            case 'sorties':
                $data = Sortie::with(['user', 'sortieImages'])->get();
                break;
            case 'stats':
                $data = $this->getDashboardStats();
                break;
            default:
                $data = [
                    'users' => User::count(),
                    'itineraries' => Itinerary::count(),
                    'sorties' => Sortie::count(),
                    'blog_posts' => BlogPost::count(),
                    'reviews' => Review::count(),
                    'features' => Feature::count(),
                    'exported_at' => now()->toISOString()
                ];
        }
        
        $filename = 'cerfaos_' . $type . '_' . date('Y-m-d_H-i-s');
        
        if ($format === 'csv' && is_array($data)) {
            // Convert to CSV format
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            ];
            
            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');
                
                if (!empty($data)) {
                    fputcsv($file, array_keys((array) $data[0]));
                    foreach ($data as $row) {
                        fputcsv($file, (array) $row);
                    }
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        }
        
        // Default to JSON
        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '.json"');
    }
    
    /**
     * Get system health data for ultra dashboard
     */
    private function getSystemHealth()
    {
        return Cache::remember('system_health', 60, function () {
            $health = [];
            
            // Server health (simulated)
            $health['server'] = [
                'status' => 'healthy',
                'uptime' => '98.5%',
                'response_time' => \random_int(15, 45) . 'ms',
                'load' => \random_int(10, 30) / 10
            ];
            
            // Database health
            try {
                $start = microtime(true);
                DB::connection()->getPdo();
                $end = microtime(true);
                $responseTime = round(($end - $start) * 1000);
                
                $health['database'] = [
                    'status' => 'healthy',
                    'response_time' => $responseTime . 'ms',
                    'connections' => DB::select('SHOW STATUS LIKE "Threads_connected"')[0]->Value ?? 'N/A'
                ];
            } catch (\Exception $e) {
                $health['database'] = [
                    'status' => 'error',
                    'response_time' => 'N/A',
                    'connections' => 'N/A'
                ];
            }
            
            // Cache health
            try {
                Cache::put('health_test', 'ok', 60);
                $cacheStatus = Cache::get('health_test') === 'ok';
                
                $health['cache'] = [
                    'status' => $cacheStatus ? 'healthy' : 'warning',
                    'hit_rate' => \random_int(75, 95) . '%',
                    'size' => \random_int(50, 200) . 'MB'
                ];
            } catch (\Exception $e) {
                $health['cache'] = [
                    'status' => 'error',
                    'hit_rate' => 'N/A',
                    'size' => 'N/A'
                ];
            }
            
            // Storage health
            $totalSpace = disk_total_space('/');
            $freeSpace = disk_free_space('/');
            $usedSpace = $totalSpace - $freeSpace;
            $usagePercentage = round(($usedSpace / $totalSpace) * 100, 1);
            
            $health['storage'] = [
                'status' => $usagePercentage < 85 ? 'healthy' : ($usagePercentage < 95 ? 'warning' : 'critical'),
                'total' => $this->formatBytes($totalSpace),
                'used' => $this->formatBytes($usedSpace),
                'free' => $this->formatBytes($freeSpace),
                'usage_percentage' => $usagePercentage
            ];
            
            return $health;
        });
    }
    
    /**
     * Get analytics data for charts and visualizations
     */
    private function getAnalyticsData()
    {
        return Cache::remember('analytics_data', 300, function () {
            $data = [];
            
            // Generate sample traffic data for the last 30 days
            $data['traffic'] = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $data['traffic'][] = [
                    'date' => $date->format('Y-m-d'),
                    'visitors' => \random_int(800, 1500),
                    'page_views' => \random_int(2000, 4000),
                    'bounce_rate' => \random_int(25, 45)
                ];
            }
            
            // Generate sample conversion data
            $data['conversions'] = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $data['conversions'][] = [
                    'date' => $date->format('Y-m-d'),
                    'rate' => \random_int(12, 18),
                    'total' => \random_int(50, 150)
                ];
            }
            
            // Top referrers data
            $data['referrers'] = [
                ['name' => 'Instagram', 'visitors' => 3550, 'percentage' => 32.5],
                ['name' => 'Facebook', 'visitors' => 2245, 'percentage' => 20.6],
                ['name' => 'Google', 'visitors' => 1998, 'percentage' => 18.3],
                ['name' => 'Direct', 'visitors' => 1756, 'percentage' => 16.1],
                ['name' => 'Twitter', 'visitors' => 986, 'percentage' => 9.0],
                ['name' => 'YouTube', 'visitors' => 354, 'percentage' => 3.2]
            ];
            
            // Device breakdown
            $data['devices'] = [
                ['type' => 'Mobile', 'percentage' => 58.7],
                ['type' => 'Desktop', 'percentage' => 32.1],
                ['type' => 'Tablet', 'percentage' => 9.2]
            ];
            
            return $data;
        });
    }
    
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    // Fin de la méthode AdminLogout

    public function AdminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $verificationCode = \random_int(100000, 999999);

            session(['verification_code' => $verificationCode, 'user_id' => $user->id]);

            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

            Auth::logout();

            return redirect()->route('custom.verification.form')->with('status', 'Code de vérification envoyé à votre email');
        }

        return redirect()->back()->withErrors(['email' => 'Identifiants invalides']);
    }
    // Fin de la méthode AdminLogin

    public function ShowVerification()
    {
        return view('auth.verify');
    }
    // Fin de la méthode ShowVerification

    public function VerificationVerify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);
        if ($request->code == session('verification_code')) {
            Auth::loginUsingId(session('user_id'));
            session()->forget(['verification_code', 'user_id']);
            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['code' => 'Code de vérification invalide']);
    }
    // Fin de la méthode VerificationVerify

    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }
    // Fin de la méthode AdminProfile

    public function ProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $oldPhotoPath = $data->photo;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $filename);
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }
        $data->save();

        $notification = array(
            'message' => 'Profil mis à jour avec succès',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/user_images/'.$oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function PasswordUpdate(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            $notification = array(
                'message' => 'Ancien mot de passe incorrect',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Auth::logout();

        $notification = array(
            'message' => 'Mot de passe mis à jour avec succès',
            'alert-type' => 'success'
        );
        return redirect()->route('login')->with($notification);
    }
}
