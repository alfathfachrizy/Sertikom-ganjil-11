<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SchoolPackage;
use App\Models\SchoolSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SchoolSubmissionController extends Controller
{
    public function create(SchoolPackage $package): View
    {
        abort_unless($package->is_active, 404);

        return view('school-submissions.create', compact('package'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_package_id' => ['required', 'exists:school_packages,id'],
            'school_name' => ['required', 'string', 'max:255'],
            'pic_name' => ['required', 'max:255'],
            'pic_phone' => ['required', 'max:20'],
            'participant_count' => ['required', 'integer', 'min:1'],
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'school_package_id.required' => 'Paket sekolah wajib dipilih.',
            'school_package_id.exists' => 'Paket sekolah tidak ditemukan.',
            'school_name.required' => 'Nama sekolah wajib diisi.',
            'pic_name.required' => 'Nama penanggung jawab wajib diisi.',
            'pic_phone.required' => 'Nomor telepon penanggung jawab wajib diisi.',
            'participant_count.required' => 'Jumlah peserta wajib diisi.',
            'participant_count.integer' => 'Jumlah peserta harus berupa angka.',
            'participant_count.min' => 'Jumlah peserta minimal 1.',
            'visit_date.required' => 'Tanggal kunjungan wajib diisi.',
            'visit_date.after_or_equal' => 'Tanggal kunjungan tidak boleh sebelum hari ini.',
        ]);

        $package = SchoolPackage::findOrFail($validated['school_package_id']);
        abort_unless($package->is_active, 404);

        if ($validated['participant_count'] < $package->min_participants) {
            throw ValidationException::withMessages([
                'participant_count' => 'Jumlah peserta minimal '.$package->min_participants.' peserta.',
            ]);
        }

        $submission = DB::transaction(function () use ($package, $validated): SchoolSubmission {
            $subtotal = $package->price_per_participant * $validated['participant_count'];

            $orderCode = 'TNP-'.strtoupper(Str::random(8));
            while (Order::where('order_code', $orderCode)->exists()) {
                $orderCode = 'TNP-'.strtoupper(Str::random(8));
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => $orderCode,
                'order_type' => Order::TYPE_SCHOOL,
                'visit_date' => $validated['visit_date'],
                'total_amount' => $subtotal,
                'status' => Order::STATUS_PENDING_APPROVAL,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'ticket_id' => null,
                'school_package_id' => $package->id,
                'quantity' => $validated['participant_count'],
                'unit_price' => $package->price_per_participant,
                'subtotal' => $subtotal,
            ]);

            return SchoolSubmission::create([
                'order_id' => $order->id,
                'school_name' => $validated['school_name'],
                'pic_name' => $validated['pic_name'],
                'pic_phone' => $validated['pic_phone'],
                'participant_count' => $validated['participant_count'],
                'status' => SchoolSubmission::STATUS_PENDING,
            ]);
        });

        return redirect()->route('school-submissions.show', $submission)
            ->with('success', 'Pengajuan paket sekolah berhasil dikirim.');
    }

    public function show(SchoolSubmission $submission): View
    {
        Gate::authorize('view', $submission);
        $submission->load([
            'order.items.schoolPackage',
            'reviewer',
        ]);

        return view('school-submissions.show', compact('submission'));
    }
}
