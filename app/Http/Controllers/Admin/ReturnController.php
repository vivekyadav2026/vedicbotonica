<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use App\Services\ComboService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /**
     * Display a listing of return requests.
     */
    public function index(Request $request)
    {
        $query = ReturnRequest::with(['order', 'user'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $returns = $query->paginate(15);

        return view('admin.returns.index', compact('returns'));
    }

    /**
     * Display details of a specific return request.
     */
    public function show(ReturnRequest $returnRequest)
    {
        $returnRequest->load(['order.items', 'user', 'items.orderItem.components']);

        return view('admin.returns.show', compact('returnRequest'));
    }

    /**
     * Process return request approval or rejection.
     */
    public function updateStatus(Request $request, ReturnRequest $returnRequest)
    {
        $request->validate([
            'status' => 'required|string|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Security check: only pending requests can be processed to prevent double-restocking
        if ($returnRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This return request has already been processed.');
        }

        try {
            DB::transaction(function() use ($request, $returnRequest) {
                $status = $request->status;

                // Update return request status and admin notes
                $returnRequest->update([
                    'status' => $status,
                    'admin_notes' => $request->admin_notes,
                ]);

                // If approved, restock standard items or combo component ingredients
                if ($status === 'approved') {
                    $comboService = app(ComboService::class);
                    foreach ($returnRequest->items as $item) {
                        $orderItem = $item->orderItem;
                        if ($orderItem) {
                            $comboService->restoreItemStock($orderItem, $item->quantity);
                        }
                    }
                }
            });

            return redirect()->route('admin.returns.index')->with('success', 'Return request has been ' . $request->status . ' successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update return status: ' . $e->getMessage());
        }
    }
}
