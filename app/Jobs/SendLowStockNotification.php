<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use App\Mail\LowStockNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLowStockNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Product $product
    ) {}

    public function handle(): void
    {
        $admin = User::where('is_admin', true)->first();

        if ($admin) {
            Mail::to($admin->email)->send(new LowStockNotification($this->product));
        }
    }
}
