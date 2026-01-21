<!DOCTYPE html>
<html lang="en">

<head>
   <?php require_once 'general/__header__.tpl' ?>

   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

   <script type="text/javascript">
      function preventBack() { window.history.forward(); }
      setTimeout("preventBack()", 0);
      window.onunload = function () { null };    
   </script>
   <style>
      .symbol {
         font-size: 55px;
         position: absolute;
         display: inline;
         top: 7px;
      }

      .text_line {
         position: relative;
         left: 77px;
         display:
            inline;
         text-align: left;
      }

      .symbol-wrap {
         width: 398px;
         margin: 0 auto;
      }

      @media (max-width:992px) {
         .symbol {
            font-size: 50px;
            position: absolute;
            display: inline;
            top: 6px;
         }

         .symbol-wrap {
            width: 300px;
            margin: 0 auto;
         }
      }

      @media (max-width:491px) {
         .symbol {
            font-size: 44px;
            position: absolute;
            display: inline;
            top: 11px;
            left: 21px;
         }

         .text_line {
            position: relative;
            left: 25px;
            display: inline;
            text-align: left;
         }
      }

      @media (max-width:420px) {
         .symbol {
            font-size: 48px;
            position: absolute;
            display: inline;
            top: 31px;
         }

         .text_line {
            position: relative;
            left: 67px;
            display: inline-block;
            text-align: left;
            width: 260px;
         }
      }
   </style>

   <link rel="stylesheet" type="text/css" href="<?= $path['css'] ?>/combined-css.css?v=1.5">
   <link href="<?= $path['css'] ?>/popupExit.css" type="text/css" rel="stylesheet" />
   <style>
      #app_common_modal_close,
      #error_handler_overlay_close {
         line-height: 25px !important;
      }

      img.footer-logo.ftr-logo {
         top: 0;
         right: 0;
         margin: 0 auto;
         display: table;
         position: relative;
      }

      @media (min-width: 760px) and (max-width: 992px) {
         img.Step1_Product-col-sm-offset-2-03.device-desktop-page-index-flow-skin-v3-step-1-img-7 {
            left: 45px !important;
         }

         img.Step1_Product-col-sm-offset-2-03.device-desktop-page-index-flow-skin-v3-step-1-img-7 {
            left: 215px !important;
         }

         img.Step1_Product-col-sm-offset-2-02 {
            left: 46px;
         }
      }

      @media (min-width: 840px) and (max-width: 992px) {
         img.Step1_Product-col-sm-offset-2-03.device-desktop-page-index-flow-skin-v3-step-1-img-7 {
            left: 222px !important;
         }

         img.Step1_Product-col-sm-offset-2-02.device-desktop-page-index-flow-skin-v3-step-1-img-6 {
            left: 50px !important;
         }
      }

      @media (min-width:320px) and (max-width:767px) {
         .footerC2a {
            overflow: hidden !important
         }
      }

      .video-box {
         position: relative;
         margin: 1rem auto 3rem;
         padding-top: 20px;
         max-width: 800px;
         width: 100%;
         border: 3px solid #000;
         border-radius: 12px;
         text-align: center;
         line-height: 0px;
         padding: 0;
         margin-top: 55px;
      }


      .video-box .box-headline {
         position: absolute;
         font-size: 1.8rem;
         top: -22px;
         left: 50%;
         z-index: 1;
         display: inline-block;
         /* padding: 0 1rem; */
         background-color: #fff;
         white-space: nowrap;
         font-weight: 800;
         transform: translate(-50%, 0);
      }


      .video-box video {
         width: 100%;
         height: 500px;
      }

      @media screen and (min-width: 320px) and (max-width: 768px) {
         .video-box video {
            width: 100%;
            height: auto;
         }

         .video-box {
            border: 0;
         }

         .video-box .box-headline {
            font-size: 1.2rem;
            width: 100%;
            top: -30px;
            white-space: normal;
            line-height: 1.3 !important;
            margin-bottom: 20px;
         }
      }

      @media screen and (min-width: 1200px) and (max-width: 4000px) {
         .mb-d12 {
            margin-top: 12px;
         }

         .mt-d29 {
            margin-top: -29px !important;
         }
      }



      @media (min-width:320px) and (max-width: 767px) {
         img.footer-logo.ftr-logo {
            top: 31px;
            right: 0;
            margin: 0 auto;
            display: table;
            position: relative;
            max-width: 297px;
         }
      }

      #app_common_modal_close,
      #error_handler_overlay_close {
         line-height: 27px !important;
      }

      @media (max-width:992px) {
         .mb-d12 {
            font-size: 28px !important;
         }
      }

      .headerbg {
         overflow-x: hidden;
      }
   </style>
</head>

<body>
   <?php include 'general/__gtag_script__.tpl';
        perform_body_tag_open_actions(); ?>
   <p id="loading-indicator" style="display:none;">Processing...</p>

   <div class="top">
      <div class="container">
         <b>ATTENTION:</b>&nbsp;Due to a high demand from recent media coverage our stock is going fast and limited! As
         of right now we currently have products in-stock and will ship within 24 hours of purchase.
      </div>
   </div>
   </div>
   <!-- nav-->
   <div class="contactInfo">
      <div class="container">
         <div class="row">
            <div class="col-sm-12 independent text-center">100% Money Back Guarantee that it Works!</div>
         </div>
      </div>
   </div>
   <nav class="navbar" role="navigation">
      <div class="navbar-default navbar-inner">
         <div class="container">
            <div class="row">
               <div class="navbar-header">
                  <div class="navbar-brand"> <img class="img-responsive"
                        src="<?= $path['images'] ?>/logo-exfol-transblack.png"> <span style="font-size:11px;">Visible
                        Results
                        in <strong>1 WEEK!</strong></span> </div>
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                     aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span
                        class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
               </div>
            </div>
         </div>
      </div>
   </nav>
   <!--/nav-->
   <style>
      #headup {
         height: 1000px;
         width: 100%;
         position: absolute;
      }

      .conta {
         position: relative;
         height: 1000px;
      }
   </style>

   <div class="headerbg headup" id="headup"></div>

   <div id="zoomed">
      <section id="header">
         <div class="container">
            <div class="row">
               <div class="col-sm-8 nopad">
                  <img src="<?= $path['images'] ?>/logo-exfol-transblack.png" alt="logo" class="Top_Logo desk-logo">
                  <div class="mid-imglogo">
                     <img src="<?= $path['images'] ?>/logo-mob.png" alt="logo" class="Top_Logo mob-logo">
                  </div>
                  <img src="<?= $path['images'] ?>/logo-exfol-transblack.png" alt="logo" class="Top_Logo desk-logo">
                  <img src="<?= $path['images'] ?>/image.png" alt="product"
                     class="product Step1_Product device-desktop-page-index-flow-skin-v3-step-1-img-1 pos-chng1">
                  <div>
                     <img src="<?= $path['images'] ?>/main-grabber-desktop-1.png" class="img-responsive desktop deskimg"
                        style="margin-bottom:25px;">
                     <img src="<?= $path['images'] ?>/main-grabber-mobile-1.png"
                        class="img-responsive mobile center-block" style="margin-bottom:25px;">
                  </div>
                  <div class="viraltext">
                     <img src="<?= $path['images'] ?>/stars.png" width="170" height="37"
                        class="img-responsive center-block" alt=""> <br>
                     &ldquo;Find out why Aeterna Skincare Age Defying Cream is going viral&rdquo;
                  </div>
                  <div class="viraltextm"> CLAIM YOUR FREE SAMPLE! </div>
               </div>
               <div class="col-sm-4 nopad">
                  <div class="formSeals">
                     <img src="<?= $path['images'] ?>/seals-top_n.png" width="330" height="108" alt=""
                        class="center-block img-responsive">
                  </div>
                  <a name="ordernow" id="ordernow"></a>
                  <div class="formBox">
                     <div class="formTop">Where do we<br> Send your Sample? <img
                           src="<?= $path['images'] ?>/form-arrow.png" class="desktop" height="415" alt="">
                     </div>
                     <div class="stripe"> EXCLUSIVE CLINICAL FORMULA AVAILABLE NOW </div>
                     <div id="form-top"></div>
                     <form method="post" class="prospect-form" action="ajax.php?method=new_prospect"
                        name="fullprospect_form" accept-charset="utf-8"
                        enctype="application/x-www-form-urlencoded;charset=utf-8">
                        <div class="formBody">
                           <div class="fields">
                              <input type="text" name="firstName" placeholder="First Name"
                                 class="required input-fields form-control"
                                 data-error-message="Please enter your First Name!" />
                           </div>
                           <div class="fields">
                              <input type="text" name="lastName" placeholder="Last Name"
                                 class="required input-fields form-control"
                                 data-error-message="Please enter your Last Name!" />
                           </div>
                           <div class="fields" style="display: none">
                              <select name="shippingCountry" class="required input-fields form-control"
                                 data-selected="US" data-error-message="Please select your Country!"
                                 id="shippingCountry">
                                 <option>Select Country</option>
                              </select>
                           </div>
                           <div class="fields">
                              <input type="text" name="shippingAddress1" placeholder="Address"
                                 class="required input-fields form-control"
                                 data-error-message="Please enter your Address!" id="gmap_autocomplete" />

                           </div>
                           <!-- <div class="fields">
                           <input type="text" id="shippingAddress2" name="shippingAddress2" placeholder="Apt / Suite #"
                              class="input-fields form-control input-block"
                              data-error-message="Please enter your address2!" id="input-fields" />
                        </div> -->
                           <div class="fields">
                              <input type="tel" name="shippingZip" placeholder="Zip Code"
                                 class="required input-fields form-control"
                                 data-error-message="Please enter a valid Zip Code!" maxlength="5"
                                 onkeypress="return isNumberKey(event)" id="zip" />
                           </div>
                           <div class="fields">
                              <input type="text" name="shippingCity" placeholder="City"
                                 class="required input-fields form-control" data-error-message="Please enter your City!"
                                 id="city" />
                           </div>
                           <div class="fields">
                              <input type="text" name="shippingState" placeholder="State"
                                 class="required input-fields form-control"
                                 data-error-message="Please select your State!" id="shippingState" />
                           </div>
                           <div class="fields">
                              <input value='' type='email' name='email' data-group='1' placeholder='Email Address'
                                 required data-field='email' class='form-control required'
                                 data-error-message="Please enter a valid Email Address!">
                           </div>
                           <div class="fields">
                              <input type="tel" maxlength="12" name="phone" placeholder="Phone"
                                 class="required input-fields form-control" data-validate="phone"
                                 data-error-message="Please enter a valid Phone Number!" data-min-length="10"
                                 data-max-length="10"
                                 onkeyup="javascript: this.value = this.value.replace(/[^0-9]/g,'');" />
                           </div>
                           <div id="rushtop">
                              <input type="image" src="<?= $path['images'] ?>/rush-my-order.png"
                                 class="img-responsive center-block" id="noexit" 0 />
                              <center>
                                 <span style="font-size:12px;color:#666"> <i class="fa fa-lock"></i> 256 bit secure
                                    form</span>
                              </center>
                           </div>
                        </div>
                     </form>
                  </div>
                  <br>
                  <img src="<?= $path['images'] ?>/secureicons.jpg" width="354" height="51"
                     class="center-block img-responsive" alt="">
               </div>
               <p id="loading-indicator" style="display:none;">Processing...</p>
               <p id="crm-response-container" style="display:none;">Limelight messages will appear here...</p>
            </div>
         </div>
      </section>
      <section id="section1">
         <div class="container">
            <div class="row">
               <div class="col-sm-7" style="padding:30px;">
                  <h2>Revolutionary Break-through!</h2>
                  <p class="highlight">Why does it have <strong>Scientists</strong>, <strong>Doctors</strong> and
                     <strong>Celebrities</strong> Buzzing?
                  </p>
                  <br>
                  <p><strong><span class="maroon underline">The most talked about age reversal and wrinkle reducing
                           formula
                           is finally here!</span></strong> The Age Defying Cream breakthrough that has the media in a
                     frenzy!
                     Aeterna Skincare Age Defying Cream contains the key that activates age reversal and can reverse
                     the signs
                     of
                     aging visibly in just a short period of time.
                  </p>
                  <p><strong><span style="text-decoration: underline;">Aeterna Skincare Age Defying Cream is here to
                           stay
                           because
                           of the unsurmountable success people are having turning back the hands of
                           time!</span></strong>
                  </p>
                  <br>
                  <img src="<?= $path['images'] ?>/seals-top_n.png" width="330" height="108" class="img-responsive"
                     alt="">
               </div>
               <div class="col-sm-5 nopad">
                  <img src="<?= $path['images'] ?>/image.png?5511004" alt="product"
                     class="product Step1_Product-col-sm-5 device-desktop-page-index-flow-skin-v3-step-1-img-2 img-btl1">
                  <img src="<?= $path['images'] ?>/feature-product.jpg?ver=4.0"
                     class="img-responsive pull-right desktop" alt="">
                  <img src="<?= $path['images'] ?>/feature-product-m.png?ver=4.0" width="528" height="444"
                     class="center-block img-responsive mobile" alt="">
               </div>
            </div>
         </div>
      </section>
      <div class="theproofD">
         <div class="container">
            <div class="row">
               <div class="col-sm-6"> &nbsp; </div>
               <div class="col-sm-6">
                  <img src="<?= $path['images'] ?>/image.png?5511004" alt="product"
                     class="product Step1_Product-viral device-desktop-page-index-flow-skin-v3-step-1-img-3">
                  <img src="<?= $path['images'] ?>/theproof.png" width="529" height="104"
                     class="img-responsive center-block" alt="ketopia ketosis" style="margin-top:107px;">
                  <h1>Join the Thousands who are already Seeing Results.</h1>
                  <img src="<?= $path['images'] ?>/theresults.jpg" width="551" height="439"
                     class="img-responsive center-block" alt="Testimonials"> <br>
                  <p class="text-center">Join the thousands already enjoying the incredible age defying effects of
                     Aeterna Skincare Age Defying Cream!
                  </p>
               </div>
               <div class="col-sm-12"> <img src="<?= $path['images'] ?>/the-proof-call-to-action.png"
                     class="toForm img-responsive center-block show-desk" style="cursor:pointer;"
                     onclick="goTopByScroll('form-top');" alt="order ketopia">

                  <img src="<?= $path['images'] ?>/the-proof-call-to-action-mob.png"
                     class="toForm img-responsive center-block show-mob " style="cursor:pointer;"
                     onclick="goTopByScroll('form-top');" alt="order ketopia">
               </div>
            </div>
         </div>
         <!--mobile-->
         <div class="theproofM">
            <div class="container"> </div>
         </div>
      </div>
      <div class="container">
         <a name="science" id="science"></a>
         <div class="row">
            <div class=" col-lg-12 text-center">
               <h1 class="mont60"> HOW DOES IT WORK?</h1>
               <span class="os28 lighter dark"> Aeterna Skincare Age Defying Cream helps you achieve Visibly Younger
                  Skin <span class="blue">faster than any other product</span> with a Powerfully Aeterna Skincare Age
                  Defying Cream Formula </span>
               <div class="space">&nbsp;</div>
            </div>
            <div class="col-sm-6">
               <img src="<?= $path['images'] ?>/results.jpg" class="img-responsive show-desk"
                  alt="ketosis diet body burns carbs instead of fat">
               <img src="<?= $path['images'] ?>/results-mob.jpg" class="img-responsive show-mob"
                  alt="ketosis diet body burns carbs instead of fat">

               <br><br>
               <h2>WHY YOUR SKIN CARE PRODUCTS FAIL?</h2>
               <p class="content">Seventy five percent of our skin is comprised of water and collagen. Our skin is
                  exposed
                  to harsh UVA and UVB radiation resulting in age spots, fine lines, and wrinkles. As we age, our bodies
                  produce less and less collagen, leading to the formation of wrinkles and fine lines.
               </p>
               <h4 class="super"><br>
                  The Problem
               </h4>
               <br>
               <p class="content">Most anti-aging products use fragments of hydrolyzed collagen containing molecules too
                  large for the skin with conventional formulas resulting in less than desireable results.
               </p>
            </div>
            <div class="col-sm-6">
               <br><br>
               <img src="<?= $path['images'] ?>/skinbeforeafter.jpg" width="410" height="259" class=" img-responsive "
                  alt=""><br>
               <h2 class="mb-d12">WHY <span class="orange" style='text-transform: uppercase;'>Aeterna Skincare Age
                     Defying
                     Cream
                  </span> WORKS?
               </h2>
               <p class="content">
                  Aeterna Skincare Age Defying Cream’s breakthrough formula delivers whole collagen molecules to the
                  skin. The
                  peptide-rich wrinkle serum is applied to the skin, rebuilding and rejuvenating the skin.
               </p>
               <br>
               <h4 class="super mt-d29"><br>
                  The Solution:
               </h4>
               <br>
               <p class="content">
                  Aeterna Skincare Age Defying Cream is your secret to radiant, beautiful skin that looks years
                  younger. Don’t
                  endure the physical pain and expense of costly procedures and surgeries.
                  Aeterna Skincare Age Defying Cream works naturally to help replenish your skin’s moisture, firming
                  its
                  appearance and restoring your natural glow to reveal a younger-looking you.
               </p>
            </div>
            <br><br>
         </div>
      </div>
      <div class="container">
         <div class="row">
            <div class="col-lg-12 centered">
               <br><br>
               <h1 class="os33 lighter dark">Visible Results in 1 Week has been difficult to achieve...</h1>
               <span class="os33 orange super montbold">UNTIL NOW</span>
            </div>
         </div>
         <div href="" srcset="" data-secondsdelay="" class="video-box video-box-1">
            <div data-text="text" href="" srcset="" data-secondsdelay="" class="box-headline">See How It Works
            </div>
            <video width="100%" poster="<?= $path['images'] ?>/vid2-thumb.png" controls="" playsinline=""
               allow="fullscreen" allowfullscreen="" muted="" controlsList="nodownload">
               <source src="<?= $path['images'] ?>/vid2.mp4" type="video/mp4" playsinline="">

            </video>
         </div>
      </div>
      <div class="ketpoia-ketosis-banner">
         <div class="container">
            <!-- <h2>Stunning visual results are waiting for you.</h2> -->
            <div class="flx-wrap-prod">
               <img src="<?= $path['images'] ?>/image.png" alt="product"
                  class="Step1_Product-ketpoia  device-desktop-page-index-flow-skin-v3-step-1-img-4 flow-imgs">
               <img src="<?= $path['images'] ?>/logo-w-line2.png" alt="logo" class="Logo-Ketpoia mx-w">
               <!--<img src="<?= $path['images'] ?>/feature-brand-fleu.png" class="center-block img-responsive ket-prod"  alt="Ketopia Logo ">-->
            </div>
            <h2 style="text-align: center;">Stunning visual results are waiting for you.</h2>
         </div>
      </div>
      <a name="whatyouget" id="whatyouget"></a>
      <div class="container">
         <div class="row">
            <div class=" col-lg-12 text-center">
               <img src="<?= $path['images'] ?>/3-seals_n.jpg" width="299" height="115" class="center-block"
                  alt="non gmo">
               <h1 class="mont60 ">WHAT DO YOU GET?</h1>
               <span class="os28 lighter dark"> The Age Defying Cream that is <span class="orange">Sweeping the
                     Nation</span>! </span>
               <div class="space">&nbsp;</div>
            </div>
            <div class="col-sm-8 col-sm-offset-2">
               <img src="<?= $path['images'] ?>/whatdoyouget.jpg" class="img-responsive center-block"
                  alt="ketopia ketosis ketonx drink">
               <div class="prod_img">

                  <img src="<?= $path['images'] ?>/image.png" alt="product"
                     class="Step1_Product-col-sm-offset-2-01 device-desktop-page-index-flow-skin-v3-step-1-img-5">
                  <img src="<?= $path['images'] ?>/image.png" alt="product"
                     class="Step1_Product-col-sm-offset-2-02 device-desktop-page-index-flow-skin-v3-step-1-img-6">
                  <img src="<?= $path['images'] ?>/image.png" alt="product"
                     class="Step1_Product-col-sm-offset-2-03 device-desktop-page-index-flow-skin-v3-step-1-img-7">
               </div>
               <h1 class="productTitle"> Aeterna Skincare Age Defying Cream</h1>
               <h3 class="productSub">Turn back the harsh effects of time! Visible results within as little as 7 days!
               </h3>
               <p class="content">
                  Aeterna Skincare Age Defying Cream is your secret to radiant, beautiful skin that looks years
                  younger. Don’t
                  endure the physical pain and expense of costly procedures and surgeries. Aeterna Skincare Age Defying
                  Cream
                  works naturally to help replenish your skin’s moisture, firming its appearance and restoring your
                  natural
                  glow to reveal a younger-looking you.
               </p>
               <p class="content">The boost in collagen and elastin helps retain the skin's dermal structure which
                  results
                  in reduction of wrinkles and fine lines. Active ingredients in
                  Aeterna Skincare Age Defying Cream facilitate trapping moisture, which in turn hydrates the skin and
                  prevents
                  cracking. <br>
                  <br> Finally the beautiful, healthy, and confident face you deserve with our unique Collagen + Retinol
                  Age Defying serum. Ideal for all skin types,
                  Aeterna Skincare Age Defying Cream is a dynamic and powerful anti-aging product that will give you
                  noticeable
                  results within 7 days!<br>
                  <br>
               </p>
               <ul class="firm_fines">
                  <li>Firm &amp; Tighten Skin *</li>
                  <li>Reduce Wrinkles &amp; Fine Lines *</li>
                  <li>Reduce Signs of Aging *</li>
                  <li>Brighten Skin's Appearance *</li>
                  <li>Eliminates the Look of Dark Circles *</li>
                  <li>Enhances Skin Hydration *</li>
                  <li>Counter the Effects of Stress *</li>
               </ul>
               <p></p>
            </div>
            <div class="space">&nbsp;</div>
            <div class="col-sm-6 col-sm-offset-3">
               <div class="space">&nbsp;</div>
               <div class="space">&nbsp;</div>
               <center>
                  <a class='toForm' style="cursor: pointer" onclick="goTopByScroll('form-top');">
                     <btn class="c2abtn">Rush My Sample!</btn>
                  </a>
               </center>
               <div class="space">&nbsp;</div>
            </div>
         </div>
      </div>
      <div class="stayingKetosis">
         <div class="container">
            <div class="row">
               <h3>ACHIEVING BEAUTIFUL</h3>
               <h2>YOUNGER SKIN</h2>
               <h3>IS SIMPLE</h3>
            </div>
         </div>
      </div>
      <a name="howto"></a>
      <div class="container">
         <div class="row">
            <div class="col-sm-8 ketopiainfo">
               <h2>HOW TO USE Aeterna Skincare Age Defying Cream?</h2>
               <p><strong> Aeterna Skincare Age Defying Cream is a one-of-a-kind product designed to help you see
                     visible
                     results
                     within just 7 days!</strong>
               </p>
               <p>
                  Aeterna Skincare Age Defying Cream is a twice daily age defying serum that allows the face to begin
                  reducing
                  the appearance of age such as wrinkles, fine lines, spots and signs of stress in just a short time.
                  Featuring a special blend of ingredients,
                  Aeterna Skincare Age Defying Cream is a safe and simple way to turn back the hands of time.
               </p>
               <p>
                  Aeterna Skincare Age Defying Cream is extremely easy to use and experience fast noticeable results
                  with.
               </p>
               <ol class="firm_fines">
                  <li>Wash face in the morning and before bed with gentle cleanser</li>
                  <li>Apply 1-2 pumps. once a day on face and neck in gentle cirular motion
                  </li>
                  <li>Apply moisturizer and sunblock as needed<br><br>
                  </li>
               </ol>
               <h3>TIPS FOR SUCCESS</h3>
               <p>Before you begin, you are encouraged to take a "before" photo and an inventory of your current aging
                  signs.
               </p>
               <p>Be sure to get enough deep sleep and drink lots of water. Eat foods high in vitamin A. Be sun safe and
                  keep your face out of the sun. Lower your stress levels and load up on antioxidants. Also don't forget
                  your neck and chest. These are commonly missed areas when using an anti-aging Regimen.<br>
                  <br>
               </p>
               <h3>GET READY FOR A NEW YOU!</h3>
               <p>We know you will fall in love with the results of
                  Aeterna Skincare Age Defying Cream. We want you to be 100% satisfied with your purchase so we offer
                  a 100%
                  Money Back Satisfaction Guarantee.
               </p>
               <p>We rarely have product returns unlike most competitors due to the fact that people see noticeable
                  results
                  in just a short period of time and generally come back to buy more. We hope you enjoy the most
                  exciting
                  new Skin regimen available today!
               </p>
               <p>&nbsp;</p>
               <p>&nbsp;</p>
            </div>
            <div class="col-sm-4">
               <img src="<?= $path['images'] ?>/image.png" alt="product"
                  class="Step1_Product-col-sm-4 device-desktop-page-index-flow-skin-v3-step-1-img-8">
               <img src="<?= $path['images'] ?>/skn-bottle1.png?v=1" width="382" height="353"
                  class="img-responsive center-block skn_btls" alt="ketonx drink">
               <p class="small text-center adjsttxt">
                  Aeterna Skincare Age Defying Cream is a daily regimen that helps you reduce wrinkles and the signs
                  of aging.
               </p>
            </div>
            <div class="col-sm-12">
               <span class="space">&nbsp;</span><br><br>
               <center>
                  <a class='toForm' style="cursor: pointer" onclick="goTopByScroll('form-top');">
                     <btn class="c2abtn">GET IT NOW</btn>
                  </a>
               </center>
            </div>
         </div>
      </div>
      <div class="allnatural">
         <div class="container">
            <div class="row">
               <img src="<?= $path['images'] ?>/allnatural-new.png" class="center-block img-responsive" width="796"
                  height="395" alt="allnatural">
            </div>
         </div>
      </div>
      <a name="theproof" id="theproof"></a>
      <div class="container">
         <div class="row">
            <div class=" col-lg-12 text-center">
               <h1 class="mont50 centered">WHAT OTHERS ARE SAYING:</h1>
               <span class="os28 lighter dark">Aeterna Skincare Age Defying Cream is all over the Internet and the
                  results <span class="orange">are Astonishing</span>! </span><br>
               <div>
                  <center>
                     <img src="<?= $path['images'] ?>/fb-logo.jpg" width="263" height="120" alt="">
                  </center>
               </div>
               <div class="space">&nbsp;</div>
            </div>
            <div class="col-md-6 col-md-offset-3">
               <center>
                  <img src="<?= $path['images'] ?>/skin-serum-rv.png" class="img-responsive" width="481" height="1025"
                     alt="">
               </center>
            </div>
            <div class="col-lg-12">
               <div class="space">&nbsp;</div>
            </div>
         </div>
      </div>
      <div class="footerC2a">
         <div class="container">
            <div class="row">
               <div class="col-md-4 col-sm-2"> &nbsp; </div>

               <div class="col-md-8 col-sm-10">
                  <img src="<?= $path['images'] ?>/logo-exfol-transblack.png" alt="logo" class="footer-logo ftr-logo">
                  <a class='toForm' onclick="goTopByScroll('form-top');" style="cursor: pointer"><img
                        src="<?= $path['images'] ?>/footer-cta.png?v=1722589431" width="680"
                        class="img-responsive center-block" height="771" alt=""></a>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
               <img src="<?= $path['images'] ?>/footer-lg-trd.png" width="960" height="87"
                  class="center-block img-responsive footerNavBlk" alt=""><br>
               <div class="col-lg-12 content centered" style="font-size:12px;">
                  <div id="disclaimers">
                     <div style='position: absolute; overflow: hidden; width: 1px; height: 1px;'>
                     </div>
                     <footer>
                        <div id="footer_trial_disclaimer">
                           <div>We are committed to maintaining the highest quality products and the utmost integrity in
                              business practices. All products sold on this website are certified by Good Manufacturing
                              Practices (GMP), which is the highest standard of testing in the supplement industry.
                           </div>
                           <br>
                           <div>*Due to limited inventory levels on any given day, we must limit trial sales to 250
                              maximum
                              per day.
                              Representations regarding the efficacy and safety of Aeterna Skincare Age Defying Cream
                              have not
                              been evaluated by the Food and Drug Administration.
                           </div>
                        </div>
                        <div class="footer">
                           <p class="copyright">
                              Copyright &copy; 2026 Aeterna Skin &mdash; All Rights Reserved.
                           </p>
                           <p class="footerlinks">
                              <a href="javascript:void(0);" class="bottomhref"
                                 onClick="javascript:openNewWindow('page-terms.php','modal');">Terms &amp;
                                 Conditions</a> |
                              <a href="javascript:void(0);" class="bottomhref"
                                 onClick="javascript:openNewWindow('page-privacy.php','modal');">Privacy Policy</a> |
                              <a href="javascript:void(0);" class="bottomhref"
                                 onClick="javascript:openNewWindow('page-contact.php','modal');">Contact Us</a>
                           </p>
                        </div>
                     </footer>
                     <div class="modal softModal">
                        <div class="modal-inner soft-modal-inner">
                           <a data-modal-close>&times;</a>
                           <div class="modal-content soft-modal-content"></div>
                        </div>
                     </div>
                     <div id="vmodal" style="display:none"></div>
                     <div id="vmodal-submitting" style="display:none">
                        <div class='vmodal-custom-content'>
                           <div style='text-align: center;'>
                              <div style='margin: 20px 0;'><span class='submitting-text'>Submitting Your
                                    Information</span><span class='dots'></span>
                              </div>
                              <div><img src="<?= $path['images'] ?>/secure.png" width='400'></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>



   <div class="pop_overlay" id="popoverNew">
      <div id="pop_content">
         <div class="poplft">
            <div id="pop2">
               <img class="usps" src="<?= $path['images']; ?>/popupexit.png" alt="" />
               <div class="want_try">Want to try Aeterna Skin?</div>
               <div class="just_pay">JUST PAY S&H!</div>
               <a href="#">
                  <div class="accept_pop ">YES I WANT TO TRY</div>
               </a>
               <!-- <a href="#">
                        <div class="accept_pop_no"></div>
                    </a> -->
               <a href="javascript:void(0);" class="no-thank">
                  No Thank You</a>
            </div>
         </div>
      </div>
   </div>
   <!-- footer -->

   <?php require_once 'general/__scripts__.tpl' ?>
   <?php perform_body_tag_close_actions(); ?>

   <!-- <script type="text/javascript" src="<?= $path['js']; ?>/bookmarkscroll.js"></script> -->
   <script type="text/ecmascript" src="<?= $path['assets_js'] ?>/jquery.magnific-popup.js"></script>

   <script type="text/javascript" src="<?= $path['assets_js'] ?>/places.js"></script>
   <!-- <script type="text/javascript" async defer src="<?= $path['js']; ?>/socialproof.js"></script> -->

   <script type="text/javascript" async defer
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_PLACES_API_ID; ?>&libraries=places&callback=initAutocomplete"></script>



   <?php
    $sampleurl = 'sample/';
    $a1=$_SERVER['QUERY_STRING'];
    $b1= $_GET['C1'];
    if ($_SERVER['QUERY_STRING'] != '' && isset($_GET['C1'])){
      $sampleurl = 'sample/?AFFID=1000&oid=425&C1=' . $_GET['C1'];

    }
    ?>

   <script type="text/javascript">
      $(document).ready(function () {
         $(".accept_pop").click(function () {
            $("#popoverNew").hide();
            window.location.href = 'dtc.php';
         });
         $(".no-thank").click(function () {
            cb.ignoreExitPop = true;
            $("#popoverNew").hide();
         });
         $(".cancel-butt").click(function () {
            cb.ignoreExitPop = true;
            $("#popoverNew").hide();
         });

         getTid();
      });
      var isZoom = false;
      nsZoomZoom();

      $(window).resize(function () {
         nsZoomZoom();

      });


      function nsZoomZoom() {
         htmlWidth = $('html').innerWidth();
         bodyWidth = 992;

         if (htmlWidth < bodyWidth) {
            scale = 1;
            isZoom = false;
            $("#zoomed").css('position', 'relative');
                        $('#header').addClass('headerbg')
            $('#headup').removeClass('headerbg')

            $('#headup').hide();
            $("#zoomed").css('-ms-transform', 'scale(' + scale + ')');
            $("#zoomed").css('transform', 'scale(' + scale + ')');
            $("#zoomed").css('transform-origin', 'top center');
              $("#zoomed").css('left', '0px');
       
         }

         else {
            scale = 0.9;
            $("#zoomed").css('position', 'absolute');
            isZoom = true;
            $('#headup').addClass('headerbg')
            $('#header').removeClass('headerbg')
            $('#headup').show()
            const divElement = document.getElementById("zoomed");
            $("#zoomed").css('-ms-transform', 'scale(' + scale + ')');
            $("#zoomed").css('transform', 'scale(' + scale + ')');
            $("#zoomed").css('transform-origin', 'top center');
            // Get the width including padding and border (e.g., 130)
            const offsetWidth = divElement.offsetWidth;
            console.log("offsetWidth:", offsetWidth);
            var margins = window.innerWidth - offsetWidth;
            console.log('margins:', margins)
            var leftMargin = margins / 2;
            console.log('left margin:', leftMargin)
            $("#zoomed").css('left', leftMargin + 'px');
         }

      }

      var tidSession = '';
      var tidInterval;
      function getTid() {


         tidInterval = setInterval(function () {
            var tid = sessionStorage.getItem('tid');
            if (tid != null && tid.length > 5) {
               var formData = new FormData();
               formData.append("tid", tid);
               $.ajax({
                  url: 'ajaxtid.php',
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function (res) {
                     res = JSON.parse(res);
                  },
               });
               clearInterval(tidInterval);
            }
         }, 1000)
      }

  
      function fixScroll() {
         var topPosition = $('.footer').offset().top + $('.footer').outerHeight();
           const maxViewportHeight = window.visualViewport.height + window.visualViewport.offsetTop;
         var hiddenPx = screen.height - maxViewportHeight;
         console.log('Position relative to document:', topPosition, 'px');
         const limit = (topPosition * .9) + hiddenPx; // Height in pixels where you want scrolling to stop
         if (isZoom) {
            if (window.scrollY >= limit) {
               window.scrollTo(0, limit);
            }
         }
      }
      window.addEventListener('scroll', fixScroll, { passive: true });



   </script>
</body>

</html>