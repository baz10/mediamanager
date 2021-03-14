<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Media;
use App\Models\Category;
use Illuminate\Support\Facades\File;


class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['mediaPayload'] = Media::join('categories', 'category_id', '=', 'media.fk_category_id')
        ->get(['media.*', 'categories.category_name']);
    
        return view('media.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['category'] = Category::all();
         return view('media.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'media_file' => 'required|mimes:jpg,png,jpeg,gif,svg,video/x-ms-asf,x-flv,mp4,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv,avi,audio/mpeg,mpga,mp3,wav',
            'description' => 'required',
        ]);


        $path = $request->file('media_file')->store('public/media');
        $media = new Media;
        $media->title = $request->title;
        $media->description = $request->description;
        $media->media_file = $path;
        $media->fk_category_id = $request->category_id;
        $media->save();
     



        return redirect()->route('media.index')
                        ->with('success','File has been stored successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        return view('media.view',compact('media'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $media = new Media;
        $data['media'] = $media->find($id);
        $data['category'] = Category::all();
        return view('media.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $media = Media::find($id);
        if($request->hasFile('media_file')){
            $request->validate([
              'media_file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            
            $path = $request->file('media_file')->store('public/media');
            $media->media_file = $path;
        }
        $media->title = $request->title;
        $media->description = $request->description;
        $media->fk_category_id = $request->category_id;
        $media->save();
    
        return redirect()->route('media.index')
                        ->with('success','Media updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        if(Storage::delete($media->media_file)) {
            $media->delete();
        }

        return redirect()->route('media.index')
                        ->with('success','Media has been deleted successfully');
    }
}
