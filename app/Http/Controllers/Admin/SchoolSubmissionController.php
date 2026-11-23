<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SchoolSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SchoolSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $submissions = SchoolSubmission::query()
            ->with(['order.user', 'order.items.schoolPackage', 'reviewer'])
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate(10);

        return view('admin.school-submissions.index', compact('submissions'));
    }

    public function show(SchoolSubmission $submission): View
    {
        $submission->load([
            'order.user',
            'order.items.schoolPackage',
            'reviewer',
        ]);

        return view('admin.school-submissions.show', compact('submission'));
    }

    public function approve(SchoolSubmission $submission): RedirectResponse
    {
        if ($submission->status !== SchoolSubmission::STATUS_PENDING) {
            return redirect()->route('admin.school-submissions.show', $submission)
                ->with('error', 'Pengajuan ini sudah diproses.');
        }

        DB::transaction(function () use ($submission): void {
            $submission->update([
                'status' => SchoolSubmission::STATUS_APPROVED,
                'rejection_reason' => null,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
            $submission->order()->update([
                'status' => Order::STATUS_AWAITING_PAYMENT,
            ]);
        });

        return redirect()->route('admin.school-submissions.show', $submission)
            ->with('success', 'Pengajuan paket sekolah telah disetujui.');
    }

    public function reject(Request $request, SchoolSubmission $submission): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:5'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        if ($submission->status !== SchoolSubmission::STATUS_PENDING) {
            return redirect()->route('admin.school-submissions.show', $submission)
                ->with('error', 'Pengajuan ini sudah diproses.');
        }

        DB::transaction(function () use ($submission, $validated): void {
            $submission->update([
                'status' => SchoolSubmission::STATUS_REJECTED,
                'rejection_reason' => $validated['rejection_reason'],
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);
            $submission->order()->update([
                'status' => Order::STATUS_REJECTED,
            ]);
        });

        return redirect()->route('admin.school-submissions.show', $submission)
            ->with('success', 'Pengajuan paket sekolah telah ditolak.');
    }
}
