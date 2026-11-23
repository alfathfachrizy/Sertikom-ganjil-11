<?php

namespace App\Http\Controllers;

use App\Models\SchoolPackage;
use App\Models\Ticket;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $tickets = Ticket::where('is_active', true)->get();
        $packages = SchoolPackage::where('is_active', true)->get();

        return view('catalog.index', compact('tickets', 'packages'));
    }

    public function showTicket(Ticket $ticket): View
    {
        abort_unless($ticket->is_active, 404);

        return view('catalog.ticket-show', compact('ticket'));
    }

    public function showPackage(SchoolPackage $package): View
    {
        abort_unless($package->is_active, 404);

        return view('catalog.package-show', compact('package'));
    }
}
