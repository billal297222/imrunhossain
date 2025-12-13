<?php

namespace App\Http\Controllers\Backend\Billal;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    // List / DataTables
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<button class="btn btn-sm btn-success btn-toggle-status" data-id="'.$row->id.'">Active</button>'
                        : '<button class="btn btn-sm btn-danger btn-toggle-status" data-id="'.$row->id.'">Deactive</button>';
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-sm btn-info btn-edit"
                        data-id="'.$row->id.'"
                        data-que="'.htmlspecialchars($row->que).'"
                        data-ans="'.htmlspecialchars($row->ans).'">
                        <i class="bi bi-pencil-square"></i>
                     </button>';

                    $deleteBtn = '<button class="btn btn-sm btn-danger btn-delete" data-id="'.$row->id.'">
                        <i class="bi bi-trash"></i>
                      </button>';

                    // optional: small toggle button also in action column
                    $statusIcon = $row->status
                                    ? '<i class="bi bi-toggle-on"></i>'
                                    : '<i class="bi bi-toggle-off"></i>';

                    $toggleBtn = '<button type="button"
                    class="btn btn-sm btn-toggle-status px-3 py-1 me-1"
                    style="
                        font-size: 1.2rem;
                        border-radius: 20px;
                        color: '.($row->status ? '#28a745' : '#dc3545').';
                        background-color: #f8f9fa;
                        transition: background-color 0.3s, color 0.3s;
                    "
                    data-id="'.$row->id.'"
                    data-bs-toggle="tooltip"
                    title="Click to toggle status">'
                                                .$statusIcon.
                                              '</button>';

                    return $toggleBtn.' '.$editBtn.' '.$deleteBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);

        }

        return view('backend.layouts.billal.faq.index');
    }

    // Create FAQ
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'que' => 'required|string|max:255',
            'ans' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Faq::create([
            'que' => $request->que,
            'ans' => $request->ans,
            'status' => true, // default active
        ]);

        return response()->json(['message' => 'FAQ successfully created']);
    }

    // Update FAQ
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'que' => 'required|string|max:255',
            'ans' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $faq = Faq::findOrFail($id);
        $faq->update($request->only('que', 'ans'));

        return response()->json(['message' => 'FAQ updated successfully']);
    }

    // Delete FAQ
    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();

        return response()->json(['message' => 'FAQ deleted successfully']);
    }

    // Toggle Status
    public function toggleStatus($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->status = ! $faq->status;
        $faq->save();

        return response()->json([
            'message' => 'FAQ status updated successfully',
            'status' => $faq->status,
        ]);
    }
}
