<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
       return view('backend.layouts.Banner.index');
    }


   public function getData(Request $request)
    {
        $data=Banner::all();
        if($request->ajax()){
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                $image='<img src="' . asset($row->image) . '" alt="Banner Image" width="50" height="50"/>';
                return $image;
            })

            ->addColumn('short_description', function ($row) {
                $desc = strlen($row->short_description) > 50 ? substr($row->short_description, 0, 50) . '...' : $row->short_description;
                return $desc;
            })

                ->addColumn('action', function ($row) {
                    $imageUrl = $row->image
                    ? asset($row->image)
                    : asset('assets/images/placeholder.jpg');


                    $title = e($row->title ?? '');
                    $desc = e($row->short_description ?? '');
                    $bannerType = e($row->banner_type);
                    $id = (int) $row->id;

                    $btn = '<div class="d-flex gap-1">';


                    $btn .= '<button type="button"
                                class="btn btn-sm btn-outline-primary btn-edit"
                                data-id="' . $id . '"
                                data-title="' . $title . '"
                                data-short_description="' . $desc . '"
                                data-image="' . e($imageUrl) . '"
                                data-banner_type="' . $bannerType . '"
                                title="Edit Banner">
                                <i class="bi bi-pencil fs-5"></i>
                            </button>';


                    $btn .= '<button type="button"
                                class="btn btn-sm btn-outline-danger btn-delete"
                                data-id="' . $id . '"

                                title="Delete Banner">
                                <i class="bi bi-trash fs-5"></i>
                            </button>';

                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'banner_type' => 'required|string|max:100',
        ]);
        $banner = new Banner();
        $banner->title = $request->title;
        $banner->short_description = $request->short_description;
        $banner->banner_type = $request->banner_type;
        if($request->hasfile('image')){
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $filePath = 'uploads/banners/';
            $file->move(public_path($filePath), $filename);
            $banner->image = $filePath . $filename;
        }
        $banner->save();
        return response()->json(['success' => 'Banner created successfully.']);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'banner_type' => 'required|string|max:100',
        ]);
        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        $banner->short_description = $request->short_description;
        $banner->banner_type = $request->banner_type;
        if($request->hasfile('image')){
            if($banner->image && file_exists(public_path($banner->image))){
                unlink(public_path($banner->image));
            }
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $filePath = 'uploads/banners/';
            $file->move(public_path($filePath), $filename);
            $banner->image = $filePath . $filename;
        }
        $banner->save();
        return response()->json(['success' => 'Banner updated successfully.']);
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if($banner->image && file_exists(public_path($banner->image))){
            unlink(public_path($banner->image));
        }
        $banner->delete();
        return response()->json(['success' => 'Banner deleted successfully.']);
    }
}
