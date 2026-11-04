<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request)
    {
        $subscribers = NewsletterSubscriber::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where('email', 'like', '%' . addcslashes(trim($request->q), '%_\\') . '%');
            })
            ->when(in_array($request->status, ['0', '1'], true), fn($q) => $q->where('status', (int) $request->status))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $totalCount = NewsletterSubscriber::count();
        $activeCount = NewsletterSubscriber::active()->count();

        return view('admin.home.subscribers.index', compact('subscribers', 'totalCount', 'activeCount'));
    }

    public function toggle($id)
    {
        $sub = NewsletterSubscriber::findOrFail($id);
        $sub->update(['status' => !$sub->status]);

        return back()->with('success', 'Subscriber updated.');
    }

    public function destroy($id)
    {
        NewsletterSubscriber::findOrFail($id)->delete();

        return response()->json(['message' => 'Subscriber deleted.']);
    }

    /** CSV of active subscribers */
    public function export()
    {
        $rows = NewsletterSubscriber::active()->orderBy('id')->get(['email', 'created_at']);

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Email', 'Subscribed On']);
            foreach ($rows as $r) {
                fputcsv($out, [$r->email, $r->created_at->format('Y-m-d H:i')]);
            }
            fclose($out);
        }, 'newsletter-subscribers-' . now()->format('Ymd') . '.csv', ['Content-Type' => 'text/csv']);
    }
}