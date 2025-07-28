<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Display success message -->
            @if (session()->has('message'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <!-- Product creation form -->
            <div class="mb-10">
                <x-form-section submit="createProduct">
                    <x-slot name="title">
                        {{ __('Create New Product') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Add a new product to your inventory with name, description, and pricing information.') }}
                    </x-slot>

                    <x-slot name="form">
                        <!-- Product Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="name" value="{{ __('Product Name') }}" />
                            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name"
                                autocomplete="name" />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Product Description -->
                        <div class="col-span-6">
                            <x-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3" wire:model="description" placeholder="Enter product description..."></textarea>
                            <x-input-error for="description" class="mt-2" />
                        </div>

                        <!-- Product Price -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="price" value="{{ __('Price') }}" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <x-input id="price" type="number" class="pl-7 block w-full" wire:model="price"
                                    step="0.01" min="0" placeholder="0.00" />
                            </div>
                            <x-input-error for="price" class="mt-2" />
                        </div>
                    </x-slot>

                    <x-slot name="actions">
                        <x-button class="ml-3">
                            {{ __('Create Product') }}
                        </x-button>
                    </x-slot>
                </x-form-section>
            </div>

            <!-- Product list -->
            <div class="mt-10 sm:mt-0">
                <x-action-section>
                    <x-slot name="title">
                        {{ __('Product Inventory') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Manage your product inventory. Here you can view all products currently in your system.') }}
                    </x-slot>

                    <x-slot name="content">
                        <!-- Search Bar and Filters -->
                        <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                            <div class="flex-1 max-w-lg">
                                <x-label for="search" value="{{ __('Search Products') }}" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <x-input id="search" type="text" class="pl-10 block w-full"
                                        wire:model.live="search" placeholder="Search by name or description..." />
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <x-label for="perPage" value="{{ __('Per Page') }}" />
                                <select id="perPage"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    wire:model.live="perPage">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                        @if ($products->isEmpty())
                            @if ($search)
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                                    <p class="mt-1 text-sm text-gray-500">No products match your search criteria. Try
                                        adjusting your search terms.</p>
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                                </div>
                            @endif
                        @else
                            <!-- Results Summary -->
                            <div class="mb-4 flex justify-between items-center">
                                <div class="text-sm text-gray-700">
                                    @if ($search)
                                        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }}
                                        of {{ $products->total() }} results for "<strong>{{ $search }}</strong>"
                                    @else
                                        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }}
                                        of {{ $products->total() }} total products
                                    @endif
                                </div>
                                @if ($search)
                                    <button wire:click="$set('search', '')"
                                        class="text-sm text-indigo-600 hover:text-indigo-900">
                                        Clear search
                                    </button>
                                @endif
                            </div>

                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <!-- Loading indicator -->
                                <div wire:loading.delay
                                    class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
                                    <div class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span class="text-sm text-gray-600">Loading...</span>
                                    </div>
                                </div>

                                <table class="min-w-full divide-y divide-gray-300 relative">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Price
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Created At
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($products as $product)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $product->name }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 max-w-xs">
                                                        {{ $product->description }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        ${{ number_format($product->price, 2) }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $product->created_at->format('M j, Y g:i A') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Links -->
                            <div class="mt-6">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </x-slot>
                </x-action-section>
            </div>
        </div>
    </div>
</div>
