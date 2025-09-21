<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Carrental;
use App\Models\Tourpackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarrentalController extends Controller
{
    // public static function middleware(): array
    // {
    //     return [
    //         new Middleware('auth', except: ['index', 'show']),
    //     ];
    // }

    public function index(Request $request)
    {
        $title = "Car Rental";
        $carrentals = Carrental::orderByRaw("FIELD(category, 'lepas_kunci', 'include_driver')")
            ->orderBy('price')
            ->paginate(8);

        $msg = session('msg');
        return inertia('Dashboard/Carrental/Index', compact('title', 'carrentals', 'msg'));
    }

    public function create(Request $request)
    {
        $title = "Create Car Rental";
        return inertia('Dashboard/Carrental/Create', compact('title'));
    }

    public function store(Request $request)
    {
        // Validate
        $fields = $request->validate([
            'name' => 'required|max:255|unique:carrentals',
            'price' => 'required|integer',
            'banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'policy' => 'required',
            'information' => 'nullable',
            'category' => 'required|in:lepas_kunci,include_driver',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
        ]);

        $fields['slug'] = Str::slug($fields['name']);

        if ($request->hasFile('banner')) {
            $fields['banner'] = Storage::disk('public')->put('images/carrentals', $request->banner);
        }

        $request->user()->carrentals()->create($fields);

        return redirect()->route('rental-mobil.index')->with('msg', 'Data berhasil ditambahkan');
    }

    public function show(Carrental $carrental)
    {
        $otherCarrentals = Carrental::where('id', '!=', $carrental->id)->take(4)->get();
        $latestBlogs = Blog::latest()->take(3)->get();
        $otherTourpackages = Tourpackage::latest()->take(3)->get();

        return inertia('CarrentalDetail', compact('carrental', 'otherCarrentals', 'latestBlogs', 'otherTourpackages'));
    }

    public function edit(Carrental $carrental)
    {
        $title = "Update Car Rental";
        return inertia('Dashboard/Carrental/Edit', compact('title', 'carrental'));
    }

    public function update(Request $request, Carrental $carrental)
    {
        // Validate
        $fields = $request->validate([
            'name' => 'required|max:255|unique:carrentals,name,' . $carrental->id,
            'price' => 'required|integer',
            'banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'policy' => 'required',
            'information' => 'nullable',
            'category' => 'required|in:lepas_kunci,include_driver',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
        ]);

        $fields['slug'] = Str::slug($fields['name']);

        if ($request->hasFile('banner')) {
            if ($carrental->banner) {
                Storage::disk('public')->delete($carrental->banner);
            }
            $fields['banner'] = Storage::disk('public')->put('images/carrentals', $request->banner);
        } else {
            $fields['banner'] = $carrental->banner;
        }

        $carrental->update($fields);
        return redirect()->route('rental-mobil.index')->with('msg', 'Data berhasil diupdate');
    }

    public function destroy(Carrental $carrental)
    {
        if ($carrental->banner) {
            Storage::disk('public')->delete($carrental->banner);
        }
        $carrental->delete();
        return redirect()->route('rental-mobil.index')->with('msg', 'Data berhasil dihapus');
    }
}
