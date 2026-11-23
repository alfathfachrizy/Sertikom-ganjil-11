<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolPackageController extends Controller
{
    public function index(): View
    {
        $packages = SchoolPackage::latest()->paginate(10);

        return view('admin.school-packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('admin.school-packages.create');
    }

    public function show(SchoolPackage $school_package): RedirectResponse
    {
        return redirect()->route('admin.school-packages.edit', $school_package);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'price_per_participant' => ['required', 'numeric', 'min:0'],
            'min_participants' => ['required', 'integer', 'min:1'],
            'is_active' => ['sometimes'],
        ], [
            'name.required' => 'Nama paket wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'price_per_participant.required' => 'Harga per peserta wajib diisi.',
            'price_per_participant.numeric' => 'Harga harus berupa angka.',
            'min_participants.required' => 'Jumlah peserta minimum wajib diisi.',
            'min_participants.integer' => 'Jumlah peserta minimum harus berupa angka.',
            'min_participants.min' => 'Jumlah peserta minimum minimal 1.',
        ]);

        SchoolPackage::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price_per_participant' => $validated['price_per_participant'],
            'min_participants' => $validated['min_participants'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.school-packages.index')
            ->with('success', 'Paket sekolah berhasil ditambahkan.');
    }

    public function edit(SchoolPackage $school_package): View
    {
        return view('admin.school-packages.edit', ['package' => $school_package]);
    }

    public function update(Request $request, SchoolPackage $school_package): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'price_per_participant' => ['required', 'numeric', 'min:0'],
            'min_participants' => ['required', 'integer', 'min:1'],
            'is_active' => ['sometimes'],
        ], [
            'name.required' => 'Nama paket wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'price_per_participant.required' => 'Harga per peserta wajib diisi.',
            'price_per_participant.numeric' => 'Harga harus berupa angka.',
            'min_participants.required' => 'Jumlah peserta minimum wajib diisi.',
            'min_participants.integer' => 'Jumlah peserta minimum harus berupa angka.',
            'min_participants.min' => 'Jumlah peserta minimum minimal 1.',
        ]);

        $school_package->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price_per_participant' => $validated['price_per_participant'],
            'min_participants' => $validated['min_participants'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.school-packages.index')
            ->with('success', 'Paket sekolah berhasil diperbarui.');
    }

    public function destroy(SchoolPackage $school_package): RedirectResponse
    {
        $school_package->delete();

        return redirect()->route('admin.school-packages.index')
            ->with('success', 'Paket sekolah berhasil dihapus.');
    }
}
