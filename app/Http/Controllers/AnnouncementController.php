<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\UpdateAnnouncementRequest;
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
        Announcement::create($request->validated() + ['user_id' => auth()->id()]);

        notify()->success('Announcement created successfully.');
        return redirect()->route('announcements.index');
    }

    public function show(Announcement $announcement): View
    {
        return view('dashboard.admin.announcement.show', compact('announcement'));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->fill($request->validated())->save();

        notify()->success('Announcement updated successfully. ' . $announcement->title);
        return back();
    }


    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        notify()->warning('Announcement deleted successfully. ' . $announcement->title);
        return redirect()->route('announcements.index');
    }
}
