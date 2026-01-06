<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Livewire\Attributes\On;

class ShoppingCart extends Component
{
    #[On('cart-updated')]
    public function refreshCart()
    {
        // This will refresh the component
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        if ($quantity <= 0) {
            $this->removeItem($cartItemId);
            return;
        }

        if ($quantity > $cartItem->product->stock_quantity) {
            session()->flash('error', 'Insufficient stock available.');
            return;
        }

        $cartItem->update(['quantity' => $quantity]);
        $this->dispatch('cart-updated');
        session()->flash('success', 'Cart updated!');
    }

    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();

        $this->dispatch('cart-updated');
        session()->flash('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $cart = auth()->user()->cart;

        if (!$cart || $cart->items->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }

        // Check stock availability
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                session()->flash('error', 'Some items are out of stock.');
                return;
            }
        }

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $cart->getTotalAmount(),
            'status' => 'completed',
        ]);

        // Create order items and update stock
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ]);

            // Reduce stock
            $item->product->decrement('stock_quantity', $item->quantity);
        }

        // Clear cart
        $cart->items()->delete();

        $this->dispatch('cart-updated');
        session()->flash('success', 'Order placed successfully!');
        return redirect()->route('products');
    }

    public function render()
    {
        $cart = auth()->user()->cart;
        $cartItems = $cart ? $cart->items()->with('product')->get() : collect();
        $total = $cart ? $cart->getTotalAmount() : 0;

        return view('livewire.shopping-cart', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }
}
