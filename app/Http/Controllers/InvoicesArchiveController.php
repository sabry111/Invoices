<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoices_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InvoicesArchiveController extends Controller
{

    public function __construct()
    {

        $this->middleware('permission:ارشيف الفواتير', ['only' => ['index']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);

    }

    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        $id = $request->invoice_id;
        Invoice::withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect(route('archive.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = Invoice::withTrashed()->where('id', $request->invoice_id)->first();
        $id = $request->invoice_id;
        $details = Invoices_attachment::where('invoice_id', $id)->get();
        foreach ($details as $detail) {
            if (!empty($detail->invoice_number)) {
                // $files = public_path('Attachments/' . $details->invoice_number);
                // Storage::disk('public_uploads')->deleteDirectory($files);

                $attach_path = public_path('Attachments/' . $detail->invoice_number);
                File::deleteDirectory($attach_path);
            }
        }
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect(route('archive.index'));
    }
}
