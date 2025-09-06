<?php

use App\Models\User;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Blog Management Backend Forms', function () {
    
    it('can access blog category creation form', function () {
        $response = $this->get('/add/blog/category');
        
        $response->assertStatus(200);
        $response->assertSee('Ajouter une catégorie');
        $response->assertSee('form');
        $response->assertSee('category_name');
    });

    it('can create a blog category', function () {
        $data = [
            'category_name' => 'Gravel Adventures',
            'category_slug' => 'gravel-adventures'
        ];

        $response = $this->post('/store/blog/category', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('blog_categories', [
            'category_name' => 'Gravel Adventures',
            'category_slug' => 'gravel-adventures'
        ]);
    });

    it('validates required fields for blog category', function () {
        $response = $this->post('/store/blog/category', []);
        
        $response->assertSessionHasErrors(['category_name']);
    });

    it('can edit existing blog category', function () {
        $category = BlogCategory::factory()->create([
            'category_name' => 'Original Category'
        ]);

        $response = $this->get("/edit/blog/category/{$category->id}");
        
        $response->assertStatus(200);
        $response->assertSee('Original Category');
    });

    it('can update blog category', function () {
        $category = BlogCategory::factory()->create([
            'category_name' => 'Original Category'
        ]);

        $data = [
            'category_id' => $category->id,
            'category_name' => 'Updated Category',
            'category_slug' => 'updated-category'
        ];

        $response = $this->post('/update/blog/category', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('blog_categories', [
            'id' => $category->id,
            'category_name' => 'Updated Category'
        ]);
    });

    it('can delete blog category', function () {
        $category = BlogCategory::factory()->create();

        $response = $this->get("/delete/blog/category/{$category->id}");
        
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('blog_categories', [
            'id' => $category->id
        ]);
    });

    it('can access blog post creation form', function () {
        $response = $this->get('/add/blog/post');
        
        $response->assertStatus(200);
        $response->assertSee('Ajouter un article');
        $response->assertSee('form');
        $response->assertSee('post_title');
        $response->assertSee('post_content');
    });

    it('can create a blog post with valid data', function () {
        $category = BlogCategory::factory()->create();
        $image = UploadedFile::fake()->image('blog-featured.jpg', 800, 600);
        
        $data = [
            'post_title' => 'My First Gravel Adventure',
            'post_slug' => 'my-first-gravel-adventure',
            'post_short_description' => 'A short description of my first gravel bike adventure',
            'post_content' => 'This is the full content of my blog post about gravel cycling...',
            'category_id' => $category->id,
            'post_tags' => 'gravel, cycling, adventure',
            'post_image' => $image,
            'meta_title' => 'My First Gravel Adventure - SEO Title',
            'meta_description' => 'SEO description for my gravel adventure blog post',
            'status' => 'published'
        ];

        $response = $this->post('/store/blog/post', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('blog_posts', [
            'post_title' => 'My First Gravel Adventure',
            'post_slug' => 'my-first-gravel-adventure',
            'category_id' => $category->id,
            'status' => 'published'
        ]);
    });

    it('validates required fields for blog post creation', function () {
        $response = $this->post('/store/blog/post', []);
        
        $response->assertSessionHasErrors(['post_title', 'post_content']);
    });

    it('can create blog post as draft', function () {
        $category = BlogCategory::factory()->create();
        
        $data = [
            'post_title' => 'Draft Blog Post',
            'post_content' => 'This is a draft blog post content',
            'category_id' => $category->id,
            'status' => 'draft'
        ];

        $response = $this->post('/store/blog/post', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('blog_posts', [
            'post_title' => 'Draft Blog Post',
            'status' => 'draft'
        ]);
    });

    it('can edit existing blog post', function () {
        $post = BlogPost::factory()->create([
            'post_title' => 'Original Post Title'
        ]);

        $response = $this->get("/edit/blog/post/{$post->id}");
        
        $response->assertStatus(200);
        $response->assertSee('Original Post Title');
        $response->assertSee('form');
    });

    it('can update existing blog post', function () {
        $category = BlogCategory::factory()->create();
        $post = BlogPost::factory()->create([
            'post_title' => 'Original Post Title',
            'category_id' => $category->id
        ]);

        $data = [
            'post_id' => $post->id,
            'post_title' => 'Updated Post Title',
            'post_content' => 'Updated blog post content',
            'category_id' => $category->id,
            'status' => 'published'
        ];

        $response = $this->post('/update/blog/post', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'post_title' => 'Updated Post Title',
            'post_content' => 'Updated blog post content'
        ]);
    });

    it('can upload featured image for blog post', function () {
        $category = BlogCategory::factory()->create();
        $image = UploadedFile::fake()->image('featured-image.jpg', 1200, 800);
        
        $data = [
            'post_title' => 'Post with Featured Image',
            'post_content' => 'Blog post content with featured image',
            'category_id' => $category->id,
            'post_image' => $image
        ];

        $response = $this->post('/store/blog/post', $data);
        
        $response->assertRedirect();
        
        $post = BlogPost::where('post_title', 'Post with Featured Image')->first();
        expect($post)->not->toBeNull();
        expect($post->post_image)->not->toBeNull();
    });

    it('validates image file type for blog post', function () {
        $category = BlogCategory::factory()->create();
        $invalidFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        
        $data = [
            'post_title' => 'Test Post',
            'post_content' => 'Test content',
            'category_id' => $category->id,
            'post_image' => $invalidFile
        ];

        $response = $this->post('/store/blog/post', $data);
        
        $response->assertSessionHasErrors(['post_image']);
    });

    it('can delete blog post', function () {
        $post = BlogPost::factory()->create();

        $response = $this->get("/delete/blog/post/{$post->id}");
        
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('blog_posts', [
            'id' => $post->id
        ]);
    });

    it('can access all blog posts list', function () {
        BlogPost::factory()->count(3)->create();
        
        $response = $this->get('/blog/post');
        
        $response->assertStatus(200);
        $response->assertSee('Liste des articles');
    });

    it('can access all blog categories list', function () {
        BlogCategory::factory()->count(3)->create();
        
        $response = $this->get('/blog/category');
        
        $response->assertStatus(200);
        $response->assertSee('Liste des catégories');
    });

    it('can view blog post details', function () {
        $post = BlogPost::factory()->create([
            'post_title' => 'Detailed Post'
        ]);

        $response = $this->get("/show/blog/post/{$post->id}");
        
        $response->assertStatus(200);
        $response->assertSee('Detailed Post');
    });

    it('validates post slug uniqueness', function () {
        $category = BlogCategory::factory()->create();
        
        // Create first post
        BlogPost::factory()->create([
            'post_slug' => 'unique-slug',
            'category_id' => $category->id
        ]);
        
        // Try to create second post with same slug
        $data = [
            'post_title' => 'Another Post',
            'post_slug' => 'unique-slug',
            'post_content' => 'Different content',
            'category_id' => $category->id
        ];

        $response = $this->post('/store/blog/post', $data);
        
        $response->assertSessionHasErrors(['post_slug']);
    });

    it('can handle blog post tags', function () {
        $category = BlogCategory::factory()->create();
        
        $data = [
            'post_title' => 'Tagged Post',
            'post_content' => 'Post with multiple tags',
            'category_id' => $category->id,
            'post_tags' => 'gravel, bikepacking, outdoor, france'
        ];

        $response = $this->post('/store/blog/post', $data);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('blog_posts', [
            'post_title' => 'Tagged Post',
            'post_tags' => 'gravel, bikepacking, outdoor, france'
        ]);
    });

    it('can access blog category details', function () {
        $category = BlogCategory::factory()->create([
            'category_name' => 'Detailed Category'
        ]);

        $response = $this->get("/show/blog/category/{$category->id}");
        
        $response->assertStatus(200);
        $response->assertSee('Detailed Category');
    });
});