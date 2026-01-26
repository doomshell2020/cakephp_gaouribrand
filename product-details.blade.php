@push('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('public/css/zoom-slider.css') }}">
@endpush
@extends('frontend.layout')
@section('content')
@php
$root="https://vasvi.in/public/script/";
$pid=$product->id;
@endphp
<div class="headertopspace"></div>
<!--  =================   Body Element start ======================================= -->
<div class="container">
   <div class="product-detail">
      <div class="row">
         <!--  =================   Product Slider start Left side =========================  -->
         <div class="col-md-6">
            <div class="row">
               <div class="col-md-12">
                  <main class='main-wrapper'>
                     <div class='container'>
                        <article class='product-details-section'>
                           <!-- breadcrum with structured data parameters for ga -->
                           <section>
                              <div class="small-img">
                                 <img src="images/online_icon_right@2x.png" class="icon-left" alt="" id="prev-img">
                                 <div class="small-container">
                                    <div id="small-img-roll">
                                       <img src="{{ URL::asset('public/img/uploads/'.$product->productImages()->where('type','front')->first()->image) }}" class="show-small-img" alt="">
                                       @foreach($product->productImages()->where('type','slider')->get() as $image )
                                       <img src="{{ URL::asset('public/img/uploads/'.$image->image) }}" class="show-small-img" alt="">
                                       @endforeach
                                       <img src="https://picsum.photos/1000/1000/?random" class="show-small-img" alt="">
                                    </div>
                                 </div>
                                 <img src="{{ URL::asset('public/img/uploads/'.$product->productImages()->where('type','back')->first()->image) }}" class="show-small-img" alt="">
                              </div>
                              <div class="show" href="{{ URL::asset('public/img/uploads/'.$product->productImages()->where('type','front')->first()->image) }}">
                                 <img src="{{ URL::asset('public/img/uploads/'.$product->productImages()->where('type','front')->first()->image) }}" id="show-img">
                              </div>
                           </section>
                           <div class='clear'></div>
                           <!--<ul>
                              <li><a  href="#" target="_blank"><img src="images/fb.jpg" alt="Share with Facebook"></a></li>
                              <li><a  href="#" target="_blank"><img src="images/social_twitter.jpg" alt="Share with Twitter"></a></li>
                              <li><a  href="#" target="_blank"><img src="images/whatsapp.png" alt="Share with Whatsapp"></a></li>
                              <li><a  href="#" target="_blank"><img src="images/gplus.jpg" alt="Share with Google Plus"></a></li>
                              <li><a  href="#" target="_blank"><img src="images/pinterest.jpg" alt="Share with Pinterest"></a></li>
                              </ul>-->
                        </article>
                     </div>
                  </main>
                  <div for='' id='sizeselected'></div>
               </div>
            </div>
         </div>
         <!--  =================   Product Slider END LEFT side =========================  --> 
         <!--  =================   Add to cart start Right side =========================  -->
         <div class="col-md-6">
            <div class="row">
               <div class="col-md-12">
                  <div class="title-product">
                     <h1>{{$product->name}}</h1>
                  </div>
                  <div id="rating_reviewmain">
                  </div>
                  @if((strtotime(date('Y-m-d')) >= strtotime($product->discount_date_from)) && (strtotime(date('Y-m-d')) <= strtotime($product->discount_date_to)) )
                  <div class="text-price-title">Offer Price</div>
                  <div class="product-price"><span class="bold-price"><i class="fas fa-rupee-sign" style="font-size:18px;"></i> {{$product->cutprice}}</span> <span class="cut-price"><i class="fas fa-rupee-sign" style="font-size:14px;"></i>{{$product->price}}</span> <span class="text-success txt-discount">-{{$product->discount}}% off</span></div>
                  @else
                  <div class="text-price-title">Price</div>
                  <div class="product-price"><span class="bold-price"><i class="fas fa-rupee-sign" style="font-size:18px;"></i> {{$product->price}}</span></div>
                  @endif
               </div>
            </div>
            <div class="row">
               <div class="col-md-12"> 
                  <div class="product-size">
                     <ul>
                        <li class="boldtxt">Size</li>
                        @foreach ($sizes as $size)
                        <li><a href="#" @if(!in_array($size->id,$productSizes)) class="not-available" @endif>{{$size->name}}</a></li>
                        @endforeach
                        {{-- 
                        <li><a href="#" class="disabled">S</a></li>
                        --}}
                     </ul>
                  </div>
                  <div class="product-color">
                     <ul>
                        <li class="boldtxt">Color</li>
                        @foreach ($product->colors as $color)
                        <li><a href="#" style="background:#{{$color->name}};"></a></li>
                        <li class="prod-color-img"><img src="http://batinvegas.com/vasvi.in/public/img/uploads/1587304362ARP3516.jpg" > </li>
                        @endforeach
                     </ul>
                  </div>
                  <div>
                     <div class="row quantity">
                        <div class="col-md-1 "> <span class="quantity boldtxt">Qty. </span> </div>
                        <div class="col-md-4" style="padding-right:0px;">
                           <div class="input-group">
                              <span class="input-group-btn">
                              <button type="button" class="btn btn-danger btn-number" style="background:#ed6388;"  data-type="minus" data-field="quant[2]">
                              <span class="glyphicon glyphicon-minus"></span>
                              </button>
                              </span>
                              <input type="text" name="quant[2]" id="quantity" class="form-control input-number" value="1" min="1" max="100">
                              <span class="input-group-btn">
                              <button type="button" class="btn btn-success btn-number" style="background:#ed6388;" data-type="plus" data-field="quant[2]">
                              <span class="glyphicon glyphicon-plus"></span>
                              </button>
                              </span>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <input type="hidden" id="uid"  value="{{ @$user->id }}" />
                           <button onClick="insertwishlist({{ $product->id }})" type="button" class="btn-wishlist"> <i class="fa fa-heart" aria-hidden="true"></i><span>Wishlist</span></button> <button type="button" class="btn-wishlist" onClick="javascript:void(0)"> <i class="fas fa-share-alt" onClick="share_it()"></i><input type="hidden" id="sharestatus" value="false"><span onClick="share_it()">Share</span></button>
                           <div class="share-icons" id="social_icon" style="top: 25px; bottom: auto; left: 0px; z-index: 5; display: none;">
                              <a href="" class="ssk ssk-facebook"></a>
                              <a href="" class="ssk ssk-twitter"></a>
                              <a href="" class="ssk ssk-google-plus"></a>
                              <a href="" class="ssk ssk-pinterest"></a>
                              <a href="" class="ssk ssk-linkedin"></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="delivery-address"><span class="boldtxt"><i class="fas fa-map-marker-alt"></i> Delivery</span> <input type="text" placeholder="Check your area availability" /><button class="btn-check text-success">Check</button></div>
                  <div><button type="button" class="btn-addcart">Add to Cart</button>  <button type="button" class="btn-buynow">Buy Now</button></div>
               </div>
            </div>

            <div class="row authentic-product-row clearfix pt-3" data-id="miscComponent1">
            <div class="col-md-4" style="margin-top: 20px;">
            <span class="authentic-product"><i class="fas fa-cloud-meatball"></i> 100% Authentic
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products</span>
            </div>
            
            <div class="col-sm-3 free-shipping-container" style="margin-top: 20px;">
               <span class="free-shipping" title="Free Delivery On Orders Of Rs 900 &amp; above"><span><i class="fas fa-shipping-fast"></i> free
                          <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;shipping*</span></span>
              </div>
             
              <div class="col-md-4 express-container" style="margin-top: 20px;">
                      <span class="express"><i class="fab fa-usps"></i> Easy Return Policy  
                    </div>
              </div>
         </div>
         <!--  ================ Tab Section Start ======================== -->
         <div class="clear"></div>
         <div class="container product-description">
            <h3>Product Detail</h3>
            <div class="col-md-4 col-sm-12">
               <strong>Product Description</strong>
               <p>{{$product->description}}</p>
               <p>Product code: {{$product->slug}}<br/>Need help? <a href="#">Contact us</a></p>
            </div>
            <div class="col-md-4 col-sm-12">
               <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-product-des" >
                  <tbody>
                     <tr>
                        <th>Product Type</th>
                        <td>{{$product->productType->name}}</td>
                     </tr>
                     <tr>
                        <th>Fabric</th>
                        <td>{{$product->fabric->name}}</td>
                     </tr>
                     <tr>
                        <th>Pattern</th>
                        <td>{{$product->pattern->name}}</td>
                     </tr>
                     <tr>
                        <th>Fit</th>
                        <td>{{$product->RegularFit->name}}</td>
                     </tr>
                     <tr>
                        <th>Occasion</th>
                        <td>{{$product->occasion->name}}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="col-md-4 col-sm-12">
               <p><strong>Care Instructions</strong> <br/>{{$product->caredetails}}</p>
               <p><strong>DISCLAIMER:</strong> <br/>{{$product->disclaimer}}</p>
            </div>
         </div>
         <div class="col-md-12">
            <div class="container">
               <ul class="nav nav-tabs product-detail-tab" role="tablist">
                  <li role="presentation" class="active"><a href="#product-detail" aria-controls="product-detail" role="tab" data-toggle="tab">BRAND INFO</a></li>
                  <li role="presentation"><a href="#rating" aria-controls="rating" role="tab" data-toggle="tab">Rating & Review</a></li>
                  <li role="presentation"><a href="#return" aria-controls="return" role="tab" data-toggle="tab">Return</a></li>
                  <li role="presentation"><a href="#delivery" aria-controls="delivery" role="tab" data-toggle="tab">Care</a></li>
               </ul>
               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="product-detail">
                     <p>Take this pink multicolor suit-set home and adorn a different&nbsp;look this time. It is a set of three. A polymetallic&nbsp;multicolour&nbsp;kurta, contrasting blue skirt and a dupatta matching to the skirt. It is a gorgeous set and will look just fabulous with mid-heel sandals and matching&nbsp;jewellery.</p>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="rating">
                     <div class="product_detail rating-panel">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="ratingleft">
                                 <p> <span>400/</span><span style="font-size: 25px">5</span> <i class="fa fa-star" aria-hidden="true"></i></p>
                                 <p class="rate_title">Overall rating 1</p>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <ul class="rating-recommend">
                                 <li>Do you recommend this product?</li>
                                 <li> <a href="#"  data-toggle="modal" data-target="#myModal11" class="btn btn-pink">Write a review</a>  </li>
                              </ul>
                           </div> 
                        </div>
                     </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="return">
                     <div class="col-md-4 col-sm-12 text-center returns-col">
                        <i class="far fa-calendar-alt"></i>
                        <p>
                           <Strong>Easy Returns</Strong><br/><br/>
                           If you are not completely satisfied with your purchase, you can return most items to us within 14 days of delivery to get a 100% refund. We offer free and easy returns through courier pickup, or you can exchange most items bought online at any of our stores across India.<br/>
                           <a href="#">For More details read our Return Policy</a>
                        </p>
                     </div>
                     <div class="col-md-4 col-sm-12 text-center returns-col">
                        <i class="far fa-calendar-alt"></i>
                        <p>
                           <Strong>Easy Exchange</Strong><br/><br/>
                           If you are not completely satisfied with your purchase, you can return most items to us within 14 days of delivery to get a 100% refund. We offer free and easy returns through courier pickup, or you can exchange most items bought online at any of our stores across India.<br/>
                           <a href="#">For More details read our Return Policy</a>
                        </p>
                     </div>
                     <div class="col-md-4 col-sm-12 text-center returns-col">
                        <i class="fas fa-shopping-bag"></i>
                        <p>
                           <Strong>Delivery</Strong><br/><br/>
                           Typically Delivered in 5-7 days.<br/>
                           <a href="#">For More details read our Exchange Policy *T & C Apply</a>
                        </p>
                     </div>
                  </div>
                  <!--  ================ Tab Section end ======================== --> 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<div class="modal fade" id="myModal11" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header modal-header-black">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-white">Write A Review </h4>
         </div>
         <div class="modal-body">
            <div class="review-box review-box-border">
               <p>Rate the product : <span class="small"> Select the number of stars.</span>
               </p>
               <div class="star-rating">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
               </div>
            </div>
            <div class="review-box">
               <p><b>Review Title</b></p>
               <input id=" " name="headline" class=" form-control" placeholder="E.g. Nice Product | Max 50 characters" maxlength="50" type="text" value="" autocomplete="on"> 
            </div>
            <div class="review-box">
               <p><b>Your review</b></p>
               <textarea class="form-control" id=" " name="comment" onkeyup="countProductReviewCommentLength();" placeholder="Write your review here" maxlength="300"></textarea>
            </div>
            <div class="review-box">
               <input type="checkbox" id="checkbox" name="isRecommended" checked=""> <label for="checkbox">Yes,
               I recommend this product</label> 
            </div>
            <div>
               <div class="row">
                  <div class="col-md-6">
                     <button type="button" class="btn-review-cancel btn-block">Cancel</button>  
                  </div>
                  <div class="col-md-6">
                     <button type="button" class="btn-submit-review  btn-block">Submit</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-body">
            @if($user)
            {!! Form::open(['method'=>'post' ,'id'=>'review_form']) !!}
            <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
            <div class="overall-rating">(Average Rating <span id="avgrat">3.5</span>
               Based on <span id="totalrat">100</span>  rating)</span>
            </div>
            <textarea placeholder="Review here" id="review" style="width:100%;" required ></textarea>
         </div>
         <div class="modal-footer">
            <button type="button"  class="btn btn-default" onClick="submit_review()" >Submit</button>
         </div>
         @else
         <div class="modal-body"><a href="/signin">Login In to Review</a></div>
      </div>
      @endif
      </form>
   </div>
</div>
</div>
@endsection
@push('script')
<script src="{{ URL::asset('public/js/zoom-slider.js') }}"></script> 
<script src="{{ URL::asset('public/js/zoom-slider-main.js') }}"></script> 
<script type="text/javascript">
   $(".btn-wishlist").click(function () {
       $(".account-dropdown").show();
   });
   
   $(document).click(function (e) {
       if (!$(e.target).hasClass("btn-wishlist") 
           && $(e.target).parents(".account-dropdown").length === 0) 
       {
           $(".account-dropdown").hide();
       }
   });
   
</script>
@if($user)
@php $users_id=$user->id  ;@endphp
<script language="javascript" type="text/javascript">
   (function(a){
   a.fn.spaceo_rating_widget = function(p){
     var p = p||{};
     var b = p&&p.starLength?p.starLength:"5";
     var c = p&&p.callbackFunctionName?p.callbackFunctionName:"";
     var e = p&&p.initialValue?p.initialValue:"0";
     var d = p&&p.imageDirectory?p.imageDirectory:"public/img";
     var r = p&&p.inputAttr?p.inputAttr:"";
     var f = e;
     var g = a(this);
     b = parseInt(b);
     init();
     g.next("ul").children("li").hover(function(){
         $(this).parent().children("li").css('background-position','0px 0px');
         var a = $(this).parent().children("li").index($(this));
         $(this).parent().children("li").slice(0,a+1).css('background-position','0px -28px')
     },function(){});
     g.next("ul").children("li").click(function(){
         var a = $(this).parent().children("li").index($(this));
         var attrVal = (r != '')?g.attr(r):'';
         f = a+1;
         g.val(f);
         if(c != ""){
             eval(c+"("+g.val()+", "+attrVal+")")
         }
     });
     g.next("ul").hover(function(){},function(){
         if(f == ""){
             $(this).children("li").slice(0,f).css('background-position','0px 0px')
         }else{
             $(this).children("li").css('background-position','0px 0px');
             $(this).children("li").slice(0,f).css('background-position','0px -28px')
         }
     });
     function init(){
         $('<div style="clear:both;"></div>').insertAfter(g);
         g.css("float","left");
         var a = $("<ul>");
         a.addClass("spaceo_rating_widget");
         for(var i=1;i<=b;i++){
             a.append('<li style="background-image:url('+"../"+d+'widget_star.gif)"><span>'+i+'</span></li>')
         }
         a.insertAfter(g);
         if(e != ""){
             f = e;
             g.val(e);
             g.next("ul").children("li").slice(0,f).css('background-position','0px -28px')
         }
     }
   }
   })(jQuery);
   
   $(function() {
   $("#rating_star").spaceo_rating_widget({
     starLength: '5',
     initialValue: '',
     callbackFunctionName: 'processRating',
     imageDirectory: 'public/img/',
     inputAttr: 'post_id'
   });
   });
   
   function processRating(val, attrVal){
   //alert();
   
   // var dataString1='post_id=<?php echo $pid;  ?>&points='+val+'&users_id=<?php echo $users_id;  ?>';
   var productId={{$pid}};
   var points=val;
   var userId={{$users_id}};
   $.ajax({
     type: "POST",crossDomain: true, cache: false,
     url: "{{Route('products.product-rating')}}",
     data: {
       productId,points,userId,
       "_token": "{!! csrf_token() !!}",
     },
     success: function(data){
         var obj = JSON.parse(data);
         if(obj.status == "1")
         {
          alert('You have already Rated for this product');
         }else if(obj.status == "2"){
            alert('You have rated '+val+' to Vasvi.in');
             $('#avgrat').html(obj.average_rating);
             $('#totalrat').html(obj.rating_number);
         }
         else 
         {
             alert('please after some time.');
   
         }
         
     }
   });
   return false;
   }
   
   
   function submit_review()
   {
   var reviews=$('#review').val();
   
   if(review=="")
   {
   alert("Please Enter your Review");
   return false;
   }
   
   else 
   {
     //alert();
   var productId={{$pid}};
   var userId={{$users_id}};
   $.ajax({
     type: "POST",crossDomain: true, cache: false,
     url:"{{Route('products.product-review')}}",
     data:{
       productId,reviews,userId,
       "_token": "{!! csrf_token() !!}",
     },
     success: function(data){
      var obj = JSON.parse(data);
      if(obj.status == "1")
         {
          alert('We have already received your review');
             $('#review').val('');
         }else if(obj.status == "2"){
          alert('Thanks for Your Review');
             $('#review').val('');
         }
         else 
         {
             alert('please after some time.');
   
         }
     }
   });
   
   
   return false;
   }
   }
</script>
@endif
@endpush