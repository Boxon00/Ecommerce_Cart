<?php

namespace App\Observers;

use App\Models\CartItem;
use App\Jobs\SendLowStockNotification;

class CartItemObserver
{
    public function created(CartItem $cartItem): void
    {
        $this->checkStockLevel($cartItem);
    }

    public function updated(CartItem $cartItem): void
    {
        $this->checkStockLevel($cartItem);
    }

    private function checkStockLevel(CartItem $cartItem): void
    {
        $product = $cartItem->product;

        if ($product->isLowStock()) {
            SendLowStockNotification::dispatch($product);
        }
    }
}
