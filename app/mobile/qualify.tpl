<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'general/__header__.tpl' ?>




    <link href="../app/mobile/css/app.css?v=2" rel="stylesheet">
    <link href="../app/mobile/css/inner.css" type="text/css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Oswald:wght@400;500;600;700&family=Roboto+Condensed:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

</head>

<body data-mobile-id="5984" style="max-width: 600px; margin: 0 auto">
    <?php perform_body_tag_open_actions(); ?>
   <p id="loading-indicator" style="display:none;">Processing...</p>
          <div id="app">
        <div id="pagecontainer">
            <div id="top-1">
                <center>
                    <img src="../app/mobile/images/logo2-strips.png" style="width:158px; margin: 6px 0 10px 0;">
                </center>

                <div class="breadcrumbs">
                    <ul class="breadcrumbs__list">
                        <li class="breadcrumbs__item breadcrumbs__item_active">
                            <span>Qualify Now</span>
                        </li>
                        <li class="breadcrumbs__item breadcrumbs__item_2">
                            <span>Select Package</span>
                        </li>
                        <li class="breadcrumbs__item breadcrumbs__item_3">
                            <span>Confirm Order</span>
                        </li>
                    </ul>
                </div>

                <p style="text-align:center;">
                    <br>
                    <b style="color:#f18704; font-size:19px; padding: 0 5px">Claim Your KETO Package Today!</b><br>
                    <br>
                    <strong style="padding: 0 5px">At 10x the Fat Burn,<br>You Won't Believe it's All Natural!</strong>
                    <br>
                </p>
            </div>

            <div class="form-partial" style="max-width:95%; margin:0 auto;">

                <!-- <form name="prospect_form1" method="post" class="kform form123 form" id="qualify1" data-v-e2afc010="" data-uitype="leadform"> -->
                    <form method="post" action="ajax.php?method=new_prospect" class="kform form123 form order-form re" name="prospect_form1"
                    accept-charset="utf-8" enctype="application/x-www-form-urlencoded;charset=utf-8">
                    <div class="lead-form-wrapper">
                        <div class=" columns form-holder">
                            <label>First Name:</label>
                            <input class="form-control required" data-placement="auto left" name="firstName" value="" id='fields_fname' placeholder="First Name*" title="First Name*" type="text" data-error-message="Please enter your first name!" maxlength="25">
                        </div>
                        <div class=" columns form-holder">
                            <label>Last Name:</label>
                            <input class="form-control required" data-placement="auto left" name="lastName" id='fields_lname' placeholder="Last Name*" title="Last Name*" type="text" value="" data-error-message="Please enter your last name!" maxlength="25">
                        </div>
                        <div class=" columns">
                            <label>Phone:</label>
                            <input class="form-control required" data-placement="auto left" name="phone" id="fields_phone" placeholder="Phone Number*" title="Phone Number" type="tel" value="" data-error-message="Please enter a valid contact number!" maxlength="12">
                        </div>
                        <div class=" columns">
                            <label>Email:</label>
                            <input class="form-control required" data-placement="auto left" name="email" id='fields_email' placeholder="Email*" title="Email" type="email" data-error-message="Please enter a valid email id!" value="" maxlength="100" >
                        </div>

                   <span style="font-size: 14px;">How Much Weight Would You Like To Lose?</span>
                        <div class="form-holder">
                            <select name="fields_want" id='fields_want' class="required" data-error-message="Please select weight!" >
                                <option selected="selected" value="">Please Select</option>
                                <option value="1">1-10 lbs</option>
                                <option value="11">11-20 lbs</option>
                                <option value="20">20 plus lbs</option>
                            </select>
                        </div>
                        <br>
                        <input alt="Submit" border="0" class="pulsebutton btn_pulse qualify-btn" name="partialsubmitbutton" src="../app/mobile/images/qualify-btn.jpg" style="width: 100%; outline:none;" type="image" onclick="submitForm()" value="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="linebreak" style="margin:15px 0;">
    </div>

    <div>
        <img alt="" src="../app/mobile/images/godaddyimg.png">
    </div>

    <div class="linebreak" style="margin:15px 0;">
    </div>

    <div>
        <img alt="" src="../app/mobile/images/safe.png">
    </div>

    <div class="linebreak" style="margin:15px 0;">
    </div>

    <div id="footer">
        <br>
        <center>
            <ul class="terms-links">
                <li> <a href="javascript:void(0);" onclick="javascript:openNewWindow('../page-privacy.php', 'modal');">Privacy Policy |</a></li>
                <li> <a href="javascript:void(0);" onclick="javascript:openNewWindow('../page-terms.php', 'modal');">Terms and Conditions &nbsp;|&nbsp;</a></li>
                <li><a href="javascript:void(0);" onclick="javascript:openNewWindow('../page-contact.php', 'modal');">Contact Us</a> </li>
            </ul>
            <br>
            <div class="text-center">
                <p>Keto Fire Gummies is committed to maintaining the highest quality products and the utmost integrity in business practices. All products sold on this website are certified by Good Manufacturing Practices (GMP), which is the highest standard of testing in the supplement industry.</p><br>
                <p>Notice: The products and information found on this site are not intended to replace professional medical advice or treatment. These statements have not been evaluated by the Food and Drug Administration. These products are not intended to diagnose, treat, cure or prevent any disease. Individual results may vary.</p>
            </div>
            <br>
        </center>
        <center>
            <div class="text-center">
                <p class="cop-text">&copy; 
                <script>
                    var date = new Date();
                    document.write(date.getFullYear())

                </script>
                <span class="product-name">Keto Fire Gummies</span>. All Rights Reserved.
                <br>
            </div>
        </center>
    </div>
    
    <?php require_once 'general/__scripts__.tpl' ?>
<!-- <?php require_once 'general/__analytics__.tpl' ?> -->
<?php perform_body_tag_close_actions(); ?>
<script type="text/ecmascript" src="<?= $path['assets_js'] ?>/jquery.magnific-popup.js"></script>
<script type="text/ecmascript" src="<?= $path['js'] ?>/lazysizes.min.js"></script>
<script type="text/ecmascript" src="<?= $path['js'] ?>/ls.unveilhooks.min.js"></script>

<script type="text/javascript" src="<?= $path['assets_js'] ?>/places.js"></script>

<script type="text/javascript" async defer
   src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_PLACES_API_ID; ?>&libraries=places&callback=initAutocomplete"></script>



    <!-- <p id="loading-indicator" style="display:none;">Processing...</p>
    <p id="crm-response-container" style="display:none;">Limelight messages will appear here...</p> -->

    
        <!-- <script type="text/javascript">AJAX_PATH="ajax.php/"; app_config={"valid_class":"no-error","error_class":"has-error","loading_class":"loading","exit_popup_enabled":false,"exit_popup_element_id":"","exit_popup_page":"","offer_path":"\/v1\/","current_step":1,"cbtoken":"","dev_mode":"N","show_validation_errors":"modal","allowed_tc":"8\"m0l0d0J050k050O0lv8sm\"l\"d4J454k454O4l480mvlsd\"J\"50k151O1l181m1l7dvJs5\"k\"50O1l089m0l3d4J45vks5\"O\"l989m9l9d9J959k95vOsl\"8[r0j0V0H0q0h0k0R0X|Niraj,V1H4q4h4k4R4X4N4r|jiVaH,q6h1k1R1X1N1r1j1V|Hiqah,k6R1X0N0r9j1V9H2q|hikaR,X7N9r9j9V9H9q9h9k|RiXaN]","allowed_country_codes":["US"],"countries":{"US":{"name":"United States","states":{"AL":{"name":"Alabama"},"AK":{"name":"Alaska"},"AS":{"name":"American Samoa"},"AZ":{"name":"Arizona"},"AR":{"name":"Arkansas"},"AE":{"name":"Armed Forces Middle East"},"AA":{"name":"Armed Forces Americas"},"AP":{"name":"Armed Forces Pacific"},"CA":{"name":"California"},"CO":{"name":"Colorado"},"CT":{"name":"Connecticut"},"DE":{"name":"Delaware"},"DC":{"name":"District of Columbia"},"FM":{"name":"Federated States of Micronesia"},"FL":{"name":"Florida"},"GA":{"name":"Georgia"},"GU":{"name":"Guam"},"HI":{"name":"Hawaii"},"ID":{"name":"Idaho"},"IL":{"name":"Illinois"},"IN":{"name":"Indiana"},"IA":{"name":"Iowa"},"KS":{"name":"Kansas"},"KY":{"name":"Kentucky"},"LA":{"name":"Louisiana"},"ME":{"name":"Maine"},"MD":{"name":"Maryland"},"MA":{"name":"Massachusetts"},"MI":{"name":"Michigan"},"MN":{"name":"Minnesota"},"MS":{"name":"Mississippi"},"MO":{"name":"Missouri"},"MT":{"name":"Montana"},"NE":{"name":"Nebraska"},"NV":{"name":"Nevada"},"NH":{"name":"New Hampshire"},"NJ":{"name":"New Jersey"},"NM":{"name":"New Mexico"},"NY":{"name":"New York"},"NC":{"name":"North Carolina"},"ND":{"name":"North Dakota"},"MP":{"name":"Northern Mariana Islands"},"OH":{"name":"Ohio"},"OK":{"name":"Oklahoma"},"OR":{"name":"Oregon"},"PA":{"name":"Pennsylvania"},"PR":{"name":"Puerto Rico"},"MH":{"name":"Republic of Marshall Islands"},"RI":{"name":"Rhode Island"},"SC":{"name":"South Carolina"},"SD":{"name":"South Dakota"},"TN":{"name":"Tennessee"},"TX":{"name":"Texas"},"UT":{"name":"Utah"},"VT":{"name":"Vermont"},"VI":{"name":"Virgin Islands of the U.S."},"VA":{"name":"Virginia"},"WA":{"name":"Washington"},"WV":{"name":"West Virginia"},"WI":{"name":"Wisconsin"},"WY":{"name":"Wyoming"}}}},"country_lang_mapping":{"US":{"state":"State:","zip":"Zip Code:"},"GB":{"state":"County:","zip":"Postal Code:"},"CA":{"state":"Province:","zip":"Pin Code:"},"IN":{"state":"State:","zip":"Pin:"}},"device_is_mobile":true,"pageType":"leadPage","enable_browser_back_button":false,"disable_trialoffer_cardexp":false,"enable_csrf_token":false}</script><script type="text/javascript">app_lang={"error_messages":{"zip_invalid":"Please enter a valid zip code!","email_invalid":"Please enter a valid email id!","cc_invalid":"Please enter a valid credit card number!","cvv_invalid":"Please enter a valid CVV code!","card_expired":"Card seems to have expired already!","card_expire_soon":"Your credit card is about to expire, please update your card information.","common_error":"Oops! Something went wrong! Can you please retry?","not_checked":"Please check the agreement box in order to proceed.","ca_zip_invalid":"Invalid Canada state code","xv_invalid_shipping":"Your shipping address could not be verified","xv_email":"Your email address could not be verified","xv_phone":"Your phone number could not be verified"},"exceptions":{"config_error":"General config error","config_file_missing":"General config error","invalid_array":"Argument is not a valid array","empty_prospect_id":"Prospect ID is empty or invalid","curl_error":"Something went wrong with the request, Please try again.","generic_error":"Something went wrong with the request, Please try again."}};</script><script type="text/javascript">var cbUtilConfig = {"disable_non_english_char_input":false};</script>
<script src="assets/js/promise.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.mask.min.js" type="text/javascript"></script>
<script src="assets/js/validator.js" type="text/javascript"></script>
<script src="assets/js/codebase.js" type="text/javascript"></script>
<script src="assets/js/form_handler.js" type="text/javascript"></script>
<script src="assets/js/app.js" type="text/javascript"></script>
<script src="assets/js/outro.js" type="text/javascript"></script>
<script src="extensions/CbUtilityPackage/js/cb-util-pkg.js" type="text/javascript"></script><script>$(function(){$.get("ajax.php/extensions/checktrafficnew/initialize");});</script>         -->

<!-- <script type="text/javascript">
            $(function(){

                setTimeout(function(){
                    $.get("ajax.php/extensions/checktrafficnew/place", function( data ) {
                        if(data == null) return;
                
                        if(typeof data == 'string') {
                            data = JSON.parse(data);
                        }
                
                        data.forEach(function(el) {
                            
                            if(el.type == 'head') {
                                $('head').append(el.content);
                            }
    
                            if(el.type == 'top') {
                                $('body').prepend(el.content);
                            }
    
                            if(el.type == 'bottom') {
                                $('body').append(el.content);
                            }
                        });
                    });
                }, 500);
                
            });
            
        </script> -->
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQnHiycs0_Lw7fvK0WYtNbSNKS0v0pyWs&libraries=places&callback=attachListener"></script>
<script>var event_type= 'keyup';var autopopulate_by= 'zip';var disable_component_restriction= '1';var restricted_countries= 'US';</script>
<script src='https://www.buynewageketoburner.com/v1/extensions/GoogleAutoComplete/js/google-auto-complete.js'></script>
<script src='https://www.buynewageketoburner.com/v1/extensions/GoogleAutoComplete/js/address-auto-complete.js'></script>   -->
  <script type="text/javascript">


$(document).ready(function (e) {
            $('.fancybox').fancybox();
            $(".contact").fancybox({
            'width'         : 500,
            'height'        : 700,
            'autoSize': false,
        });

            $('.numeric').on("keyup", function () {
                var value = $(this).val();
                var regex_cell = /[^[0-9 ]]*/gi;
                var new_value = value.replace(regex_cell, '');
                $(this).val(new_value);
            });

            $("#results").change(function () {
                selectedVal = $('#results :selected').text();
            });

            $('#submit_btn').on('click', function (event) {
                event.preventDefault();
                if (selectedVal == '') {
                    alert('Please select desired result before submit.')
                    return;
                }
                $('.order-form').submit();
            });
        });




    // localStorage.clear();
    // let has_error = false;
    // let emailReg = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

    // // input validation
    // $("#qualify1").on("blur", "input", function(e) {
    //     check_validation($(this));
    // });

    // function check_validation(obj) {
    //     has_error = false;
    //     console.log(obj)
    //     if(obj.val() == '') {
    //         has_error = true;
    //         console.log(obj);
    //     }
    //     else if(obj.attr("id") == "phone" && obj.val().length < 10) {
    //         has_error = true;
    //     }
    //     else if(obj.attr("id") == "email" && (!emailReg.test(obj.val()))) {
    //         has_error = true;
    //     }

    //     if(has_error == true) {
    //         obj.removeClass('no-error');
    //         obj.addClass('has-error');
    //     }
    //     else {
    //         obj.removeClass('has-error');
    //         obj.addClass('no-error');
    //     }
    // }
    
    // // form submit
    // function submitForm() {
    //     // event.preventDefault();
    //     // window.location.href = "package.php";
    //     // return;
    //     var error = new Array();

    //     $("#qualify1 :input").each(function() {
    //         check_validation($(this));

    //         if(!$(this).hasClass("no-error")) {
    //             error.push($(this).attr("data-error-message"));
    //         }
    //     });

    //     if(error.length) {
    //         cb.errorHandler(error);
    //     }
    //     else {
    //         $('#loading-indicator').show();
    //         $("#qualify1 input").each(function() {
    //             localStorage.setItem('qualify_form_'+($(this).attr("name")), $(this).val());
    //         });

    //         window.location.href = "package.php";
    //     }
    // }
    </script>
</body>

</html>
