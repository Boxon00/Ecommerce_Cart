<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Mail\DailySalesReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDailySalesReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $today = Carbon::today();

        $orders = Order::with('items.product')
            ->whereDate('created_at', $today)
            ->get();

        $admin = User::where('is_admin', true)->first();

        if ($admin && $orders->count() > 0) {
            Mail::to($admin->email)->send(new DailySalesReport($orders, $today));
        }
    }
}
