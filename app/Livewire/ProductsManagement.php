<?php

namespace App\Livewire;

use App\Models\Product;
use App\Jobs\LogProductCreation;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsManagement extends Component
{
    use WithPagination;

    public $name = '';
    public $description = '';
    public $price = '';
    public $search = '';
    public $perPage = 10;

    protected $paginationTheme = 'tailwind';

    /**
     * Validation rules for product creation.
     */
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
    ];

    /**
     * Mount the component.
     */
    public function mount()
    {
        // No need to load products here since it's handled in render()
    }

    /**
     * Get products based on search criteria.
     */
    public function getProductsProperty()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($this->perPage);
    }

    /**
     * Update search results when search term changes.
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Update page when per page value changes.
     */
    public function updatedPerPage()
    {
        $this->resetPage();
    }
    /**
     * Create a new product and dispatch logging job.
     */
    public function createProduct()
    {
        $this->validate();

        $product = Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        // Dispatch job to log product creation
        LogProductCreation::dispatch($product);

        // Reset form fields
        $this->reset(['name', 'description', 'price']);

        // Show success message
        session()->flash('message', 'Product created successfully!');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.products-management', [
            'products' => $this->products
        ])->layout('layouts.app');
    }
}
