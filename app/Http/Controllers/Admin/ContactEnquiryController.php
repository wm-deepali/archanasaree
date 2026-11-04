<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContactEnquiriesExport;
use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ContactEnquiryController extends Controller
{
    public function index()
    {
        $enquiries = ContactEnquiry::latest()->paginate(10);
        $unreadCount = ContactEnquiry::where('is_read', false)->count();

        return view('admin.contact-enquiries.index', compact('enquiries', 'unreadCount'));
    }

    public function show(ContactEnquiry $contactEnquiry)
    {
        if (! $contactEnquiry->is_read) {
            $contactEnquiry->update(['is_read' => true]);
        }

        return view('admin.contact-enquiries.show', ['enquiry' => $contactEnquiry]);
    }

    public function export()
    {
        $filename = 'contact_enquiries_' . now()->format('Y_m_d_His') . '.xlsx';

        return Excel::download(new ContactEnquiriesExport(), $filename);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:contact_enquiries,id',
        ]);

        $count = ContactEnquiry::whereIn('id', $request->ids)->delete();

        return response()->json(['message' => $count . ' enquiries deleted successfully.']);
    }

    public function destroy(ContactEnquiry $contactEnquiry)
    {
        $contactEnquiry->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Enquiry deleted successfully.',
        ]);
    }
}