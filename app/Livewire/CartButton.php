<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class CartButton extends Component
{
    public $itemCount = 0;

    public function mount()
    {
        $this->updateItemCount();
    }

    #[On('cart-updated')]
    public function updateItemCount()
    {
        $cart = auth()->user()->cart;
        $this->itemCount = $cart ? $cart->getTotalItems() : 0;
    }

    public function render()
    {
        return view('livewire.cart-button');
    }
}
