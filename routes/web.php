<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CashController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\User\CompareController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ActiveUserController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\VendorProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


 // Route::get('/dashboard', function () {
 //   return view('dashboard');
 // })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [IndexController::class, 'Index'])->name('home');
 
            // user home page routes //
Route::middleware(['auth'])->group( function() {
    Route::controller(UserController::class)->group( function () {
         route::get('/dashboard','UserDashboard')->name('UserDashboard');
         route::post('/user/profile/store','UserProfileStore')->name('user.profile.store');
         route::get('/user/logout','UserLogout')->name('user.logout');
         route::post('/user/update/password','UserUpdatePassword')->name('user.update.password');

});
});
///////////////////////// admin  login and profile //////////////////////////////////////////////////////////
            // Admin routes
Route::get('/admins/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);

Route::middleware(['auth','role:admin'])->group( function() {

    Route::controller(AdminController::class)->group( function () {
         route::get('/admin/dashboard','AdminDashboard')->name('admin.dashboard');
         route::get('/admin/logout','AdminDestroy')->name('admin.logout');
         route::get('/admin/profile','AdminProfile')->name('admin.profile');
         route::post('/admin/profile/store','AdminProfileStore')->name('admin.profile.store');
         route::get('/admin/change/password','AdminChangePassword')->name('admin.change.password');
         route::post('/admin/update/password','AdminUpdatePassword')->name('admin.update.password');
         
    });

    Route::controller(BrandController::class)->group( function () {
        route::get('/all/brand','AllBrand')->name('all.brand');
        route::get('/add/brand','AddBrand')->name('add.brand');
        route::post('/store/brand','StoreBrand')->name('store.brand');
        route::get('/edit/brand/{id}','EditBrand')->name('edit.brand');
        route::post('/update/brand','UpdateBrand')->name('update.brand');
        route::get('/delete/brand/{id}','DeleteBrand')->name('delete.brand');
                    
    });
            // all  category routes
    Route::controller(CategoryController::class)->group( function () {
    route::get('/all/category','AllCategory')->name('all.category');
    route::get('/add/category','AddCategory')->name('add.category');
    route::post('/store/category','StoreCategory')->name('store.category');
    route::get('/edit/category/{id}','EditCategory')->name('edit.category');
    route::post('/update/category','UpdateCategory')->name('update.category');
    route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');
    });

    // all  subcategory routes
    Route::controller(SubCategoryController::class)->group( function () {
    route::get('/all/subcategory','AllSubCategory')->name('all.subcategory');
    route::get('/add/subcategory','AddSubCategory')->name('add.subcategory');
    route::post('/store/subcategory','StoreSubCategory')->name('store.subcategory');
    route::get('/edit/subcategory/{id}','EditSubCategory')->name('edit.subcategory');
    route::post('/update/subcategory','UpdateSubCategory')->name('update.subcategory');
    route::get('/delete/subcategory/{id}','DeleteSubCategory')->name('delete.subcategory');
    route::get('/subcategory/ajax/{category_id}','GetSubCategory');
    

    });
    // vendor active and inactive routes 
    Route::controller(AdminController::class)->group(function(){
    Route::get('/inactive/vendor' , 'InactiveVendor')->name('inactive.vendor');
    Route::get('/active/vendor' , 'ActiveVendor')->name('active.vendor');
    Route::get('/inactive/vendor/details/{id}' , 'InactiveVendorDetails')->name('inactive.vendor.details');
    Route::post('/active/vendor/approve' , 'ActiveVendorApprove')->name('active.vendor.approve');
    Route::get('/active/vendor/details/{id}' , 'ActiveVendorDetails')->name('active.vendor.details');
    Route::post('/inactive/vendor/approve' , 'InactiveVendorApprove')->name('inactive.vendor.approve');

    });

    // all  Product routes
    Route::controller(ProductController::class)->group( function () {
    route::get('/all/product','AllProduct')->name('all.product');
    route::get('/add/product','AddProduct')->name('add.product');
    route::post('/store/product','StoreProduct')->name('store.product');
    route::get('/edit/product/{id}','EditeProduct')->name('edit.product');
    route::post('/update/product','UpdateProduct')->name('update.product');
    route::post('/update/product/thambnail','UpdateProductThambnail')->name('update.product.thambnail');
    route::post('/update/product/multiimage','UpdateProductMultiImage')->name('update.product.multiimage');
    route::get('/dalete/product/multiimage/{id}','DeleteProductMultiImage')->name('daleta.product.multiimage');
    route::get('/inactive/product/{id}','InactiveProduct')->name('inactive.product');
    route::get('/active/product/{id}','ActiveProduct')->name('active.product');
    route::get('/delete/product/{id}','DeleteProduct')->name('delete.product');

    Route::get('/product/stock' , 'ProductStock')->name('product.stock');
    
    });
        // all  Slider routes
    Route::controller(SliderController::class)->group( function () {
        route::get('/all/slider','AllSlider')->name('all.slider');
        route::get('/add/slider','AddSlider')->name('add.slider');
        route::post('/store/slider','StoreSlider')->name('store.slider');
        route::get('/edit/slider/{id}','EditSlider')->name('edit.slider');
        route::post('/update/slider','UpdateSlider')->name('update.slider');
        route::get('/delete/slider/{id}','DeleteSlider')->name('delete.slider');
        
        });
            // all  Banner routes
        Route::controller(BannerController::class)->group( function () {
            route::get('/all/banner','AllBanner')->name('all.banner');
            route::get('/add/banner','AddBanner')->name('add.banner');
            route::post('/store/banner','StoreBanner')->name('store.banner');
            route::get('/edit/banner/{id}','EditeBanner')->name('edit.banner');
            route::post('/update/banner','UpdateBanner')->name('update.banner');
            route::get('/delete/banner/{id}','DeleteBanner')->name('delete.banner');
         
            
            });
                        // all  Coupon routes
            Route::controller(CouponController::class)->group(function(){
                Route::get('/all/coupon' , 'AllCoupon')->name('all.coupon');
                Route::get('/add/coupon' , 'AddCoupon')->name('add.coupon');
                Route::post('/store/coupon' , 'StoreCoupon')->name('store.coupon');
                Route::get('/edit/coupon/{id}' , 'EditCoupon')->name('edit.coupon');
                Route::post('/update/coupon' , 'UpdateCoupon')->name('update.coupon');
                Route::get('/delete/coupon/{id}' , 'DeleteCoupon')->name('delete.coupon');
            
            }); 
                  // all  ShippingArea division routes
            Route::controller(ShippingAreaController::class)->group(function(){
                Route::get('/all/division' , 'AllDivision')->name('all.division');
                Route::get('/add/division' , 'AddDivision')->name('add.division');
                Route::post('/store/division' , 'StoreDivision')->name('store.division');
                Route::get('/edit/division/{id}' , 'EditDivision')->name('edit.division');
                Route::post('/update/division' , 'UpdateDivision')->name('update.division');
                Route::get('/delete/division/{id}' , 'DeleteDivision')->name('delete.division');
            
            }); 

                      // all  ShippingArea district routes
            Route::controller(ShippingAreaController::class)->group(function(){
                Route::get('/all/district' , 'AllDistrict')->name('all.district');
                Route::get('/add/district' , 'AddDistrict')->name('add.district');
                Route::post('/store/district' , 'StoreDistrict')->name('store.district');
                Route::get('/edit/district/{id}' , 'EditDistrict')->name('edit.district');
                Route::post('/update/district' , 'UpdateDistrict')->name('update.district');
                Route::get('/delete/district/{id}' , 'DeleteDistrict')->name('delete.district');
                    
                    });

                                // all  ShippingArea ALL State  routes
            Route::controller(ShippingAreaController::class)->group(function(){
                Route::get('/all/state' , 'AllState')->name('all.state');
                Route::get('/add/state' , 'AddState')->name('add.state');
                Route::get('/district/ajax/{division_id}' , 'GetDistrict');
                Route::post('/store/state' , 'StoreState')->name('store.state');
                Route::get('/edit/state/{id}' , 'EditState')->name('edit.state');
                Route::post('/update/state' , 'UpdateState')->name('update.state');
                Route::get('/delete/state/{id}' , 'DeleteState')->name('delete.state');

                    });

            Route::controller(OrderController::class)->group(function(){
                Route::get('/pending/order' , 'PendingOrder')->name('pending.order');
                Route::get('/admin/order/details/{order_id}' , 'AdminOrderDetails')->name('admin.order.details');
                Route::get('/admin/confirmed/order' , 'AdminConfirmedOrder')->name('admin.confirmed.order');
                Route::get('/admin/processing/order' , 'AdminProcessingOrder')->name('admin.processing.order');          
                Route::get('/admin/delivered/order' , 'AdminDeliveredOrder')->name('admin.delivered.order');
                Route::get('/pending/confirm/{order_id}' , 'PendingToConfirm')->name('pending-confirm');
                Route::get('/confirm/processing/{order_id}' , 'ConfirmToProcess')->name('confirm-processing');
                Route::get('/processing/delivered/{order_id}' , 'ProcessToDelivered')->name('processing-delivered');
                Route::get('/admin/invoice/download/{order_id}' , 'AdminInvoiceDownload')->name('admin.invoice.download');                

                    });        
                    
            Route::controller(ReturnController::class)->group(function(){
                Route::get('/return/request' , 'ReturnRequest')->name('return.request');
                Route::get('/return/request/approved/{order_id}' , 'ReturnRequestApproved')->name('return.request.approved');
                Route::get('/complete/return/request' , 'CompleteReturnRequest')->name('complete.return.request');
            
            
            });

            Route::controller(ReportController::class)->group(function(){
                Route::get('/report/view' , 'ReportView')->name('report.view');
                Route::post('/search/by/data' , 'SearchByData')->name('search-by-data');
                Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
                Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');
                Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
                Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');
          
            
            
            });

            Route::controller(ActiveUserController::class)->group(function(){
                Route::get('/all/user' , 'AllUser')->name('all-user');
                Route::get('/all/vendor' , 'AllVendor')->name('all-vendor');
            
            
            });

            Route::controller(BlogController::class)->group(function(){

                Route::get('/admin/blog/category' , 'AllBlogCateogry')->name('admin.blog.category'); 
                Route::get('/admin/add/blog/category' , 'AddBlogCateogry')->name('add.blog.categroy');
                Route::post('/admin/store/blog/category' , 'StoreBlogCateogry')->name('store.blog.category');
                Route::get('/admin/edit/blog/category/{id}' , 'EditBlogCateogry')->name('edit.blog.category');
                Route::post('/admin/update/blog/category' , 'UpdateBlogCateogry')->name('update.blog.category');  
                Route::get('/admin/delete/blog/category/{id}' , 'DeleteBlogCateogry')->name('delete.blog.category');
            
            
            });

            Route::controller(BlogController::class)->group(function(){

                Route::get('/admin/blog/post' , 'AllBlogPost')->name('admin.blog.post'); 
                Route::get('/admin/add/blog/post' , 'AddBlogPost')->name('add.blog.post');  
                Route::post('/admin/store/blog/post' , 'StoreBlogPost')->name('store.blog.post');
                Route::get('/admin/edit/blog/post/{id}' , 'EditBlogPost')->name('edit.blog.post');           
                Route::post('/admin/update/blog/post' , 'UpdateBlogPost')->name('update.blog.post');           
                Route::get('/admin/delete/blog/post/{id}' , 'DeleteBlogPost')->name('delete.blog.post');
               
               
               });

            Route::controller(ReviewController::class)->group(function(){

                Route::get('/pending/review' , 'PendingReview')->name('pending.review'); 
                Route::get('/pending/review' , 'PendingReview')->name('pending.review');
                Route::get('/review/approve/{id}' , 'ReviewApprove')->name('review.approve');
                Route::get('/publish/review' , 'PublishReview')->name('publish.review'); 
                Route::get('/review/delete/{id}' , 'ReviewDelete')->name('review.delete');
            
            });

            Route::controller(SiteSettingController::class)->group(function(){

                Route::get('/site/setting' , 'SiteSetting')->name('site.setting');
                Route::post('/site/setting/update' , 'SiteSettingUpdate')->name('site.setting.update');
                Route::get('/seo/setting' , 'SeoSetting')->name('seo.setting');
                Route::post('/seo/setting/update' , 'SeoSettingUpdate')->name('seo.setting.update');
               
               });


///////////////////////// end middleware Admin Controller //////////////////////////////////////////////////////////
});  




  /////////////////////////////////// vendors //////////////////////////////////////////////////////////////
            // Vendor login routes

Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class); //vendor login
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');  //become vendor 
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register'); // vendor register



Route::middleware(['auth','role:vendor'])->group( function() {

     // vendor  profile
    Route::controller(VendorController::class)->group( function () {
         route::get('/vendor/dashboard','VendorDashboard')->name('vendor.dashboard');
         route::get('/vendor/logout','VendorDestroy')->name('vendor.logout');
         route::get('/vendor/profile','VendorProfile')->name('vendor.profile');
         route::post('/vendor/profile/store','VendorProfileStore')->name('vendor.profile.store');
         route::get('/vendor/change/password','VendorPhangePassword')->name('vendor.change.password');
         route::post('/vendor/update/password','VendorUpdatePassword')->name('vendor.update.password');               
});

   // vendor add product All routes
    Route::controller(VendorProductController::class)->group( function () {
         route::get('/vendor/all/product','VendorAllProduct')->name('vendor.all.product');
         route::get('/vendor/add/product','VendorAddProduct')->name('vendor.add.product');  
         route::get('/vendor/subcategory/ajax/{category_id}','VendorGetSubCategory');
         route::post('/vendor/store/product','VendorStoreProduct')->name('vendor.store.product');
         Route::get('/vendor/edit/product/{id}' , 'VendorEditProduct')->name('vendor.edit.product');
         Route::post('/vendor/update/product' , 'VendorUpdateProduct')->name('vendor.update.product');
         Route::post('/vendor/update/product/thambnail' , 'VendorUpdateProductThambnail')->name('vendor.update.product.thambnail');
         Route::post('/vendor/update/product/multiimage' , 'VendorUpdateProductMultiimage')->name('vendor.update.product.multiimage');
         Route::get('/vendor/product/multiimage/delete/{id}' , 'VendorProductMultiimageDelete')->name('vendor.product.multiimage.delete');
         Route::get('/vendor/inactive/product/{id}' , 'VendorInactiveProduct')->name('vendor.inactive.product');
         Route::get('/vendor/active/product/{id}' , 'VendorActiveProduct')->name('vendor.active.product');
         Route::get('/vendor/delete/product/{id}' , 'VendorDeleteProduct')->name('vendor.delete.product');
   
                    
});


Route::controller(VendorOrderController::class)->group( function () {
    Route::get('/vendor/order','VendorOrder')->name('vendor.order');
    Route::get('/vendor/return/order','VendorReturnOrder')->name('vendor.return.order');
    Route::get('/vendor/complete/return/order' , 'VendorCompleteReturnOrder')->name('vendor.complete.return.order');
    Route::get('/vendor/order/details/{order_id}' , 'VendorOrderDetails')->name('vendor.order.details');


               
});

Route::controller(ReviewController::class)->group(function(){

    Route::get('/vendor/all/review' , 'VendorAllReview')->name('vendor.all.review');
   
   });

  /////////////////////////////////// end middleware vendor controller //////////////////////////////////////////////////////////////
});  


 /////////////////////////////////// Frontend product details all route   ////////////////////////////////////

                /// product details 
    Route::controller(IndexController::class)->group( function () {
        Route::get('/product/details/{id}/{slug} ' , 'ProductDetails')->name('product.details');
        Route::get('/vendor/details/{id} ' , 'VendorDetails')->name('vendor.details');
        Route::get('/vendor/all' , 'VendorAll')->name('vendor.all');
        Route::get('/product/category/{id}/{slug}' , 'CatWiseProduct')->name('product.category');
        Route::get('/product/subcategory/{id}/{slug}' , 'SubCatWiseProduct')->name('product.subcategory');
        Route::get('/product/view/modal/{id}' , 'ProductViewAjax');
       

     });  
            // ajax Add To Cart and view data 
     Route::controller(CartController::class)->group( function () {
        Route::post('/cart/data/store/{id} ' , 'AddToCart');
        Route::get('/product/mini/cart ' , 'AddMiniCart');
        Route::get('/minicart/product/remove/{rowId}' , 'RemoveMiniCart');
        Route::post('/dcart/data/store/{id}' , 'AddToCartDetails');
  
     });  
        // ajax add Wishlist
     Route::controller(WishlistController::class)->group( function () {
        Route::post('/add-to-wishlist/{product_id} ' , 'AddToWishlist');
        
     });
        // ajax add Compare
     Route::controller(CompareController::class)->group( function () {
        Route::post('/add-to-compare/{product_id} ' , 'AddToCompare');
    
         
        }); 
   // my cart view
   Route::controller(CartController::class)->group(function(){
    Route::get('/mycart' , 'MyCart')->name('mycart');
    Route::get('/get-cart-product' , 'GetCartProduct');
    Route::get('/cart-remove/{rowId}' , 'Cartremove');
    Route::get('/cart-decrement/{rowId}' , 'CartDecrement');
    Route::get('/cart-increment/{rowId}' , 'CartIncrement');

    Route::get('/checkout' , 'CheckoutCreate')->name('checkout');

     });  
     Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
     Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
     Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);


     Route::controller(BlogController::class)->group(function(){

        Route::get('/blog' , 'AllBlog')->name('home.blog');
        Route::get('/post/details/{id}/{slug}' , 'BlogDetails'); 
        Route::get('/post/category/{id}/{slug}' , 'BlogPostCategory');   
       
       
       });

    Route::controller(ReviewController::class)->group(function(){

        Route::post('/store/review' , 'StoreReview')->name('store.review'); 
 
       
       
       });

 /////////////////////////////////// Frontend product details all route   ////////////////////////////////////

   
     
      /////////////////////////////////// user midddleware  all route   ////////////////////////////////////
Route::middleware(['auth','role:user'])->group(function() {

    Route::controller(WishlistController::class)->group(function(){
        Route::get('/wishlist' , 'AllWishlist')->name('wishlist');
        Route::get('/get-wishlist-product' , 'GetWishlistProduct');
        Route::get('/wishlist-remove/{id}' , 'WishlistRemove');
      
        }); 

    Route::controller(CompareController::class)->group(function(){
        Route::get('/compare' , 'AllCompare')->name('compare');
        Route::get('/get-compare-product' , 'GetCompareProduct');
        Route::get('/compare-remove/{id}' , 'CompareRemove'); 
            
    
         });  

    Route::controller(CheckoutController::class)->group(function(){
        Route::get('/district-get/ajax/{division_id}' , 'DistrictGetAjax');
        Route::get('/state-get/ajax/{district_id}' , 'StateGetAjax');
        Route::post('/checkout/store' , 'CheckoutStore')->name('checkout.store');
       
        
        });
        
    Route::controller(StripeController::class)->group(function(){
        Route::post('/stripe/order' , 'StripeOrder')->name('stripe.order');

        
        }); 

    Route::controller(CashController::class)->group(function(){
        Route::post('/cash/order' , 'CashOrder')->name('cash.order');      
        
        });
        
    Route::controller(AllUserController::class)->group(function(){
        Route::get('/user/account/page' , 'UserAccount')->name('user.account.page');      
        Route::get('/user/change/password' , 'UserChangePassword')->name('user.change.password');
        Route::get('/user/order/page' , 'UserOrderPage')->name('user.order.page');    
        Route::get('/user/order_details/{order_id}' , 'UserOrderDetails')->name('user.order_details');    
        Route::get('/user/invoice_download/{order_id}' , 'UserOrderInvoice')->name('user.invoice_download');    
        Route::post('/return/order/{order_id}' , 'ReturnOrder')->name('return.order');    
        Route::get('/return/order/page' , 'ReturnOrderPage')->name('return.order.page');    
        Route::get('/user/track/order' , 'UserTrackOrder')->name('user.track.order');
        Route::post('/order/tracking' , 'OrderTracking')->name('order.tracking');
 
        
        }); 
          
      //////////////////////////////////// end middleware User Controller  ////////////////////////////////////
});  

        

    

 ////////////////////////////////////////////////////////////////////////////////////////////////



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
