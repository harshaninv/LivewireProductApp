<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductsManagement extends Component
{
    public $name = '';
    public $description = '';
    public $price = '';
    public $products;

    // validation rules for product creation
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
    ];

    // create a new product
    public function createProduct() {
        $this -> validate();

        $product = Product::create([
            'name' => $this->name,
            'description' => $this -> description,
            'price' => $this -> price,
        ]);

        // Reset form fields
        $this->reset(['name', 'description', 'price']);

        // Refresh product list
        $this->products = Product::all();

        // Show success message
        session()->flash('message', 'Product created successfully!');
    }

    public function render()
    {
        return view('livewire.products-management');
    }
}
