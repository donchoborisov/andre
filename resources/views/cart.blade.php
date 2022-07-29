@extends('layout')

@section('title', 'Products')



@section('content')

<div class="breadcrumbs">
     <div class="container">
         <a href="#">Home</a>
         <i class="fa fa-chevron-right breadcrumb-separator"></i>
         <span>Shopping Cart</span>
     </div>


</div><!--- end bread -->

<div class="cart-section container">

    @if (session()->has('success_message'))
        <div class="alert alert-success">
            {{ session()->get('success_message') }}
        </div>
    @endif

    @if(count($errors) > 0) 

      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error )
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>


    @endif

     <div>


        @if (Cart::count() > 0)

        <h2>{{ Cart::count() }} item(s) in the shoping cart</h2>

        <div class="cart-table">

            @foreach (Cart::content() as $item )


                
           
            <div class="cart-table-row">
                <div class="cart-table-ror-left">
                    <a href=""><img src="/img/macbook-pro.png" alt="item" class="cart-table-img"></a>
                   <div class="cart-item-details">
                       <div class="cart-table-item"><a href="">{{ $item->name }}</a></div>
                        <div class="cart-table-description">{{ $item->description }}</div>
                   </div> 
              </div>
              <div class="cart-table-row-right">
                  <div class="cart-table-actions">
                      {{-- <a href="#">Remove</a> --}}
                      {{-- <a href="#">Save for later</a> --}}
                      <form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="POST">
                        {{ csrf_field() }}
                      
 
                        <button type="submit" class="cart-options">Save for later</button>
 
                       </form> 


                      <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                       {{ csrf_field() }}
                       {{ method_field('DELETE') }}

                       <button type="submit" class="cart-options">Remove</button>

                      </form>  



                  </div>
                  <div>
                       <select class="quantity" data-id="{{ $item->rowId }}">

                        @for ($i = 1; $i < 5 + 1; $i++ )

                        <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                            
                        @endfor
                         
                         
                       </select>

                  </div>
                  <div>{{ $item->subtotal }}</div>

              </div> <!--end card table row -->
         </div><!--- end card table -->
         @endforeach
          
         <a href="#" class="have-code">Have a Code?</a>

         <div class="have-code-container">
             <form action="#">
                 <input type="text">
                 <button type="submit" class="button button-plain">Apply</button>
             </form>
         </div><!--end have code container -->

         <div class="cart-totals">
             <div class="cart-totals-left">
                 Shipping is free because we'are awesome like that.Also Because that's additional stuff I dont feel like.
             </div>

             <div class="cart-totals-right">
                 <div>
                     Subtotal <br>
                     Tax<br>
                     <span class="cart-totals-total">Total</span>
                     <div class="cart-totals-subtotal">
                         {{ Cart::subtotal() }}<br>
                         {{ Cart::tax() }}<br>
                         <span class="cart-totals-total">{{ Cart::total() }}</span>
                     </div>
                 </div>

             </div><!--end cart totals -->
            
             <div class="cart-buttons">

                <a href="#" class="button">Continue Shopping</a>
                <a href="{{ route('checkout.index') }}" class="button-primary">Proceed to Checkout</a>
             </div>

             @else   
             
             <h3>No Items in Cart!</h3>
             <div class="spacer"></div>
             <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
             <div class="spacer"></div>
             @endif


             @if (Cart::instance('saveForLater')->count() > 0)

             <h2>{{ Cart::instance('saveForLater')->count() }} item(s) items saved for later</h2>

           

           <div class="saved-for-later cart-table">

            @foreach (Cart::instance('saveForLater')->content() as $item )
                
           
               <div class="cart-table-row">
                   <div class="cart-table-row-left">
                       <a href="#"><img src="/img/macbook-pro.png" alt="item" class="cart-table-img"></a>
                       <div class="cart-item-details">
                           <div class="cart-table-item"><a href="#">{{ $item->name }}</a></div>
                           <div class="cart-table-description"><a href="#">{{ $item->description }}</a></div>
                           
                       </div>
                   </div>
                   <div class="cart-table-row-right">
                       <div class="cart-table-actions">
                        <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="POST">
                            {{ csrf_field() }}
                          
     
                            <button type="submit" class="cart-options">Move to Cart</button>
     
                           </form> 
    
    
                          <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                           {{ csrf_field() }}
                           {{ method_field('DELETE') }}
    
                           <button type="submit" class="cart-options">Remove</button>
    
                          </form>  
                       </div>
                       <div>{{ $item->price }}</div>
                   </div>
               </div>
           </div>
           @endforeach

           @else

            <h3>You have no items Saved for Later</h3>


           @endif






         </div>


        </div>

        


    </div>

</div>





@endsection

@section('extra-js')
   <script src="{{ asset('js/app.js') }}"></script>

   <script>
     (function(){

        const classname = document.querySelectorAll('.quantity')

        Array.from(classname).forEach(function(element){

            element.addEventListener('change', function(){
               
                const id = element.getAttribute('data-id')
                axios.patch(`/cart/${id}`, {
                quantity: this.value,
                
               })
               .then(function (response) {
                  
                window.location.href = '{{ route('cart.index') }}'

               })
              .catch(function (error) {

                window.location.href = '{{ route('cart.index') }}'
                
               });
            })
        })

     })();

   </script>




@endsection