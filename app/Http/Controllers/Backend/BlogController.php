<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use App\Models\BlogPost;


class BlogController extends Controller
{
    public function AllBlogCategory()
    {
        $category = BlogCategory::latest()->get();
        return view('admin.backend.blogcategory.blog_category', compact('category'));
    }

    public function AddBlogCategory()
    {
        return view('admin.backend.blogcategory.add_blog_category');
    }

    public function StoreBlogCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:blog_categories,category_name',
        ], [
            'category_name.required' => 'Le nom de la catégorie est requis',
            'category_name.unique' => 'Cette catégorie existe déjà'
        ]);

        BlogCategory::create([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
        ]);

        $notification = [
            'message' => 'Catégorie de blog créée avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function EditBlogCategory($id)
    {
        $category = BlogCategory::find($id);
        return view('admin.backend.blogcategory.edit_blog_category', compact('category'));
    }

    public function UpdateBlogCategory(Request $request)
    {
        $id = $request->id;

        $request->validate([
            'category_name' => 'required|unique:blog_categories,category_name,' . $id,
        ], [
            'category_name.required' => 'Le nom de la catégorie est requis',
            'category_name.unique' => 'Cette catégorie existe déjà'
        ]);

        BlogCategory::find($id)->update([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
        ]);

        $notification = [
            'message' => 'Catégorie de blog mise à jour avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function ShowBlogCategory($id)
    {
        $category = BlogCategory::find($id);
        $posts = BlogPost::where('blog_category_id', $id)->latest()->get();
        return view('admin.backend.blogcategory.show_blog_category', compact('category', 'posts'));
    }

    public function DeleteBlogCategory($id)
    {
        BlogCategory::find($id)->delete();

        $notification = [
            'message' => 'Catégorie de blog supprimée avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function AllBlogPost()
    {
        $post = BlogPost::with('blogCategory')->latest()->get();
        return view('admin.backend.post.all_post', compact('post'));
    }

    public function AddBlogPost()
    {
        $category = BlogCategory::latest()->get();
        return view('admin.backend.post.add_post', compact('category'));
    }

    public function StoreBlogPost(Request $request)
    {
        $request->validate([
            'post_title' => 'required|unique:blog_posts,post_title',
            'short_description' => 'required|max:350',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'long_descp' => 'required|min:50',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'post_title.required' => 'Le titre de l\'article est requis',
            'post_title.unique' => 'Cet article existe déjà',
            'short_description.required' => 'La description courte est requise',
            'short_description.max' => 'La description ne doit pas dépasser 350 caractères',
            'blog_category_id.required' => 'Veuillez sélectionner une catégorie',
            'blog_category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
            'long_descp.required' => 'Le contenu de l\'article est requis',
            'long_descp.min' => 'Le contenu doit contenir au moins 50 caractères',
            'image.required' => 'Une image est requise',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'L\'image doit être au format JPG, PNG ou WEBP',
            'image.max' => 'L\'image ne doit pas dépasser 2MB',
        ]);

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('YmdHi') . '_' . $image->getClientOriginalName();
            $image->move(base_path('upload/blog/'), $imageName);
            $imageName = 'upload/blog/' . $imageName;
        }

        BlogPost::create([
            'blog_category_id' => $request->blog_category_id,
            'post_title' => $request->post_title,
            'post_slug' => Str::slug($request->post_title),
            'short_description' => $request->short_description,
            'long_descp' => $request->long_descp,
            'image' => $imageName,
        ]);

        $notification = [  
            'message' => 'Article de blog créé avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.blog.post')->with($notification);
    }

    public function EditBlogPost($id)
    {
        $post = BlogPost::find($id);
        $category = BlogCategory::latest()->get();
        return view('admin.backend.post.edit_post', compact('post', 'category'));
    }

    public function UpdateBlogPost(Request $request)
    {
        $id = $request->id;

        $request->validate([
            'post_title' => 'required|unique:blog_posts,post_title,' . $id,
            'short_description' => 'required|max:350',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'long_descp' => 'required|min:50',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'post_title.required' => 'Le titre de l\'article est requis',
            'post_title.unique' => 'Cet article existe déjà',
            'short_description.required' => 'La description courte est requise',
            'short_description.max' => 'La description ne doit pas dépasser 350 caractères',
            'blog_category_id.required' => 'Veuillez sélectionner une catégorie',
            'blog_category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
            'long_descp.required' => 'Le contenu de l\'article est requis',
            'long_descp.min' => 'Le contenu doit contenir au moins 50 caractères',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'L\'image doit être au format JPG, PNG ou WEBP',
            'image.max' => 'L\'image ne doit pas dépasser 2MB',
        ]);

        $post = BlogPost::find($id);
        $imageName = $post->image; // Keep current image by default

        // Handle new image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
            
            $image = $request->file('image');
            $imageName = date('YmdHi') . '_' . $image->getClientOriginalName();
            $image->move(base_path('upload/blog/'), $imageName);
            $imageName = 'upload/blog/' . $imageName;
        }

        $post->update([
            'blog_category_id' => $request->blog_category_id,
            'post_title' => $request->post_title,
            'post_slug' => Str::slug($request->post_title),
            'short_description' => $request->short_description,
            'long_descp' => $request->long_descp,
            'image' => $imageName,
        ]);

        $notification = [
            'message' => 'Article de blog mis à jour avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.blog.post')->with($notification);
    }

    public function ShowBlogPost($id)
    {
        $post = BlogPost::with('blogCategory')->find($id);
        return view('admin.backend.post.show_post', compact('post'));
    }

    public function DeleteBlogPost($id)
    {
        BlogPost::find($id)->delete();

        $notification = [
            'message' => 'Article de blog supprimé avec succès',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
