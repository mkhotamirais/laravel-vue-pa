<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Carrental;
use App\Models\Tourimage;
use App\Models\Tourpackage;
use App\Models\Tourpackagecat;
use App\Models\Tourroute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourpackageController extends Controller
{
    public function index()
    {
        $title = "Tour Package";
        $tourpackages = Tourpackage::orderBy('name', 'asc')->paginate(8);
        $msg = session('msg');

        return inertia('Dashboard/Tourpackage/Index', compact('title', 'tourpackages', 'msg'));
    }

    public function create()
    {
        $title = "Create Tour Package";
        $tourpackagecats = Tourpackagecat::orderBy('name', 'asc')->get();
        $tourroutes = Tourroute::orderBy('name', 'asc')->get();
        return inertia('Dashboard/Tourpackage/Create', compact('title', 'tourpackagecats', 'tourroutes'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255|unique:tourpackages',
            'price' => 'required|integer',
            'price_detail' => 'nullable',
            'status' => 'required|in:active,inactive',
            'itenary_description' => 'nullable',
            'itenary_detail' => 'nullable',
            'policy_description' => 'nullable',
            'policy_detail' => 'nullable',
            'info_description' => 'nullable',
            'info_detail' => 'nullable',
            'tourroutes' => 'required|array|min:1',
            'tourroutes.*' => 'exists:tourroutes,id',
            'banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tourpackagecat_id' => 'required|integer|exists:tourpackagecats,id',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
        ]);

        $slug = Str::slug($fields['name']);

        // Upload image if file exist
        $path = null;
        if ($request->hasFile('banner')) {
            $path = Storage::disk('public')->put('images/tourpackages', $request->banner);
        }

        $tourpackage = $request->user()->tourpackages()->create([...$fields, 'slug' => $slug, 'banner' => $path]);

        // Simpan gambar-gambar ke storage dan database
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/tourpackages', 'public');
                $tourpackage->tourimages()->create(['image_path' => $path]);
            }
        }

        $tourpackage->tourroutes()->attach($fields['tourroutes']);

        return redirect()->route('paket-wisata.index')->with('success', 'Tourpackage created successfully');
    }

    public function show(Tourpackage $tourpackage)
    {
        $tourpackage = $tourpackage->load('tourimages', 'tourroutes:id,name,slug', 'tourpackagecat:id,name,slug');
        $otherTourpackages = Tourpackage::latest()->where('id', '!=', $tourpackage->id)->take(4)->get();
        $latestBlogs = Blog::latest()->take(3)->get();
        $otherCarrentals = Carrental::latest()->take(3)->get();

        return inertia('TourpackageDetail', compact('tourpackage', 'latestBlogs', 'otherTourpackages', 'otherCarrentals'));
    }

    public function edit(Request $request, Tourpackage $tourpackage)
    {
        $title = "Edit Tour Package";
        $tourpackage = $tourpackage->load('tourimages', 'tourroutes');
        $tourpackagecats = Tourpackagecat::orderBy('name', 'asc')->get();
        $tourroutes = Tourroute::orderBy('name', 'asc')->get();
        return inertia('Dashboard/Tourpackage/Edit', compact('title', 'tourpackage', 'tourpackagecats', 'tourroutes'));
    }

    public function update(Request $request, Tourpackage $tourpackage)
    {
        // Validate
        $fields = $request->validate([
            'name' => "required|max:255|unique:tourpackages,name,$tourpackage->id",
            'price' => 'required|integer',
            'price_detail' => 'nullable',
            'status' => 'sometimes|in:active,inactive',
            'itenary_description' => 'nullable',
            'itenary_detail' => 'nullable',
            'policy_description' => 'nullable',
            'policy_detail' => 'nullable',
            'info_description' => 'nullable',
            'info_detail' => 'nullable',
            'tourroutes' => 'required|array|min:1',
            'tourroutes.*' => 'exists:tourroutes,id',
            'banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:tourimages,id',
            'tourpackagecat_id' => 'required|integer|exists:tourpackagecats,id',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
        ]);

        $slug = Str::slug($fields['name']);

        // Upload image if file exist
        $path = null;
        if ($request->hasFile('banner')) {
            $path = Storage::disk('public')->put('images/tourpackages', $request->banner);
        }

        $path = $tourpackage->banner ?? null;
        if ($request->hasFile('banner')) {
            if ($tourpackage->banner) {
                Storage::disk('public')->delete($tourpackage->banner);
            }
            $path = Storage::disk('public')->put('images/tourpackages', $request->banner);
        }
        // Update the tourpackage
        $tourpackage->update([...$fields, 'slug' => $slug, 'banner' => $path]);

        // Sinkronisasi tourroutes jika ada
        if ($request->has('tourroutes')) {
            $tourpackage->tourroutes()->sync($fields['tourroutes']);
        }

        // Hapus gambar yang dipilih
        if ($request->has('delete_images')) {
            $imagesToDelete = Tourimage::whereIn('id', $request->delete_images)->get();
            foreach ($imagesToDelete as $image) {
                // Hapus file fisik
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                // Hapus data dari database
                $image->delete();
            }
        }

        // Tambahkan gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/tourpackages', 'public');
                $tourpackage->tourimages()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('paket-wisata.index')->with('success', 'Tourpackage updaed successfully');
    }

    public function destroy(Tourpackage $tourpackage)
    {
        foreach ($tourpackage->tourimages as $image) {
            $filePath = $image->image_path;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            } else {
            }
            $image->delete(); // Hapus data dari database
        }

        if ($tourpackage->banner) {
            Storage::disk('public')->delete($tourpackage->banner);
        }

        $tourpackage->delete();

        return back()->with('delete', 'Tourpackage deleted successfully');
    }
}
