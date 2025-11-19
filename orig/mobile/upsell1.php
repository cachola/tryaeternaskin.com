<!DOCTYPE html>
<html class="no-js" ng-app="stepOne">

<head ng-controller="ListCtrl">

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




   <meta charset="utf-8" />
   <title>Muscle Flow</title>
   <meta name="HandheldFriendly" content="true" />
   <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
   <link
      href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400'
      rel='stylesheet' type='text/css'>
   <link href='https://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>

   <link href="app/mobile/css/style-upsell.css" rel="stylesheet" type="text/css">

</head>

<body ontouchstart>

   <div id="wrapper" class="cp-wrapper" style="width:100%;">
      <div id="banner" class="">
         <img src="app/mobile/images/banner.jpg" alt="" />
      </div>
      <div id="confirm">
         <h2>WAIT! YOUR ORDER IS NOT COMPLETE!</h2>
      </div>
      <div id="thank-you">
         <div id="ty-msg">
            <p>Customers that purchased Pinnacle Science Testo Boost saw added benefits with Muscle Flow!</p>
            <a href="javascript:void(0)" onclick="$('#submit-btn').click();"></a>
         </div>
      </div>
      <div id="purple-area">
         <div id="security-tag" class="after gray">
            <p><img src="app/mobile/images/lock.jpg" id="up-lock-two" alt="" /> Secure 256 Bit Encrypted Connection.</p>
         </div>
         <form name="is-upsell" class="is-upsell" accept-charset="utf-8"
            enctype="application/x-www-form-urlencoded;charset=utf-8" id="upsellfrm">
            <input type="hidden" name="no_use" id="no_use" value="utf-8" />
            <div class="pulse">
               <input type="submit" value="Complete Checkout" id="submit-btn" />
               <img src="app/mobile/images/shopping-cart.png" alt="arrow" class="arrow" />
            </div>
            <p id="loading-indicator" style="display:none;">Processing...</p>
         </form>
         <img src="app/mobile/images/secure.jpg" alt="" id="security" />
      </div>
      <div id="btm">
         <!--<footer class = "f11 after" ng-include="'ngIncludes/footer.html'">-->
         <footer class="f11 after">

            <p>
               <a href="javascript:void(0);" onClick="javascript:openNewWindow('../contact.php','modal');">Contact</a>
               &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);"
                  onClick="javascript:openNewWindow('../privacy.php','modal');">Privacy Policy</a>
               &nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0);"
                  onClick="javascript:openNewWindow('../terms.php','modal');">Terms &amp; Conditions</a>
            </p>

            <p class="tc pt10 pb20">&copy; Copyright 2022. Pinnacle Science Products - All Rights Reserved</p>
            <div id="no-thanks">
               <!--    <img src="app/mobile/images/close2.jpg" alt=""/> -->
               <a href="upsell2.php">&nbsp;&nbsp;&nbsp;No, Thanks. I decline the offer</a>
            </div>
         </footer>
      </div>
   </div>

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
         "device_is_mobile": true,
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
   </script>
   <script>
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
   <script src="app/mobile/js/jquery-1.12.0.min.js" type="text/javascript"></script>
   <!-- <script>
      $(function() {
         $.get("ajax.php/extensions/checktrafficnew/initialize");
      });
   </script> -->
   <script type="text/javascript">
      $('#submit-btn').off('click');
      $('#submit-btn').on('click', function(e) {
         e.preventDefault();
         window.location.href = "upsell2.php";
      });

      // $(function() {

      //    setTimeout(function() {
      //       $.get("ajax.php/extensions/checktrafficnew/place", function(data) {
      //          if (data == null) return;

      //          if (typeof data == 'string') {
      //             data = JSON.parse(data);
      //          }

      //          data.forEach(function(el) {

      //             if (el.type == 'head') {
      //                $('head').append(el.content);
      //             }

      //             if (el.type == 'top') {
      //                $('body').prepend(el.content);
      //             }

      //             if (el.type == 'bottom') {
      //                $('body').append(el.content);
      //             }
      //          });
      //       });
      //    }, 500);

      // });
   </script>
   <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMQ7Icv1jZW3JdHwLWCt-59mgkEQQRaBg">
   </script>
   <script>
      var autocomplete_event_type = 'keyup';
      var autopopulate_by = 'zip';
      var disable_component_restriction = '';
   </script>
   <script src='https://www.pscican.com/v1dx1/extensions/GoogleAutoComplete/js/google-auto-complete.js'></script> -->

</body>

</html>