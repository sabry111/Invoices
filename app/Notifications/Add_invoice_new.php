<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Add_invoice_new extends Notification
{
    use Queueable;
    private $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [

            //'data' => $this->details['body']
            'id' => $this->invoice->id,
            'title' => 'تم اضافة فاتورة جديد بواسطة :',
            'user' => Auth::user()->name,

        ];
    }

    // public function toMail($notifiable)
    // {

    //     $url = 'http://127.0.0.1:8000/invoicesdetails/' . $this->invoice;

    //     return (new MailMessage)
    //         ->subject('اضافة فاتورة جديدة')
    //         ->line('اضافة فاتورة جديدة')
    //         ->action('عرض الفاتورة', $url)
    //         ->line('شكرا لاستخدامك مورا سوفت لادارة الفواتير');
    // }

    // public function toArray($notifiable)
    // {
    //     return [
    //         //
    //     ];
    // }

}
