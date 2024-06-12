<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoices_attachment;
use App\Models\Section;
use App\Models\User;
use App\Notifications\Add_invoice_new;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {

        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ارشفة الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['show', 'status_update']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['Print_invoice']]);

    }
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add', compact('sections'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'section_id' => $request->section_id,
            'product' => $request->product,
            'status' => 'غير مدفوعة',
            'remaining_amount' => $request->total,
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoices_attachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        $user = User::get();
        $invoice = Invoice::latest()->first();
        Notification::send($user, new Add_invoice_new($invoice));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect(route('invoices.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // dd($id);
        $invoices = Invoice::where('id', $id)->first();
        return view('invoices.status_edit', compact('invoices'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $sections = Section::all();
        return view('invoices.edit_invoices', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->id);

        $invoice = Invoice::findOrFail($request->id);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section_id,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);
        return redirect(route('invoices.index'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $invoices = Invoice::where('id', $id)->first();

        $invoices->delete();
        session()->flash('archive_invoice');
        return redirect(route('invoices.index'));

    }

    public function status_update($id, Request $request)
    {
        $invoices = Invoice::findOrFail($id);

        // dd($request->all());
        if ($request->status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'remaining_amount' => '0',
                'payment_date' => $request->payment_date,
            ]);
        } else {
            $remaining_amount = $request->total - $request->amount_paid;
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'remaining_amount' => $remaining_amount,
                'payment_date' => $request->payment_date,
            ]);

        }
        session()->flash('status_update');
        return redirect(route('invoices.index'));

    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    public function details($id)
    {

        $invoice = Invoice::where('id', $id)->first();
        // dd($invoice);
        $attachments = Invoices_attachment::where('invoice_id', $id)->get();

        // dd($invoice);
        return view('invoices.invoices_details', compact('invoice', 'attachments'));
    }

    public function Invoice_Paid()
    {
        $invoices = Invoice::where('value_status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoice::where('value_status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoice::where('value_status', 3)->get();
        return view('invoices.invoices_partial', compact('invoices'));
    }

    public function Print_invoice($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        return view('invoices.print_invoices', compact('invoices'));
    }

    public function mark_all()
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
    }

    // public function mark_one($id)
    // {

    //     $invoices = Invoice::where('id', $id)->first();
    //     $get_id = DB::table('notifications')->where('data->id', $id)->pluck('id');
    //     // dd($get_id);
    //     foreach ($get_id as $ids) {
    //         DB::table('notifications')->where('id', $ids)->update(['read_at' => now()]);
    //     }

    //     return $invoices;

    // }

}
