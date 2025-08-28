<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Blogcat;
use App\Models\Carrental;
use App\Models\Tourpackage;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
        ];
    }

    public function index()
    {
        // Gate::allowIf(fn(User $user) => $user->email === 'admin@rentallombol.id');

        $title = "Blog";
        $blogs = Blog::with('blogcat:id,name,slug')
            ->latest()->paginate(8);
        $blogcats = Blogcat::latest()->get();
        $msg = session('msg');
        return inertia('Dashboard/Blog/Index', compact('title', 'blogs', 'blogcats', 'msg'));
    }

    public function create()
    {
        // Gate::allowIf(fn(User $user) => $user->email === 'admin@rentallombol.id');
        $title = "Create Blog";
        $blogcats = Blogcat::orderBy('name')->get();
        return inertia('Dashboard/Blog/Create', compact('title', 'blogcats'));
    }

    public function store(Request $request)
    {
        // Gate::allowIf(fn(User $user) => $user->email === 'admin@rentallombol.id');

        // Validate
        $fields = $request->validate([
            'title' => 'required|max:255|unique:blogs',
            'content' => 'required',
            'tags' => 'nullable|string',
            'blogcat_id' => 'required|integer|exists:blogcats,id',
            'banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $fields['slug'] = Str::slug($fields['title']);
        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));

        if ($request->hasFile('banner')) {
            $fields['banner'] = Storage::disk('public')->put('images/blogs', $request->banner);
        }

        $request->user()->blogs()->create($fields);

        return redirect()->route('blog.index')->with('msg', 'Blog berhasil ditambahkan');
    }

    public function show(Blog $blog)
    {
        $blog = $blog->load('blogcat:id,name');
        $latestBlogs = Blog::latest()->where('id', '!=', $blog->id)->take(4)->get();
        $otherCarrentals = Carrental::latest()->take(3)->get();
        $otherTourpackages = Tourpackage::latest()->take(3)->get();
        return inertia('BlogDetail', compact('blog', 'latestBlogs', 'otherCarrentals', 'otherTourpackages'));
    }

    public function edit(Blog $blog)
    {
        // Gate::allowIf(fn(User $user) => $user->email === 'admin@rentallombol.id');
        $title = "Edit Blog";
        $blogcats = Blogcat::orderBy('name')->get();
        return inertia('Dashboard/Blog/Edit', compact('title', 'blog', 'blogcats'));
    }

    public function update(Request $request, blog $blog)
    {
        // Gate::allowIf(fn(User $user) => $user->email === 'admin@rentallombol.id');

        $fields = $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title,' . $blog->id,
            'blogcat_id' => 'required|exists:blogcats,id',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'banner' => 'nullable|file|max:2084|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('banner')) {
            if ($blog->banner) {
                Storage::disk('public')->delete($blog->banner);
            }
            $fields['banner'] = Storage::disk('public')->put('images/blogs', $request->banner);
        } else {
            $fields['banner'] = $blog->banner;
        }

        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));
        $fields['slug'] = Str::slug($request->title);

        $blog->update($fields);

        return redirect()->route('blog.index')->with('msg', "Blog berhasil diupdate");
    }

    public function destroy(Blog $blog)
    {
        // Gate::allowIf(fn(User $user) => $user->email === 'admin@rentallombol.id');

        if ($blog->banner) {
            Storage::disk('public')->delete($blog->banner);
        }

        $blog->delete();

        return back()->with('msg', 'Blog berhasil dihapus');
    }
}
