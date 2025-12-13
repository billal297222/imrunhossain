<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AmenitiesCategories;
use Illuminate\Http\Request;

class AmenitiesFeatureCategoryController extends Controller
{
    public function index()
    {
        return view('backend.layouts.AmenitiesCategory.index');
    }

    public function getData()
    {
        $data = AmenitiesCategories::all();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('status', function($row){
                $btnClass = $row->status == 'active' ? 'btn-success' : 'btn-danger';
                $btnText  = $row->status == 'active' ? 'Active' : 'Deactive';

                return '<button type="button" class="btn btn-sm '.$btnClass.' btn-toggle-status" data-id="'.$row->id.'">'
                        . $btnText .
                    '</button>';
            })
            ->addColumn('action', function($row){
                $btn = '<button type="button"
                            class="btn btn-sm btn-outline-primary btn-edit m-2"
                            data-id="' . $row->id . '"
                            data-title="' . $row->name . '">
                            <i class="bi bi-pencil fs-5"></i>
                        </button>';

                $btn .= '<button type="button"
                            class="btn btn-sm btn-outline-danger btn-delete"
                            data-id="' . $row->id . '">
                            <i class="bi bi-trash fs-5"></i>
                        </button>';

                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        AmenitiesCategories::create([
            'name' => $request->name
        ]);

        return response()->json(['message' => 'Amenities category created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = AmenitiesCategories::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return response()->json(['message' => 'Amenities category updated successfully.']);
    }

    public function destroy($id)
    {
        $category = AmenitiesCategories::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Amenities category deleted successfully.']);
    }

    public function toggleStatus($id)
    {
        $category = AmenitiesCategories::findOrFail($id);
        $category->status = $category->status === 'active' ? 'deactive' : 'active';
        $category->save();

        return response()->json(['message' => 'Amenities category status updated successfully.']);
    }
}
