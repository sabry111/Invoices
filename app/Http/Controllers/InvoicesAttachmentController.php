<?php

namespace App\Http\Controllers;

use App\Models\Invoices_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoicesAttachmentController extends Controller
{

    public function __construct()
    {

        $this->middleware('permission:اضافة مرفق', ['only' => ['create', 'store']]);
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        // $image = $request->file_name;
        // $file_name = $request->file_name->getClientOriginalName();

        $file_name = $request->file_name->hashName();

        $attachments = new Invoices_attachment();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->created_by = auth()->user()->name;
        $attachments->save();

        // move pic
        // $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $file_name);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = Invoices_attachment::findOrFail($request->file_id);
        $invoices->delete();
        $attach_path = public_path('Attachments/' . $request->invoice_number . '/' . $request->file_name);
        // Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        File::delete($attach_path);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function openfile($invoice_number, $file_name)
    {
        // dd($invoice_number, $file_name);

        // $files = Storage::disk('public_uploads')->get($invoice_number . '/' . $file_name);
        $files = public_path('Attachments/' . $invoice_number . '/' . $file_name);
        return response()->file($files);
    }

    public function getfile($invoice_number, $file_name)
    {
        // $files = Storage::disk('public_uploads')->get($invoice_number . '/' . $file_name);
        $files = public_path('Attachments/' . $invoice_number . '/' . $file_name);
        return response()->download($files);
    }
}
