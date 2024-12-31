<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVideos;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{

    public function index()
    {
        return view('admin-views.videos.index');
    }

    public function store(Request $request)
    {
        // Step 1: Directly use the video ID from the request
        $videoId = $request->input('video_url'); // video_url contains the ID in your case

        // Check if the provided video ID is valid
        if (!is_numeric($videoId)) {
            Log::error('Invalid Vimeo video ID.', ['video_url' => $videoId]);
            return back()->with('error', 'Invalid Vimeo video ID. Please provide a valid ID.');
        }

        // Step 2: Fetch video data from Vimeo API
        $timeout = 10; // in seconds
        $duration = null;

        try {
            // Initialize cURL request
            $ch = curl_init("https://vimeo.com/api/v2/video/$videoId.json");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

            $res = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new Exception("cURL error: " . curl_error($ch));
            }

            $data = json_decode($res, true);

            if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
                throw new Exception("Invalid Vimeo API response");
            }

            // Set video duration in minutes
            $duration = $data[0]['duration'] / 60;
        } catch (Exception $e) {
            Log::error('Failed to fetch Vimeo data.', ['video_id' => $videoId, 'error' => $e->getMessage()]);
            return back()->with('error', 'Failed to fetch Vimeo data. Please check the video ID.');
        } finally {
            curl_close($ch);
        }

        // Step 3: Validate form input
        $validatedData = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'video_url'   => 'required|string|max:255',  // Corrected validation
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position'    => 'nullable|integer|min:0',
            'is_published' => 'nullable|in:on,off',
        ]);

        // Step 4: Handle thumbnail upload if provided
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Convert is_published to 0 or 1 for database storage
        $isPublished = ($validatedData['is_published'] === 'on') ? 1 : 0;

        // Step 5: Store video data in the database
        ProductVideos::create([
            'product_id'  => $validatedData['product_id'],
            'video_url'   => $validatedData['video_url'],
            'title'       => $validatedData['title'],
            'description' => $validatedData['description'],
            'thumbnail'   => $thumbnailPath,
            'duration'    => $duration,
            'position'    => $validatedData['position'] ?? 0,
            'is_published' => $isPublished,
        ]);

        // Step 6: Return success message
        Toastr::success('Product video added successfully.');
        return redirect()->back();
    }





    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
