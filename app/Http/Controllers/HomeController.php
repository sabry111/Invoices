<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $count_all = Invoice::count();
        $count_all_sum = Invoice::sum('total');
        $count_unpaid = Invoice::where('value_status', 2)->count();
        $count_unpaid_sum = Invoice::where('value_status', 2)->sum('total');
        $count_paid = Invoice::where('value_status', 1)->count();
        $count_paid_sum = Invoice::where('value_status', 1)->sum('total');
        $count_partially_paid = Invoice::where('value_status', 3)->count();
        $count_partially_paid_sum = Invoice::where('value_status', 3)->sum('total');

        if ($count_unpaid == 0) {
            $nspainvoices2 = 0;
        } else {
            $nspainvoices2 = $count_unpaid / $count_all * 100;
        }

        if ($count_paid == 0) {
            $nspainvoices1 = 0;
        } else {
            $nspainvoices1 = $count_paid / $count_all * 100;
        }

        if ($count_partially_paid == 0) {
            $nspainvoices3 = 0;
        } else {
            $nspainvoices3 = $count_partially_paid / $count_all * 100;
        }

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$nspainvoices2],
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$nspainvoices1],
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$nspainvoices3],
                ],

            ])
            ->options([]);

        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214', '#ff9642'],
                    'data' => [$nspainvoices2, $nspainvoices1, $nspainvoices3],
                ],
            ])
            ->options([]);

        return view('home', compact('count_all', 'count_unpaid', 'count_paid', 'count_partially_paid', 'count_all_sum', 'count_unpaid_sum', 'count_paid_sum', 'count_partially_paid_sum', 'chartjs', 'chartjs_2'));
    }
}
