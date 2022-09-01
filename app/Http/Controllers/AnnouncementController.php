<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnnouncementController extends Controller
{


    public function index(): View
    {
        $announcements = Announcement::paginate(10);
        return view('dashboard.admin.announcement.index', compact('announcements'));
    }


    public function create(): View
    {
        return view('dashboard.admin.announcement.create');
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        Announcement::create($request->validated());

        notify()->success('Announcement created successfully.');
        return redirect()->route('announcements.index');
    }
}
