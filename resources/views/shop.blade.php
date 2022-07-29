@extends('layout')

@section('title', 'Products')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
          <a href="#">Home</a>
           <i class="fa fa-chervon-right breadcrumb-separator"></i>
           <span>Shop</span>
        </div>
       
    </div>


    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>
                 @foreach ($categories as $category)

                     <li class=" {{ setActiveCategory($category->slug) }}" ><a href="{{ route('shop.index', ['category' => $category->slug ]) }}">{{ $category->name }}</a></li>

                 @endforeach

               
                
              
            </ul>

            {{-- <h3>By Price</h3>
            <ul>
                <li><a href="#">$0-$700</a></li>
                <li><a href="#">$700-$2500</a></li>
                <li><a href="#">$2500+</a></li>
            </ul> --}}
          
        </div> <!-- end sidebar -->
        <div>
            <div class="products-header">
           <h1 class="stylish-heading">{{ $categoryName }}</h1>
           <strong>Price</strong>
           <a href="{{ route('shop.index', ['category' => request()->category, 'sort' => 'low_high']) }}">Low to High</a>
           <a href="{{ route('shop.index', ['category' => request()->category, 'sort' => 'high_low']) }}">High to Low</a>

           </div>

            <div class="products text-center">

    
                @forelse ($products as $product )

                <div class="product">
                    <a href="{{ route('shop.show', $product->slug) }}"><img src="img/macbook-pro.png" alt="product"></a>
                    <a href="{{ route('shop.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
                     <div class="product-price">
                         ${{ $product->price }}
                     </div>
                </div>
                     
                @empty

                <div style="text-align: left">No items</div>
                    
                @endforelse
             
              
            
            </div> <!-- end products --> 

            {{  $products->appends(request()->input())->links() }}

            <div class="spacer"></div>
           
        </div>
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection