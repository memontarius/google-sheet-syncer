<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateEntryRequest;
use App\Models\Entry;
use App\Models\Enums\EntryStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EntryController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->query('perPage', 10);
        $entries = Entry::orderBy('id')->paginate($perPage);

        return view('entry.index', compact('entries'));
    }

    public function generate(Request $request): RedirectResponse
    {
        $data = [];
        $fakeTexts = config('faketexts');

        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'status' => (rand(0, 1) == 1) ? EntryStatus::Allowed : EntryStatus::Prohibited,
                'text' => $fakeTexts[rand(0, count($fakeTexts) - 1)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $tableName = (new Entry)->getTable();
        DB::table($tableName)->insert($data);

        return redirect()->route('entry.index');
    }

    public function clear(Entry $entry): RedirectResponse
    {
        Entry::truncate();

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
        $entry->update($request->validated());

        return redirect()->back();
    }

    public function store(StoreOrUpdateEntryRequest $request): RedirectResponse
    {
        $request->flashOnly(['text', 'status']);
        Entry::create($request->validated());

        return redirect()->back()->with('success', __('messages.entry.created'));
    }

    public function destroy(Entry $entry): RedirectResponse
    {
        $id = $entry->id;
        $entry->delete();

        return redirect()
            ->route('entry.index')
            ->with('success', __('messages.entry.deleted', ['id' => $id]));
    }
}
