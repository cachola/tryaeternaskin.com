<!DOCTYPE html>


<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>

   <meta charset="utf-8" />







   <meta name="description" content="" />






   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

   <meta http-equiv="content-type" content="text/html;charset=utf-8" />

   <meta http-equiv="content-language" content="en-us" />



   <meta name="apple-mobile-web-app-capable" content="yes" />

   <meta name="apple-mobile-web-app-status-bar-style" content="black" />

   <meta name="HandheldFriendly" content="true" />







   </script>


   <link rel="stylesheet" href="assets/css/app.css" />


   <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
   <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">




   <meta charset="utf-8">
   <link type='text/css' href="app/desktop/css/kprofile.css" rel='stylesheet' />
   <link type='text/css' href="app/desktop/css/kform.css" rel='stylesheet' />
   <link type='text/css' href="app/desktop/css/kcart.css" rel='stylesheet' />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=1000, user-scalable=0" />
   <title>Muscle Flow</title>
   <link href="app/desktop/css/kstyle.css" rel="stylesheet">
   <link href="app/desktop/css/kcheckout.css" rel="stylesheet">
   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
   <link href='https://fonts.googleapis.com/css?family=Kameron:400,700' rel='stylesheet' type='text/css'>
   <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
   <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   <link href="app/desktop/css/upsell1.css" rel="stylesheet">

   <style>
      body.upsell .white2 {
         height: 720px;
      }
   </style>
   <link rel="stylesheet" href="app/desktop/css/app.css" />
</head>

<body class="upsell">

   <div class="form_part">
      <div class="container" style="margin-top:0!important;">
         <div class="bg01">
            <div class="top1" style="height: 890px;">
               <div id="container">
                  <div class="cart_1"><img src="app/desktop/images/cart_01.png" width="980" height="13"></div>
                  <div class="white2">
                     <div class="contentWrap-in">
                        <div id="upmid">
                           <div class="upbox1">
                              <center><img src="app/desktop/images/step21.jpg"></center>
                           </div>
                           <p class="uptxt1"><span>WAIT! YOUR ORDER IS NOT COMPLETE</span><br>
                              Customers that purchased <b>Pinnacle Science Testo Boost</b> also purchased <b>Muscle Flow
                              </b>
                           </p>
                           <div class="uppricebox" onclick="window.location=href='upsell2.php';">
                              <p class="priceboxtxt1">Limited Offer - 10 Remaining</p>
                              <p class="priceboxtxt2">AMPLIFY YOUR RESULTS</p>
                              <p class="priceboxtxt3">with <b>Muscle Flow </b></p>
                              <p class="priceboxtxt4">for healthy blood flow support</p>
                              <p class="priceboxtxt5">Add a <span>Trial Bottle</span> <br>
                                 Just pay shipping of
                              </p>
                              <p class="priceboxtxt6">$4.95</p>
                           </div>
                           <!-- <form id="kform" method='POST' accept-charset="utf-8" enctype="application/x-www-form-urlencoded;charset=utf-8" onSubmit="return false;"> -->
                           <form name="is-upsell" class="is-upsell" id="kform" accept-charset="utf-8"
                              enctype="application/x-www-form-urlencoded;charset=utf-8" style="text-align:center;">
                              <input type="hidden" name="no_use" id="no_use" value="utf-8" />
                              <img style="margin:-20px auto 0 auto;" class="upimage" alt=""
                                 src="app/desktop/images/uplock.png">
                              <a onclick="window.location=href='upsell2.php';" id="kformSubmit"
                                 href="javascript:void(0);" style="display:inline-block;">
                                 <img class="upimage pulse" alt="" src="app/desktop/images/complete-checkout.png">
                              </a>
                              <img class="upimage" alt="" src="app/desktop/images/upbtmimg.png">
                           </form>

                           <p id="loading-indicator" style="display:none;">Processing...</p>
                           <p id="crm-response-container" style="display:none;">messages will appear here...</p>
                           <p class="btm_para2"></p>
                           <br>
                        </div>
                        <div class="clearall"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="grey_inner">
      <div class="rules">
         <a href="upsell2.php">
            <p class="nothanktxt">
               No, Thanks. I decline the offer
            </p>
         </a>
      </div>
      <div class="clearfix"></div>
   </div>
   <div class="footer">
      <div class="container">
         <ul class="footer_menu">
            <li><a href="javascript:void(0);" onclick="javascript:openNewWindow('privacy.php','modal');">Privacy
                  Policy</a></li>
            <li> <a href="javascript:void(0);" onclick="javascript:openNewWindow('terms.php','modal');">Terms &amp;
                  Conditions</a> </li>
            <li><a href="javascript:void(0);" onclick="javascript:openNewWindow('contact.php','modal');">Contact Us</a>
            </li>
            <li>
               <!-- <span>&copy; Pinnacle Science Products - All Rights Reserved</span>-->
               <span>&copy; Copyright 2022. Pinnacle Science Products - All Rights Reserved</span>
            </li>
         </ul>
      </div>
   </div>

   <p id="loading-indicator" style="display:none;">Processing...</p>
   <!-- <script type="text/javascript">
      AJAX_PATH = "ajax.php/";
      app_config = {
         "valid_class": "no-error",
         "error_class": "has-error",
         "loading_class": "loading",
         "exit_popup_enabled": false,
         "exit_popup_element_id": "",
         "exit_popup_page": "",
         "offer_path": "\/v1dx1\/",
         "current_step": 2,
         "cbtoken": "",
         "dev_mode": "N",
         "show_validation_errors": "modal",
         "allowed_tc": "8\"m2l2d2J252k252O2lv8sm\"l\"d4J255k454O4l480mmlsdeJc5rk\"5\"O0l288m8l8d8J853kv5sO\"l\"80m8l8d8J858k850Ovls8\"m[r4j2V2H2q2h2k2R2X|Niraj,V5H1q7h4k4R4X4N4r|jaVtHrqahdk,R4X1N8r8j8V8H1q8h|kiRaX,N4r1j8V8H8q8h8k8R|XiNar]",
         "allowed_country_codes": ["CA"],
         "countries": {
            "CA": {
               "name": "Canada",
               "states": {
                  "AB": {
                     "name": "Alberta"
                  },
                  "BC": {
                     "name": "British Columbia"
                  },
                  "MB": {
                     "name": "Manitoba"
                  },
                  "NB": {
                     "name": "New Brunswick"
                  },
                  "NL": {
                     "name": "Newfoundland and Labrador"
                  },
                  "NT": {
                     "name": "Northwest Territories"
                  },
                  "NS": {
                     "name": "Nova Scotia"
                  },
                  "NU": {
                     "name": "Nunavut"
                  },
                  "ON": {
                     "name": "Ontario"
                  },
                  "PE": {
                     "name": "Prince Edward Island"
                  },
                  "QC": {
                     "name": "Quebec"
                  },
                  "SK": {
                     "name": "Saskatchewan"
                  },
                  "YT": {
                     "name": "Yukon"
                  }
               }
            }
         },
         "country_lang_mapping": {
            "US": {
               "state": "State:",
               "zip": "Zip Code:"
            },
            "GB": {
               "state": "County:",
               "zip": "Postal Code:"
            },
            "CA": {
               "state": "Province:",
               "zip": "Postal Code:"
            },
            "IN": {
               "state": "State:",
               "zip": "Pin:"
            }
         },
         "device_is_mobile": false,
         "pageType": "upsellPage1",
         "enable_browser_back_button": false,
         "disable_trialoffer_cardexp": false
      }
   </script> -->
   <!-- <script type="text/javascript">
      app_lang = {
         "error_messages": {
            "zip_invalid": "Please enter a valid zip code!",
            "email_invalid": "Please enter a valid email id!",
            "cc_invalid": "Please enter a valid credit card number!",
            "cvv_invalid": "Please enter a valid CVV code!",
            "card_expired": "Card seems to have expired already!",
            "card_expire_soon": "Your credit card is about to expire, please update your card information.",
            "common_error": "Oops! Something went wrong! Can you please retry?",
            "not_checked": "Please check the agreement box in order to proceed.",
            "ca_zip_invalid": "Invalid Canada state code",
            "xv_invalid_shipping": "Your shipping address could not be verified",
            "xv_email": "Your email address could not be verified",
            "xv_phone": "Your phone number could not be verified"
         },
         "exceptions": {
            "config_error": "General config error",
            "config_file_missing": "General config error",
            "invalid_array": "Argument is not a valid array",
            "empty_prospect_id": "Prospect ID is empty or invalid",
            "curl_error": "Something went wrong with the request, Please try again.",
            "generic_error": "Something went wrong with the request, Please try again."
         }
      };
   </script> -->
   <!-- <script>
      var validator_data = {
         "enable_ca_statecode_validation": true,
         "ca_state_code_mask": "S0S 0S0",
         "ca_state_code_regex": "^[A-Za-z]\\d[A-Za-z][ -]?\\d[A-Za-z]\\d$",
         "us_state_code_mask": "",
         "enable_statecode_validation": true,
         "enable_us_statecode_validation": false
      };
   </script>
   <script type="text/javascript">
      var cbUtilConfig = {
         "disable_non_english_char_input": false
      };
   </script> -->
   <!-- <script>
      var input_mask_data = {
         "enable_masking": true,
         "masking_device": ["desktop", "mobile"],
         "credit_card_place_holder_active": false,
         "credit_card_masking_placeholder": "",
         "credit_card_masking": "dash_masking",
         "phone_number_masking": "(000) 000-0000",
         "enable_credit_Card_masking": true,
         "checkURL": "https:\/\/license-check.unify.to\/validate-codebase-license\/",
         "currentUserEmail": "rabina.prasad@codeclouds.in",
         "currentUserIP": "103.240.96.65"
      };
   </script> -->

   <!-- <script src="assets/dist/codebase.min.js" type="text/javascript"></script> -->
   <script src="app/desktop/js/jquery-1.12.0.min.js" type="text/javascript"></script>
   <!-- <script>
      $(function() {
         $.get("ajax.php/extensions/checktrafficnew/initialize");
      });
   </script>
   <script type="text/javascript">
      $(function() {

         setTimeout(function() {
            $.get("ajax.php/extensions/checktrafficnew/place", function(data) {
               if (data == null) return;

               if (typeof data == 'string') {
                  data = JSON.parse(data);
               }

               data.forEach(function(el) {

                  if (el.type == 'head') {
                     $('head').append(el.content);
                  }

                  if (el.type == 'top') {
                     $('body').prepend(el.content);
                  }

                  if (el.type == 'bottom') {
                     $('body').append(el.content);
                  }
               });
            });
         }, 500);

      });
   </script>
   <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMQ7Icv1jZW3JdHwLWCt-59mgkEQQRaBg">
   </script>
   <script>
      var autocomplete_event_type = 'keyup';
      var autopopulate_by = 'zip';
      var disable_component_restriction = '';
   </script>
   <script src='https://www.pscican.com/v1dx1/extensions/GoogleAutoComplete/js/google-auto-complete.js'></script> -->

</body>

</html>