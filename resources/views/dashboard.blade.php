<!DOCTYPE html>
<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('users')</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="" />
        <meta property="og:type" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend/assets/imgs/theme/favicon.svg')}}" />
        
        <!-- Template CSS -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/animate.min.css')}}" />
        <link rel="stylesheet" href="{{asset('frontend/assets/css/main.css?v=5.3')}}" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    </head>

<body>
   @include('frontend.body.header')


   <!--End header-->

    <main class="main pages">
     @yield('user')
    </main>


 

    @include('frontend.body.footer')


    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{asset('frontend/assets/imgs/theme/loading.gif')}}" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    <script src="{{asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/slick.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/jquery.syotimer.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/waypoints.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/wow.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/magnific-popup.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/select2.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/counterup.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/images-loaded.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/isotope.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/scrollup.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/jquery.vticker-min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/jquery.theia.sticky.js')}}"></script>
    <script src="{{asset('frontend/assets/js/plugins/jquery.elevatezoom.js')}}"></script>
    <!-- Template  JS -->
    <script src="{{asset('frontend/assets/js/main.js?v=5.3')}}"></script>
    <script src="{{asset('frontend/assets/js/shop.js?v=5.3')}}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break; 
 }
 @endif 
</script>

<script type="text/javascript">
   
    
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    })
        function productView(id){
        // alert(id)
        $.ajax({
            type: 'GET',
            url: '/product/view/modal/'+id,
            dataType: 'json',
            success:function(data){
             
              
            $('#pname').text(data.products.product_name);
            $('#pprice').text(data.products.selling_price );
            $('#pcode').text(data.products.product_code);
            $('#pcategory').text(data.products.cat.category_name);
            $('#pbrand').text(data.products.brand.brand_name);
            $('#piamge').attr('src','/'+data.products.product_thambnail );

            $('#product_id').val(id);
            $('#qty').val(1);
            
           
            
            // Product Price 
           
            if (data.products.discount_price == null) {
                
                $('#oldprice').text('');
                $('#pprice').text(data.products.selling_price);
                
               
            }else{
                $('#pprice').text(data.products.selling_price - data.products.discount_price)  ;
                $('#oldprice').text(data.products.selling_price); 
            }

            if (data.products.product_qty > 0) {
                $('#aviable').text('');
                $('#stockout').text('');
                $('#aviable').text('aviable');
            }else{
                $('#aviable').text('');
                $('#stockout').text('');
                $('#stockout').text('stockout');
            }
            ///End Start Stock Option
             ///Size 
             $('select[name="size"]').empty();
             $.each(data.sizes,function(key,value){
                $('select[name="size"]').append('<option value="'+value+' ">'+value+'  </option')
                if (data.sizes == "") {
                    $('#sizeArea').hide();
                }else{
                     $('#sizeArea').show();
                }
             }) // end size
                     ///Color 
               $('select[name="color"]').empty();
             $.each(data.colors,function(key,value){
                $('select[name="color"]').append('<option value="'+value+' ">'+value+'  </option')
                if (data.colors == "") {
                    $('#colorArea').hide();
                }else{
                     $('#colorArea').show();
                }           
             }) // end size

            }
        })
    }
    // add to cart
     function addToCart(){

        var product_name = $('#pname').text();
        var id = $('#product_id').val();
        var colors = $('#color option:selected').text();
        var size = $('#size option:selected').text();
        var quantity = $('#qty').val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                color:colors, size:size , quantity:quantity ,product_name:product_name
            },
            url: "/cart/data/store/"+id,
            success:function(data){
             
                $('#closeModal').click();
                miniCart();
                
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  icon: 'success', 
                  showConfirmButton: false,
                  timer: 3000 
            })
            if ($.isEmptyObject(data.error)) {
                    
                    Toast.fire({
                    type: 'success',
                    title: data.success, 
                    })
            }else{
               
           Toast.fire({
                    type: 'error',
                    title: data.error, 
                    })
                }
                                     
            }
        })

    }
    
    </script>



<script type="text/javascript">
    
    function miniCart(){
       $.ajax({
           type: 'GET',
           url: '/product/mini/cart',
           dataType: 'json',
           success:function(response){

                 $('span[id="cartSubTotal"]').html(response.cartTotal);
                 $("#cartQty").html(response.cartQty);
                var miniCart = ""
        $.each(response.carts, function(key,value){
           miniCart += ` <ul>
            <li>
                <div class="shopping-cart-img">
                    <a href="shop-product-right.html"><img alt="Nest" src="/${value.options.iamge} " style="width:50px;height:50px;" /></a>
                </div>
                <div class="shopping-cart-title" style="margin: -73px 74px 14px; width" 146px;>
                    <h4><a href="shop-product-right.html"> ${value.name} </a></h4>
                    <h4><span>${value.qty} × </span>${value.price}</h4>
                </div>
                <div class="shopping-cart-delete" style="margin: -85px 1px 0px;">
                    <a type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)" ><i class="fi-rs-cross-small"></i></a>
                </div>
            </li> 
        </ul>
        <hr><br>  
               `  
          });
            $('#miniCart').html(miniCart);
        }
    })
 }
  miniCart();

  function miniCartRemove(rowId){
      $.ajax({
        type: 'GET',
        url: '/minicart/product/remove/'+rowId,
        dataType:'json',
        success:function(data){
        miniCart();

                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  icon: 'success', 
                  showConfirmButton: false,
                  timer: 3000 
            })
            if ($.isEmptyObject(data.error)) {
                    
                    Toast.fire({
                    type: 'success',
                    title: data.success, 
                    })
            }else{
               
           Toast.fire({
                    type: 'error',
                    title: data.error, 
                    })
                }
            }
        })
    }

    function addToCartDetails(){

var product_name = $('#dpname').text();
var id = $('#dproduct_id').val();
var colors = $('#dcolor option:selected').text();
var quantity = $('#dqty').val();
$.ajax({
    type: "POST",
    dataType: 'json',
    data: {
        color:colors, quantity:quantity ,product_name:product_name
    },
    url: "/dcart/data/store/"+id,
    success:function(data){
     
        
        miniCart();
        
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          icon: 'success', 
          showConfirmButton: false,
          timer: 3000 
    })
    if ($.isEmptyObject(data.error)) {
            
            Toast.fire({
            type: 'success',
            title: data.success, 
            })
    }else{
       
   Toast.fire({
            type: 'error',
            title: data.error, 
            })
        }
                             
    }
})

}

 </script>
             <!-- wishlist  --> 

<script type="text/javascript">
 function addToWishList(product_id){
    
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/add-to-wishlist/"+product_id,
        success: function(data){
            
            const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  icon: 'success', 
                  showConfirmButton: false,
                  timer: 3000 
            })
            if ($.isEmptyObject(data.error)) {
                    
                    Toast.fire({
                    type: 'success',
                    title: data.success, 
                    })
            }else{
               
           Toast.fire({
                    type: 'error',
                    title: data.error, 
                    })
                }

        }
    })
            
}
  
</script>

   <!-- wishlist -->
<script type="text/javascript">
        function wishlist() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/get-wishlist-product/",
                success: function(data) {
                    
                    var wish = ""
                    $("#wishcount").text(data.wishQty);
                    wishlist();

                    $.each(data.wishlist, function(key,value){ 
                        wish +=  ` <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    
                                </td>
                                <td class="image product-thumbnail pt-40"><img src="/${value.product.product_thambnail}" alt="#" /></td>
                                <td class="product-des product-name">
                                    <h6><a class="product-name mb-10" href="shop-product-right.html">${value.product.product_name}</a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: 90%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    ${value.product.discount_price == null
                                        ? `<h3 class="text-brand">LE ${value.product.selling_price}</h3>`
                                        : `<h3 class="text-brand">LE ${value.product.selling_price - value.product.discount_price}</h3>`
                                    }
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                ${value.product.product_qty  > 0
                                    ? `<span class="stock-status in-stock mb-0"> In Stock </span>`
                                    : `<span class="stock-status in-stock mb-0"> Stock Out </span>`
                                             }
                                    
                                </td>

                                <td class="action text-center" data-title="Remove">
                                    <a type="submit" id=${value.id} class="text-body" onclick="wishlistRemove(this.id)" ><i class="fi-rs-trash"></i></a>
                                </td>
                            </tr> `
                    });

                    $('#wishlist').html(wish); 
                }
            })
        }
        wishlist();

        function wishlistRemove(id) {
            $.ajax({ 
                type: "GET",
                dataType: "json",
                url: "/wishlist-remove/"+id,
                success: function(data) {
                    wishlist();
                }
               
            });
         }

</script>
        <!-- Compare  -->
<script type="text/javascript">
    function addToCompare(product_id) {
        $.ajax({    
            type: "POST",
            dataType: "json",
            url: "/add-to-compare/"+product_id,
            success: function(data) {

            }
        })
        
    }


 </script>

 <!--  /// Start Load Compare Data -->
 <script type="text/javascript">
        
    function compare(){
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/get-compare-product/",
            success:function(response){ 
               var rows = ""
               $.each(response, function(key,value){
    rows += ` <tr class="pr_image">
                                <td class="text-muted font-sm fw-600 font-heading mw-200">Preview</td>
<td class="row_img"><img src="/${value.product.product_thambnail} " style="width:300px; height:300px;"  alt="compare-img" /></td>
                                
                            </tr>
                            <tr class="pr_title">
                                <td class="text-muted font-sm fw-600 font-heading">Name</td>
                                <td class="product_name">
                                    <h6><a href="shop-product-full.html" class="text-heading">${value.product.product_name} </a></h6>
                                </td>
                               
                            </tr>
                            <tr class="pr_price">
                                <td class="text-muted font-sm fw-600 font-heading">Price</td>
                                <td class="product_price">
                  ${value.product.discount_price == null
                    ? `<h4 class="price text-brand">LE ${value.product.selling_price}</h4>`
                    :`<h4 class="price text-brand">LE ${value.product.selling_price - value.product.discount_price}</h4>`
                    } 
                                </td>
                              
                            </tr>
                            
                            <tr class="description">
                                <td class="text-muted font-sm fw-600 font-heading">Description</td>
                                <td class="row_text font-xs">
                                    <p class="font-sm text-muted"> ${value.product.short_descp}</p>
                                </td>
                                
                            </tr>
                            <tr class="pr_stock">
                                <td class="text-muted font-sm fw-600 font-heading">Stock status</td>
                                <td class="row_stock">
                            ${value.product.product_qty > 0 
                            ? `<span class="stock-status in-stock mb-0"> In Stock </span>`
                            :`<span class="stock-status out-stock mb-0">Stock Out </span>`
                           } 
                          </td>
                               
                            </tr>
                            
        <tr class="pr_remove text-muted">
            <td class="text-muted font-md fw-600"></td>
            <td class="row_remove">
                <a type="submit" class="text-muted"  id="${value.id}" onclick="compareRemove(this.id)"><i class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
            </td>
            
        </tr> ` 
   });
   $('#compare').html(rows); 
            }
        })
    }
compare();
// / End Load Compare Data -->

function compareRemove(id){
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/compare-remove/"+id,
                success:function(data){
                compare();
                 
           
                }
            })
        }

</script>
   
</body>

</html>