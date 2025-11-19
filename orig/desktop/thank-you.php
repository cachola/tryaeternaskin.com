<!DOCTYPE html>
<html>

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




    <meta name="viewport" content="width=698,user-scalable=0" />
    <title>Pinnacle Science Testo Boost Thank You</title>
    <link rel="stylesheet" type="text/css" href="app/desktop/css/reset.css">
    <link rel="stylesheet" type="text/css" href="app/desktop/css/style.css">
    <link rel="stylesheet" type="text/css" href="app/desktop/css/ty-custom.css">
    <link rel="stylesheet" type="text/css" href="app/desktop/css/thanks.css">


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

            var nowString = dayNames[now.getDay()] + ", " + monthNames[now.getMonth()] + " " + now.getDate() + ", " +
                now.getFullYear();
            document.write(nowString);
        }
    </script>
</head>

<body>


    <div id="outer-wrapper" class="after ty-main">
        <div id="wrapper" class="after">
            <div class="hdr_br">
                <div class="logos"><img style="width: 22%; height: auto;" src="app/desktop/images/logo.png"></div>
                <div class="progress">
                    <img src="app/desktop/images/thank-pro.png">
                    <span class="overText">
                        <ul>
                            <li>1. Shipping Info</li>
                            <li>2. Finish Order</li>
                            <li>3. Summary</li>
                        </ul>
                    </span>
                </div>
            </div>
            <div id="thank-you">
                <div id="ty-msg" class="grey-2">



                    <p class="bl f18">THANK YOU FOR YOUR PURCHASE </p>
                    <p class="f14">We hope you enjoy the benefits of Pinnacle Science Testo Boost</p>



                </div>
                <div id="billing" class="grey-2" ng-controller="ListCtrl">

                    <h1 class="bl red-two">ORDER RECEIPT</h1>
                    <div id="billing-inner">
                        <div id="order-info">

                            <p class="pb5"><span class="bl">Order Placed:</span>
                                <script type="text/javascript">
                                    getDate(0);
                                </script>
                            </p>
                            <p><span class="bl">Order Number:</span> </p>
                        </div>
                        <div class="pro-div">
                            <div><img src="app/desktop/images/ck-prdct.png" class="prod"
                                    style="width:50%;margin-left: -170px;" /></div>
                            <div class="after bb pb10">
                                <div>
                                    <p class="bl pb5 f16" style="text-transform:uppercase">Pinnacle Science Testo Boost
                                    </p>
                                    <p class="pb5">Free Trial of Forbidden Fruit eBook</p>
                                    <p class="fl">30 Day Supply - 60 Capsules</p>
                                    <p class="green bl fr f18">$</p></br>
                                    <p class="fl">Protect ship</p>
                                    <p class="green bl fr f18">$1.99</p></br>
                                </div>
                            </div>
                        </div><br><br>






                        <div class="pt10" id="totals">
                            <div class="after pb10 bb f14">
                                <p class="fl">Shipping & Handling:</p>
                                <p class="bl fr f18">$1.99</p>
                            </div>
                            <div id="total" class="after bl f16">
                                <p class="fl">TOTAL:</p>
                                <p class="fr f18 bl">$1.99</p>
                            </div><br><br>
                        </div>





                    </div>
                </div>
            </div>
        </div>

        <footer class="f11 ng-scope">
            <p class="tc pt10 ng-scope">Customer Support: <a href="tel:888-506-2480">888-506-2480</a></p><br>
            <p class="ng-scope">
                <a href="javascript:void(0);" onclick="javascript:openWindow(event, 'terms.php', 'modal');">TERMS |</a>
                <a href="javascript:void(0);" onclick="javascript:openWindow(event, 'privacy.php', 'modal');">PRIVACY
                    POLICY |</a>
                <a href="javascript:void(0);" onclick="javascript:openWindow(event, 'contact.php', 'modal');">CONTACT
                    US</a>
            </p>
            <!--<p class="tc pt10 pb20 ng-scope">2022               &copy; Pinnacle Science Products</p>-->
            <p class="tc pt10 pb20 ng-scope">&copy; Copyright 2022. Pinnacle Science Products - All Rights Reserved</p>
        </footer>
    </div>







    <!-- <script src="assets/dist/codebase.min.js" type="text/javascript"></script> -->
    <script src="app/desktop/js/jquery-1.12.0.min.js" type="text/javascript"></script>
    <!-- <script>
        $(function() {
            $.get("ajax.php/extensions/checktrafficnew/initialize");
        });
    </script> -->
    <!-- <script type="text/javascript">
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
                    url: 'questionnaire.php',
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