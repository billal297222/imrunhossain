<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AmenitiesCategories;
use App\Models\AmenitiesFeature;
use Illuminate\Http\Request;

class AmenitiesFeatureController extends Controller
{
    public function index()
    {
        $categories = AmenitiesCategories::where('status', 'active')->get();
        return view('backend.layouts.AmenitiesCategory.feature',compact('categories'));
    }

   public function getData(Request $request)
{
    $data = AmenitiesFeature::with('category')->get();   

    if ($request->ajax()) {
        return datatables()->of($data)
            ->addIndexColumn()
            
            ->addColumn('category_name', function (AmenitiesFeature $feature) {
                return $feature->category ? $feature->category->name : 'N/A';
            })
            



          ->addColumn('status', function($row){
                $btnClass = $row->status == 'active' ? 'btn-success' : 'btn-danger';
                $btnText  = $row->status == 'active' ? 'Active' : 'Deactive';

                return '<button type="button" class="btn btn-sm '.$btnClass.' btn-toggle-status" data-id="'.$row->id.'">'
                        . $btnText .
                    '</button>';
            })






            ->addColumn('icon', function (AmenitiesFeature $feature) {
                // Image tag for icon
                if ($feature->icon) {
                    return '<img src="' . asset($feature->icon) . '" alt="icon" style="width:30px;height:30px;">';
                }
                return '';
            })
            
            ->addColumn('action', function ($row) {
                // Pass all needed data for edit via data attributes
                $btn = '<a href="javascript:void(0)" 
                        data-id="' . $row->id . '"
                        data-name="' . htmlspecialchars($row->name, ENT_QUOTES) . '"
                        data-category_id="' . $row->category_id . '"
                        data-icon="'.asset($row->icon).'"
                        class="btn btn-sm btn-primary editBtn me-1">
                         <i class="bi bi-pencil fs-5"></i>
                        </a>';
                $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-danger deleteBtn">
                         <i class="bi bi-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action', 'icon', 'category_name', 'status'])
            ->make(true);
    }
}

public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:amenities_categories,id',
            'icon' => 'nullable|image|max:2048',
        ]);

        $feature = new AmenitiesFeature();
        $feature->name = $request->name;
        $feature->category_id = $request->category_id;

        if ($request->hasFile('icon')) {
            $file= $request->file('icon');  
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = 'uploads/amenities_icons/';
            $file->move(public_path($filePath), $fileName);
            $feature->icon = $filePath . $fileName; 

        }

        $feature->save();

        return response()->json(['message' => 'Feature created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:amenities_categories,id',
            'icon' => 'nullable|image|max:2048',
        ]);

        $feature = AmenitiesFeature::findOrFail($id);
        $feature->name = $request->name;
        $feature->category_id = $request->category_id;
        if ($request->hasFile('icon')) {
            if ($feature->icon && file_exists(public_path($feature->icon))) {
                unlink(public_path($feature->icon));
            }
            $file= $request->file('icon');  
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = 'uploads/amenities_icons/';
            $file->move(public_path($filePath), $fileName);
            $feature->icon = $filePath . $fileName; 
        }
        $feature->save();
        return response()->json(['message' => 'Feature updated successfully.']);

    }

    public function destroy($id)
    {
        $feature = AmenitiesFeature::findOrFail($id);
        if ($feature->icon && file_exists(public_path($feature->icon))) {
            unlink(public_path($feature->icon));
        }
        $feature->delete();

        return response()->json(['message' => 'Feature deleted successfully.']);
    }

    public function toggleStatus($id)
    {
        $feature = AmenitiesFeature::findOrFail($id);
        $feature->status = $feature->status === 'active' ? 'deactive' : 'active';
        $feature->save();

        return response()->json(['message' => 'Amenities feature status updated successfully.']);
    }

}
