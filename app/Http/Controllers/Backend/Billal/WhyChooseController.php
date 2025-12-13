<?php

namespace App\Http\Controllers\Backend\Billal;

use App\Http\Controllers\Controller;
use App\Models\WhyChoose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class WhyChooseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WhyChoose::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row){
                    $imageUrl = $row->image ? asset($row->image) : 'https://via.placeholder.com/60x60?text=No+Image';
                    return '<img src="'.$imageUrl.'" class="square-img">';
                })
                ->addColumn('overlay_text', function($row){
                    return $row->overlay_text ?: '<span class="text-muted">No Text</span>';
                })
                ->addColumn('status', function($row){
                    $statusText = $row->status ? 'Active' : 'Deactive';
                    $statusClass = $row->status ? 'success' : 'danger';
                    return '<button class="btn btn-sm btn-'.$statusClass.' btn-toggle-status" data-id="'.$row->id.'">'.$statusText.'</button>';
                })
                ->addColumn('action', function($row){
                    $imageUrl = $row->image ? asset($row->image) : '';

                    $toggleIcon = $row->status
                        ? '<i class="bi bi-toggle-on text-success"></i>'
                        : '<i class="bi bi-toggle-off text-danger"></i>';

                    $toggleBtn = '<button class="btn btn-sm btn-outline-secondary btn-toggle-status me-1" data-id="'.$row->id.'" title="Toggle Status">'.$toggleIcon.'</button>';

                    $editBtn = '<button class="btn btn-sm btn-info btn-edit me-1"
                        data-id="'.$row->id.'"
                        data-overlay_text="'.htmlspecialchars($row->overlay_text).'"
                        data-image="'.$imageUrl.'"
                        title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>';

                    $deleteBtn = '<button class="btn btn-sm btn-danger btn-delete" data-id="'.$row->id.'" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>';

                    return '<div class="d-flex gap-1">'.$toggleBtn.$editBtn.$deleteBtn.'</div>';
                })
                ->rawColumns(['image', 'overlay_text', 'status', 'action'])
                ->make(true);
        }

        return view('backend.layouts.billal.whychoose.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'overlay_text' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item = new WhyChoose();
        $item->overlay_text = $request->overlay_text;

        if($request->hasFile('image')){
            $path = $request->file('image')->store('whychoose', 'public');
            $item->image = '/storage/'.$path;
        }

        $item->status = true;
        $item->save();

        return response()->json([
            'message' => 'Entry created successfully',
            'item' => $item
        ]);
    }

    public function edit($id)
    {
        $item = WhyChoose::findOrFail($id);
        $item->image_url = $item->image ? asset($item->image) : null;
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'overlay_text' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item = WhyChoose::findOrFail($id);
        $item->overlay_text = $request->overlay_text;

        if($request->hasFile('image')){
            if($item->image){
                $oldPath = str_replace('/storage/', '', $item->image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('whychoose', 'public');
            $item->image = '/storage/'.$path;
        }

        $item->save();

        return response()->json([
            'message' => 'Entry updated successfully',
            'item' => $item
        ]);
    }

    public function destroy($id)
    {
        $item = WhyChoose::findOrFail($id);

        if($item->image){
            $oldPath = str_replace('/storage/', '', $item->image);
            Storage::disk('public')->delete($oldPath);
        }

        $item->delete();

        return response()->json([
            'message' => 'Entry deleted successfully',
            'id' => $id
        ]);
    }

    public function toggleStatus($id)
    {
        $item = WhyChoose::findOrFail($id);
        $item->status = !$item->status;
        $item->save();

        return response()->json([
            'message' => 'Status updated successfully',
            'status' => $item->status,
            'id' => $id
        ]);
    }
}
