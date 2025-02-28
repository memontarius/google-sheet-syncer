<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateEntryRequest;
use App\Models\Entry;
use App\Models\Enums\EntryStatus;
use App\Services\EntryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EntryController extends Controller
{
    public function __construct(
        private readonly EntryService $entryService
    )
    {
    }

    public function index(Request $request): View
    {
        $perPage = $request->query('perPage', 10);
        $entries = Entry::orderBy('id')->paginate($perPage);

        return view('entry.index', compact('entries'));
    }

    public function generate(Request $request): RedirectResponse
    {
        $fakeTexts = config('faketexts');
        $this->entryService->generate(1000, $fakeTexts);

        return redirect()->route('entry.index');
    }

    public function clear(): RedirectResponse
    {
        $this->entryService->clearAll();

        return redirect()->route('entry.index');
    }

    public function create(Request $request): View
    {
        return view('entry.create');
    }

    public function show(Entry $entry): View
    {
        return view('entry.show', compact('entry'));
    }

    public function edit(Entry $entry): View
    {
        return view('entry.edit', compact('entry'));
    }

    public function update(Entry $entry, StoreOrUpdateEntryRequest $request): RedirectResponse
    {
        $this->entryService->update($entry, $request->validated());

        return redirect()->back();
    }

    public function store(StoreOrUpdateEntryRequest $request): RedirectResponse
    {
        $request->flashOnly(['text', 'status']);
        $this->entryService->store($request->validated());

        return redirect()->back()->with('success', __('messages.entry.created'));
    }

    public function destroy(Entry $entry): RedirectResponse
    {
        $this->entryService->destroy($entry);

        return redirect()
            ->route('entry.index')
            ->with('success', __('messages.entry.deleted', ['id' => $entry->id]));
    }
}
