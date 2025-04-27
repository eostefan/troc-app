<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function destroy(Photo $photo)
    {
        $cloudinary = new Cloudinary();
        $cloudinary->uploadApi()->destroy($photo->public_id);

        Storage::disk('public')->delete($photo->filename);
        $photo->delete();

        return redirect()->back()->with('success', 'Item deleted!');
    }
}
