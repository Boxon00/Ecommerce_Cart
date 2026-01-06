<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\CartItem;
use Livewire\Component;
use Livewire\Attributes\On;

class ProductList extends Component
{
    public $search = '';

    #[On('cart-updated')]
    public function refreshComponent()
    {
        // This will refresh the component when cart is updated
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->isOutOfStock()) {
            session()->flash('error', 'This product is out of stock.');
            return;
        }

        $cart = auth()->user()->getOrCreateCart();

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            if ($cartItem->quantity >= $product->stock_quantity) {
                session()->flash('error', 'Cannot add more items. Insufficient stock.');
                return;
            }
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        $this->dispatch('cart-updated');
        session()->flash('success', 'Product added to cart!');
    }

    public function render()
    {
        $products = Product::where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->get();

        return view('livewire.product-list', [
            'products' => $products,
        ]);
    }
}
