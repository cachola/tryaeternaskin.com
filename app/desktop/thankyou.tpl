<?php
function formatPhone($phone){
    if(preg_match(
        '/^([0-9]{3})([0-9]{3})([0-9]{4})$/', 
    $phone, $value)) {
        $format = $value[1] . '-' . 
            $value[2] . '-' . $value[3];
    }
    return $format;
    }

?>
<!doctype html>
<html>

<head>
    <?php require_once 'general/__header__.tpl';?>
    <meta charset="utf-8">
    <title>Thank You | ketofiregummies</title>
    <?php require_once 'general/__header__.tpl';?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" type="text/css" href="<?= $path['css']; ?>/thankyou.css">
    <link rel="stylesheet" href="<?= $path['assets_css']; ?>/magnific-popup.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script type="text/javascript">
        function getDate(days) {
            var monthNames = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
            var now = new Date();
            now.setDate(now.getDate() + days);
            var nowString = monthNames[now.getMonth()] + " " + now.getDate() + ", " + now.getFullYear();
            document.write(nowString);
        }
    </script>
    <style>
        @media only screen and (max-device-width: 480px),
        only screen and (max-width: 480px) {

            .hide-m {
                display: none;
            }

            .banr-col1 {
                float: left !important;
                display: block !important;
                width: 100% !important;
                padding: 15px 0 !important;
                text-align: center;
            }

            .banr-col2 {
                float: left !important;
                display: block !important;
                width: 100% !important;
            }

            .banner {
                padding: 0 15px !important;
            }

            .banr-col2 img {
                width: 60% !important;
                margin: 0 auto !important;
                display: block !important;
            }

            .shop-txt {
                font-size: 26px !important;
                line-height: 34px !important;
            }

            .shop-txt2 {
                font-size: 14px !important;
                line-height: 24px !important;
            }

            .shop-btn {
                font-size: 20px !important;
                line-height: 30px !important;
            }

            .shop-btn img {
                width: 20px;
            }
        }
    </style>
<?php require_once 'general/__header__.tpl';?>
<?php echo $pixel;?>
</head>

<body>
    <?php include 'general/__gtag_script__.tpl';
        perform_body_tag_open_actions(); ?>
    <p id="loading-indicator" style="display:none;">Processing...</p>

    <div class="logo-sec">
        <div class="container">
            <img src="<?= $path['images']; ?>/logo-exfol-transblack.png" alt="" class="logo">
        </div>
    </div>
    <div <?php echo $hidethk ? 'style="float:left;text-align:center;width:100%;"' : 'style = "display:none;"' ; ?>>
        <div class="detailbox">
                            <div id="mesg"
                                style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 38px; line-height: 34px; font-weight: 600; color: #0a395b; padding: 20px 0;">
                                <br> <br> Your order is being processed.
                            </div>
                            <div
                                style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 20px; line-height: 34px; font-weight: 600; color: #0a395b; padding: 20px 0;">
                                You will receive an email confirming your order shortly.</div>
                            
                            <div
                                style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 18px; line-height: 22px; padding: 10px 0;">
                                Email: <a href="mailto:support@tryaeternaskin.com<"
                                    style="color: #000; text-decoration: none;">support@tryaeternaskin.com</a></div>
                            <div
                                style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 18px; line-height: 22px; padding: 10px 0;">
                                Phone: 888-918-5943</div>
                            <div
                                style="text-align: center; font-family: 'Open Sans', sans-serif; font-size: 18px; line-height: 22px; padding: 10px 0;">
                                Customer Service Hours: 9AM - 5PM EST(Monday-Friday)</div>

        </div>
    </div>

    <div class="thankyou-bg" <?php echo $hidethk ? 'style = "display:none;"' : '' ; ?> >
        <div class="container">
            <div class="thank-section-1">
                <p class="thnk-txt1">Thank You For Your Order</p>
                <p class="thnk-txt2">You will receive an email confirming your order shortly.</p>

                <p class="thank-p1"><span>Order Receipt</span></p>

                <div class="thank-ord">
                    <p class="fl">Order Placed: <b>
                            <script type="text/javascript">getDate(0);</script>
                        </b></p>
                    <p class="fr">Order Number: <b>
                            <?= $order_id;?>
                        </b></p>
                </div>

                <div class="thank-dtl-box">
                    <div class="cart-heading-row">
                        <div class="cart-col-1">Order Summary</div>
                        <div class="cart-col-3">Qty.</div>
                        <div class="cart-col-4"><span class="hide-400">Sub</span> Total</div>
                    </div>

                    <?php 
                                                                foreach ($products as $product) {
                                                                    ?>
                    <div class="cart-prd-row">
                        <div class="cart-col-1">
                            <img src="<?= $path['images']; ?>/<?php echo $product['image']; ?>" alt=""
                                class="cart-prd-1">
                            <div class="cart-prd-name"><span>
                                    <?php echo $product['name']; ?>
                                </span>
                                <?php echo ($product['name1']=='' ? '': '<br>' .   $product['name1'] ); ?>
                            </div>
                        </div>
                        <div class="cart-col-3">
                            <p class="unit-price">1</p>
                        </div>
                        <div class="cart-col-4">
                            <p class="unit-price">
                                <?php echo ($product['subtotal']==0 ? 'FREE': '$ ' .   $product['subtotal'] ); ?>
                            </p>
                        </div>
                    </div>

                    <?php } 
                                                        
                                                                ?>
                    <div class="thnk-rit-price-row">
                        <div class="cart-rit-price">Sub-Total <span class="cart-prc-spn">$
                                <?php echo number_format($total,2); ?>
                            </span></div>
                        <div class="cart-rit-price">Shipping &amp; Handling: <span class="cart-prc-spn"><?php echo ($shipping_amount=='9.95' ? '$ 9.95': '($9.95 X 2) $ 19.90'  ); ?></span>
                        </div>
                        <?php 
                        if($order_details['coupon_discount_amount']!="0.00") { ?>
                        <div class="cart-rit-price">Coupon Discount: <span class="cart-prc-spn">$
                                <?php echo $order_details['coupon_discount_amount']; ?>
                            </span>
                        </div>
                        <?php } ?>
                        <div class="cart-rit-price no-brd">Total <span class="cart-prc-spn">$
                                <?php echo number_format($order_details['order_total'],2); ?>
                            </span></div>
                    </div>


                </div>

                <div class="thnk-Addressinfo">
                    <div class="ty-lft-Address">
                        <div class="sh-heading">Shipping Info</div>
                        <ul class="user-info">
                            <li><span>First Name:</span>
                                <?= ucfirst($order_details['shipping_first_name']);  ?>
                            </li>
                            <li><span>Last Name:</span>
                                <?= ucfirst($order_details['shipping_last_name']);  ?>
                            </li>
                            <li><span>Address:</span>
                                <?= $order_details['shipping_street_address'];  ?>
                            </li>
                            <li><span>City:</span>
                                <?= $order_details['shipping_city'];  ?>
                            </li>
                            <li><span>State:</span>
                                <?= $order_details['shipping_state'];  ?>
                            </li>
                            <li><span>Zip Code:</span>
                                <?= $order_details['shipping_postcode']; ?>
                            </li>

                        </ul>
                    </div>

                    <div class="ty-rgt-Address">
                        <div class="sh-heading">Customer Info</div>
                        <ul class="user-info">
                            <li><span>Email:</span>
                                <?= $order_details['email_address']  ?>
                            </li>
                            <li><span>Phone:</span>
                                <?= formatPhone($order_details['customers_telephone']);  ?>
                            </li>

                        </ul>
                    </div>

                </div>

                <!-- from order confirmation -->
                <div class="thnk-Addressinfo">
                    <table cellpadding="0" cellspacing="0" border="0"
                        style="width:100%; font-family: 'Open Sans', sans-serif;padding-top: 50px;" align="center">
                        <tr>
                            <td style="">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center"
                                    style="color:#fff;background: url(<?= $path['images']; ?>/footer-bg.jpg) repeat-y center top; padding:25px 20px; background-size:100%;">

                                    <tr>
                                        <td align="center" style="font-size:20px; font-weight:600; color:#f4ebb9;">
                                            <img src="<?= $path['images']; ?>/suprt-ic.png"
                                                style="display:inline-block;vertical-align:middle; margin:-5px 10px 0 0;">Customer
                                            Support
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="center" style="padding-bottom:20px;">
                                            <!--[if mso]>
                                                                <table role="presentation" align="center" style="width:660px;">
                                                                <tr>
                                                                <td style="padding:20px 0;">
                                                                <![endif]-->
                                            <div class="outer"
                                                style="width:100%; max-width:700px; margin:0 auto; text-align:left;">

                                                <div class="two-col" style="text-align:left;font-size:0;">
                                                    <!--[if mso]>
                                                                          <table role="presentation" width="100%" dir="rtl">
                                                                          <tr>
                                                                          <td style="width:50%;padding:10px;" valign="middle" dir="ltr">
                                                                          <![endif]-->
                                                    <div class="column"
                                                        style="width:100%;max-width:320px;display:inline-block;vertical-align:middle;direction:ltr; margin:5px 0;">

                                                        <p
                                                            style="font-size:15px; line-height:22px; padding:10px 25px 0 0; letter-spacing:0.5px; text-align:left; margin:0;">
                                                            Our customer service is open <br />9AM - 5PM EST(Monday-Friday) for your
                                                            convenience. We
                                                            strive to provide excellent support and ensure customer
                                                            satisfaction, so
                                                            don’t hesitate to call or email us.
                                                        </p>

                                                    </div>
                                                    <!--[if mso]>
                                                                          </td>
                                                                          
                                                                          <td style="width:50%;padding:10px;" valign="middle" dir="ltr">
                                                                          <![endif]-->
                                                    <div class="column"
                                                        style="width:100%;max-width:340px;display:inline-block;vertical-align:middle;direction:ltr; margin:5px 0 0 0;">
                                                        <table cellpadding="1" cellspacing="0" border="0" width="100%"
                                                            align="left">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="15%" align="left">
                                                                        <img src="<?= $path['images']; ?>/phone-icon.png"
                                                                            style="max-width:100%;">
                                                                    </td>
                                                                    <td width="85%" align="left"
                                                                        style=" padding:10px 0; font-size:14px; color:#fff;">
                                                                        Phone
                                                                        Support<br><a
                                                                            href="skype:+888-918-5943?call"><span
                                                                                style="font-weight:bold; font-size:16px; color:#f4ebb9;">
                                                                                1-888-918-5943</span></a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="15%" align="left">
                                                                        <img src="<?= $path['images']; ?>/email-icon.png"
                                                                            style="max-width:100%;">
                                                                    </td>
                                                                    <td width="85%" align="left"
                                                                        style="padding:10px 0; font-size:14px; color:#fff;">
                                                                        E-mail
                                                                        Support<br><a
                                                                            href="mailto:support@tryaeternaskin.com"><span
                                                                                style="text-decoration:underline; font-size:16px; color:#f4ebb9;">support@tryaeternaskin.com</span></a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!--[if mso]>
                                                                          </td>
                                                                          </tr>
                                                                          </table>
                                                                          <![endif]-->
                                                </div>

                                            </div>
                                            <!--[if mso]>
                                                                </td>
                                                                </tr>
                                                                </table>
                                                                <![endif]-->
                                        <td>
                                    </tr>

                                    <tr>
                                        <td align="center"
                                            style="padding:25px 0 0; color:#fff; font-size:17px; letter-spacing:0.5px; border-top:1px solid #f47577;">
                                            We truly appreciate your business and are here to help!<br>
                                        </td>
                                    </tr>

                                    <tr>
                                        <!-- <td align="left" style="padding:20px 0;"><img
                                                src="<?= $path['images']; ?>/logo-white.png"
                                                style="max-width:100%; width:160px;"></td> -->
                                    </tr>
                                </table>
                            </td>
                        </tr>


                    </table>
                </div>
                <!-- end order confirmation -->
            </div>

        </div>
    </div>


    <!-- FOOTER SECTION -->
    <div class="footer">
        <div class="container">
            <!-- <img src="<?= $path['images']; ?>/logo-2.png" alt="" class="ftr-up-logo"> -->

            <p class="ftr-txt">
                <a  href="javascript:void(0);"
                onclick="javascript:openNewWindow('page-privacy.php','modal');">Privacy Policy</a> | <a href="javascript:void(0);"
                onclick="javascript:openNewWindow('page-terms.php','modal');">Terms & Conditions</a> |
                
                <a  href="javascript:void(0);"
                onclick="javascript:openNewWindow('page-contact.php','modal');">Contact Us</a> 
                
              </p>

            <p class="ftr-txt">Copyright &copy;
                <script type="text/javascript">var year = new Date(); document.write(year.getFullYear());</script> Aeterna Skin. <br class="forMob"> All rights reserved.
            </p>
        </div>
    </div>
    <?php require_once 'general/__scripts__.tpl' ?>
    <?php require_once 'general/__analytics__.tpl' ?>
    <?php perform_body_tag_close_actions(); ?>

    <script type="text/ecmascript" src="<?= $path['assets_js'] ?>/jquery.magnific-popup.js"></script>
    <script>
        $(document).ready(function(){
           
     
        $('.contact').magnificPopup({
            type: 'iframe',
            mainClass: 'contact-page',
        });
        $('.cvv').magnificPopup({
            type: 'iframe',
            mainClass: 'cvv-page',
        });
        $('.privacy-link').magnificPopup({
            type: 'iframe',
            mainClass: 'privacy-page',
        });
           });
    </script>
    <script>
     
    </script>
</body>

</html>