<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary as Cloudinary;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Item::class, 'item');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Profile/Index', [
            'items' => Auth::user()
                            ->items()
                            ->withTrashed()
                            ->with('photos')
                            ->with('offers')
                            ->orderByDesc('created_at')
                            ->paginate(6)
                            ->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Profile/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'address.county' => 'required|string',
            'address.sector' => 'string'
        ]);

        $item = $request->user()->items()->create([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        $item->address()->create($validated['address']);

        if ($request->hasFile('images')) {

            $request->validate([
                'images.*' => 'mimes:jpg,png,jpeg,webp|max:5000'
            ], [
                'images.*.mimes' => 'Accepted files: jpg,png,jpeg,webp' 
            ]);

            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                $cloudinary = new Cloudinary();
                $uploadApi = $cloudinary->uploadApi();
                $result = $uploadApi->upload($file->getRealPath());

                $publicId = $result['public_id'];
                $url = $result['url'];

                $item->photos()->create([
                    'item_id' => $item->id,
                    'filename' => $path,
                    'public_id' => $publicId,
                    'url' => $url
                ]);
            }
        }

        return redirect()
                ->route('profile.items.index')
                ->with('success', 'Item created succesfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return inertia('Profile/Show', [
            'item' => $item->load(['offers', 'offers.user', 'address', 'photos', 'user'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        if ($item->sold_at !== null) {
            return redirect()->back()->with('success', 'You can no longer edit this item');
        }

        return inertia('Profile/Edit', [
            'item' => $item->load(['address', 'photos'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateItem(Request $request, Item $item)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|array',
            'address.county' => 'required|string',
            'address.sector' => 'string'
        ]);

        $item->update([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        $item->address()->update(
            $validated['address']
        );

        if ($request->hasFile('images')) {

            $request->validate(
                ['images.*' => 'mimes:jpg,png,jpeg,webp|max:5000'], 
                [ 'images.*.mimes' => 'Accepted files: jpg,png,jpeg,webp' ]
            );

            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                $cloudinary = new Cloudinary();
                $uploadApi = $cloudinary->uploadApi();
                $result = $uploadApi->upload($file->getRealPath());

                $publicId = $result['public_id'];
                $url = $result['url'];

                $item->photos()->updateOrCreate([
                    'filename' => $path,
                    'public_id' => $publicId,
                    'url' => $url
                ]);
            }
        }

        return redirect()
                ->route('profile.items.index')
                ->with('success', 'Item succesfully edited!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {

        $addresses = $item->address()->get();
        $photos = $item->photos()->get();

        $cloudinary = new Cloudinary();

        foreach ($photos as $photo) {
            $cloudinary->uploadApi()->destroy($photo->public_id);
            Storage::disk('public')->delete($photo->filename);
            $photo->delete();
        }

        foreach($addresses as $address) {
            $address->delete();
        }

        $item->deleteOrFail();
        return redirect()->back()->with('success', 'Item deleted succesfully!');
    }

    public function restore(Item $item)
    {
        $item->restore();
        return redirect()->back()->with('success', 'Item restored succesfully!');
    }
}
