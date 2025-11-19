<!DOCTYPE html>

<html ng-app="stepOne" class="no-js ng-scope">

<head ng-controller="ListCtrl" class="ng-scope">


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





    <style type="text/css">
        @charset "UTF-8";

        [ng\:cloak],
        [ng-cloak],
        [data-ng-cloak],
        [x-ng-cloak],
        .ng-cloak,
        .x-ng-cloak,
        .ng-hide {
            display: none !important;
        }

        ng\:form {
            display: block;
        }

        .ng-animate-block-transitions {
            transition: 0s all !important;
            -webkit-transition: 0s all !important;
        }

        .ng-hide-add-active,
        .ng-hide-remove {
            display: block !important;
        }
    </style>

    <meta charset="UTF-8">

    <title ng-repeat="header in heading" class="ng-binding ng-scope">Pinnacle Science Testo Boost Thank You</title>



    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">


    <script>
        function getDate(days) {

            var dayNames = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

            var monthNames = new Array("January", "February", "March", "April", "May", "June", "July", "August",
                "September", "October", "November", "December");



            var now = new Date();



            now.setDate(now.getDate() + days);

            if (dayNames[now.getDay()] == 'Sunday') {
                getDate(days + 1);
                return;
            }



            var nowString = monthNames[now.getMonth()] + " " + now.getDate() + ", " + now.getFullYear();

            document.write(nowString);

        }
    </script>

    <link href="app/mobile/css/thankyou-layout.css" type="text/css" rel="stylesheet">
</head>



<body>





    <div class="cp-wrapper" id="wrapper">



        <div class="after" id="banner">



            <img alt="" src="app/mobile/images/banner.jpg">



        </div>





        <div id="approved">



            <div class="gray" id="approved-content">





                <h1 class="bl" style="margin:15px 0 0 0;">THANK YOU FOR YOUR PURCHASE</h1>

                <p>We hope you enjoy the benefits of Pinnacle Science Testo Boost.</p>



            </div>






        </div>



        <div id="info-content">



            <div class="gray" id="prod-info">



                <h2 class="bl blue-two">ORDER RECEIPT</h2>



                <div id="order">

                    <p class="bl"><span class="bl">Order placed:</span>
                        <script type="text/javascript">
                            getDate(0);
                        </script>
                    </p>

                    <p class="bl">Items ordered: 1</p>

                </div>



                <div ng-controller="ListCtrl" class="ng-scope">



                    <div ng-repeat="prodInfo in heading" id="prod-facts" class="ng-scope">

                        <div ng-repeat="info in prodInfo.productContent" class="ng-scope">

                            <p><span class="bl">Order Number:</span> </p>

                            <div class="after" id="price-details">

                                <div class="">

                                    <p class="bl uppercase ng-binding">Pinnacle Science Testo Boost</p>

                                    <p>Premium Testosterone Booster</p>
                                    <p>Free Trial of Forbidden Fruit Ebook</p>

                                    <p class="ng-binding">30 Day Supply - 60 Capsules</p>

                                </div>



                                <div class="after box-small">

                                    <div class="bl after">

                                        <p class="green fr">$0.00</p>

                                        <p class="fl green">Price:</p>

                                    </div>

                                    <div class="after">

                                        <p class=" fr">$4.99</p>

                                        <p class="fl gray">Shipping &amp; Handling:</p>

                                    </div>

                                    <div class="after">

                                        <p class=" fr">$1.99</p>

                                        <p class="fl gray">Protect Ship:</p>

                                    </div>

                                    <div class="cl" id="total">

                                        <p class="fr">$6.98</p>

                                        <p class="fl gray">TOTAL:</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                </div>




















            </div>



        </div>



        <div class="cl" id="btm">

            <footer ng-include="'ngIncludes/footer.html'" class="f11 ng-scope">

                <p class="ng-scope">

                    <a class="terms-link" href="javascript:void(0);"
                        onClick="javascript:openNewWindow('../terms.php', 'modal');">TERMS |</a>

                    <a class="privacy-link" href="javascript:void(0);"
                        onClick="javascript:openNewWindow('../privacy.php', 'modal');">PRIVACY POLICY |</a>

                    <a class="contact-link" href="javascript:void(0);"
                        onClick="javascript:openNewWindow('../contact.php', 'modal');">CONTACT US </a>

                </p>

                <p class="tc pt10 pb20 ng-scope">Customer Service: <a href="tel:888-506-2480">888-506-2480</a></p>

                <p>&copy; Copyright 2022. Pinnacle Science Products <br>- All Rights Reserved</p>

            </footer>

        </div>

    </div>





    <div id="cboxOverlay" style="display: none;"></div>
    <div id="colorbox" class="" role="dialog" tabindex="-1" style="display: none;">
        <div id="cboxWrapper">
            <div>
                <div id="cboxTopLeft" style="float: left;"></div>
                <div id="cboxTopCenter" style="float: left;"></div>
                <div id="cboxTopRight" style="float: left;"></div>
            </div>
            <div style="clear: left;">
                <div id="cboxMiddleLeft" style="float: left;"></div>
                <div id="cboxContent" style="float: left;">
                    <div id="cboxTitle" style="float: left;"></div>
                    <div id="cboxCurrent" style="float: left;"></div><button type="button"
                        id="cboxPrevious"></button><button type="button" id="cboxNext"></button><button
                        id="cboxSlideshow"></button>
                    <div id="cboxLoadingOverlay" style="float: left;"></div>
                    <div id="cboxLoadingGraphic" style="float: left;"></div>
                </div>
                <div id="cboxMiddleRight" style="float: left;"></div>
            </div>
            <div style="clear: left;">
                <div id="cboxBottomLeft" style="float: left;"></div>
                <div id="cboxBottomCenter" style="float: left;"></div>
                <div id="cboxBottomRight" style="float: left;"></div>
            </div>
        </div>
        <div style="position: absolute; width: 9999px; visibility: hidden; display: none; max-width: none;"></div>
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
            "current_step": 5,
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
            "pageType": "thankyouPage",
            "enable_browser_back_button": false,
            "disable_trialoffer_cardexp": false
        }
    </script>
    <script type="text/javascript">
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
    </script>
    <script>
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
    <!--   <script>
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
    </script> -->
    <script>
        $("#questionnaire").submit(function(e) {
            e.preventDefault();
            var form = $(this);

            if ($('#answer').val() == '') {
                alert('Please select one option from following dropdown');
            } else {
                //$('#loading-indicator').show();
                $.ajax({
                    type: "POST",
                    url: '../questionnaire.php',
                    data: $('[name=questionnaire]').serialize(),
                    dataType: "json",
                    success: function(resp) {
                        $('#loading-indicator').hide();
                        if (resp.type == 'success') {
                            $('.form_div').hide();
                            $('.success_msg').html(resp.msg);
                            $('.success_msg').show();
                        } else if (resp.type == 'error') {
                            $('.error_msg').html(resp.msg);
                            $('.error_msg').show();
                        }
                    }
                });
            }
        });
    </script>


</body>



</html>