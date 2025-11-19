<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'general/__header__.tpl'; ?>

  <link rel="stylesheet" type="text/css" href="<?= $path['assets_css']; ?>/cards_sp.css" />
  <meta charset="UTF-8" />
  <title>Keto Fire Gummies</title>

  <link href="<?= $path['css'] ?>/app.css?v=2" rel="stylesheet" />
  <link href="<?= $path['css'] ?>/checkout.css?v=1" type="text/css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&family=Oswald:wght@400;500;600;700&family=Roboto+Condensed:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="<?= $path['assets_css']; ?>/toastr.min.css" />
  <link rel="stylesheet" href="<?= $path['assets_css']; ?>/magnific-popup.css" />
  <link href="<?= $path['css'] ?>/popupExit.css" type="text/css" rel="stylesheet" />
  <style>
    .form__in form {
      padding: 10px 15px 0;
    }

    .chkbox {
      width: auto !important;
      height: auto !important;
      appearance: checkbox !important;
      outline: auto !important;
      /* display: inline !important; */
      text-align: center !important;
    }

    label.payment_as_shipping_label {
      text-align: center;
      display: inline;
      font-size: 16px !important;
    }

    .span-orange {
      color: black;
      float: right;
      padding-left: 5px;
      font-weight: bold;
    }
  </style>

  <style>
    #toggle-mob-cart {
      width: 100%;
      /* border: 2px solid hsl(0, 0%, 87%); */
      /* padding: 40px 14px; */
      margin-bottom: 10px;
    }

    #toggle-mob-cart.isopened {
      height: auto;
      visibility: visible;
    }

    .prod-box {
      float: left;
      width: 100%;
      /* min-height: 60px; */
      display: table;
      vertical-align: middle;
      margin: 10px 0 32px 0;
    }

    .ord-lft {
      width: 75%;
      position: relative;
      /* padding-left: 72px; */
      display: table-cell;
      vertical-align: top;
      /* padding-top: 10px; */
      /* height: 100px; */
    }

    .ord-lft p {
      float: left;
      width: 100%;
      text-align: left;
    }

    .prod-img {
      position: absolute;
      width: 120px;
      height: 80px;
      line-height: 80px;
      left: 0;
      top: 0;
      text-align: left;
    }

    .prod-img img {
      display: inline-block;
      vertical-align: middle;
      /* max-height: 100%; */
      width: 120px;
    }

    .prod-count {
      left: 30px;
      height: 24px;
      width: 24px;
      line-height: 24px;
      top: 7px;
      position: absolute;
      background-color: #db3832;
      border-radius: 50%;
      color: #fff;
      font-size: 16px;
      font-family: Arial, Helvetica, sans-serif;
      text-align: center;
    }

    .ord-right {
      display: table-cell;
      vertical-align: bottom;
    }

    .ord-right p {
      float: right;
      color: #000;
      font-size: 20px;
      text-align: right;
      font-family: "Mark Pro";
      font-weight: bold;
    }

    .div-ord-title {
      position: absolute;
      left: 0px;
      top: 0px;
    }

    .ord-title {
      color: #878787;
      font-size: 15px;
      line-height: 21px;
      font-family: "Mark Pro";
    }

    .ord-title span {
      font-size: 20px;
      color: #000;
      font-family: "greycliff_cfbold";
    }

    .strikeout {
      position: relative;
      font-weight: normal;
      font-size: 18px;
    }

    .strikeout::after {
      border-bottom: 0.1em solid #f00;
      content: "";
      left: 0;
      margin-top: calc(0.125em / 2 * -1);
      position: absolute;
      right: 0;
      top: 54%;
      transform: rotate(-10deg);
      -webkit-transform: rotate(-10deg);
    }

    .devider-cp {
      float: left;
      width: 100%;
      margin: 4px 0;
      height: 1px;
    }

    .quotes {
      width: 100%;
      height: 35px;
      border: 1px solid #dfdfdf;
      border-radius: 5px;
      overflow: hidden;
      margin: 16px 0;
    }

    .quotes .cupn-flds {
      background: #f6f6f6;
      padding: 5px 20px 5px 12px;
      border: none;
      float: left;
      font-family: "Mark Pro";
      color: #000;
      font-size: 15px;
      line-height: 26px;
      width: 80%;
      height: 100%;
      outline: none;
    }

    .quotes .cupn-flds::placeholder {
      color: #000;
    }

    .quotes .submit-btn {
      background: #a7a7a7;
      font-size: 15px;
      line-height: 26px;
      border: none;
      outline: none;
      font-family: "Mark Pro";
      font-weight: bold;
      color: #fff;
      float: right;
      width: 20%;
      height: 100%;
      cursor: pointer;
    }

    .cart-table {
      color: #000;
      width: 100%;
      font-size: 15px;
      line-height: 24px;
      font-family: "Open Sans", sans-serif;
    }

    .cart-table span {
      color: #000;
    }

    /* .product2 img.chk-plus {
        left: 139px;
      } */
    #expedited_chk {
      margin: 0 auto;
      width: 225px;
      font-size: 15px;
      margin-bottom: 25px;
      font-weight: 700;
    }

    @media only screen and (max-width: 999px) {
      #toggle-mob-cart.isopened {
        height: 0;
        visibility: hidden;
        overflow: hidden;
        -ms-transition: all 0.4s ease-in-out;
        -webkit-transition: all 0.4s ease-in-out;
        transition: all 0.4s ease-in-out;
        padding: 0;
        border: none;
      }

      #toggle-mob-cart {
        border: none;
        padding: 7px 0 0;
      }

      .prod-box {
        min-height: 50px;
        padding-bottom: 0px;
        margin-bottom: 5px;
      }

      .ord-right p {
        line-height: 26px;
      }

      .devider-cp {
        margin: 4px 0;
      }

      .cart-table {
        color: #000;
        width: 100%;
        font-size: 15px;
        line-height: 24px;
        font-family: "Mark Pro";
      }

      .cart-table span {
        color: #000;
      }

      .quotes {
        margin: 9px 0;
      }

      .order__left,
      .order__right {
        width: 100%;
        padding: 0;
      }

      .line-block,
      .secure-icons {
        display: none;
      }
    }

    @media only screen and (max-width: 767px) {
      .prod-box {
        margin: 10px 0 20px;
      }
    }

    @media only screen and (max-width: 599px) {
      .package-info__price {
        font-size: 25px;
        margin-left: 0;
      }

      .package-info__title {
        font-size: 13px;
      }

      .product2 img.chk-plus {
        left: 118px;
      }

      .chk-plus {
        left: 118px;
      }

      #expedited_chk {
        font-size: 13px;
        width: 225px;
      }
    }
  </style>
  <script type="text/javascript">
    function getDate(days) {
      var monthNames = new Array(
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
      );
      var now = new Date();
      now.setDate(now.getDate() + days);
      var nowString =
        monthNames[now.getMonth()] +
        " " +
        now.getDate() +
        ", " +
        now.getFullYear();
      document.write(nowString);
    }
  </script>
  <style>
    .frmCheckElemts {
      margin-top: 15px;
      text-align: center;
    }

    .frmCheckElemts label {
      font-size: 11px !important;
      font-weight: normal;
    }

    form {
      padding: 0;
    }

    .order {
      margin-top: 25px;
    }

    select {
      background-size: 9px;
    }
  </style>
  <script id="adtrk" type="text/javascript" src="https://advibe.io/direct_link.min.js" data-adv-event-id=11
    data-tid="click_id" data-affid="C1" data-sub2="C2" data-sub3="C3" data-sub4="C4" data-sub5="C5" 
data-sub6="C6"> </script>
</head>

<body class="checkout">
  <?php perform_body_tag_open_actions(); ?>
  <p id="loading-indicator" style="display: none">Processing...</p>
  <div class="wrapper">
    <div id="app">
      <header class="order__header">
        <div class="order__header_top">
          <div class="container">
            <span class="views-coll">15 others </span> are viewing this offer
            right now <span class="timer" id="time"></span>
          </div>
        </div>
        <div class="container">
          <div class="row order__header_in">
            <img alt="" src="<?= $path['images'] ?>/logo-2.png" width="165" />
            <div class="delivery-block">
              Internet Exclusive Offers Available to USA Residents Only
            </div>
          </div>
        </div>
      </header>

      <div class="order">
        <div class="container">
          <div class="row">
            <div class="order__left">
              <div class="steps">
                <ul class="steps__list row">
                  <li class="steps__item">1. Shipping Info</li>
                  <li class="steps__item active">2. Finish Order</li>
                  <li class="steps__item">3. Summary</li>
                </ul>
                <div class="approved-text">
                  <strong><span class="emphasis">APPROVED!</span> Free Sample
                    Package Confirmed.</strong>
                  <p>
                    Limited supply available as of
                    <span class="full-date date-container2"></span>.
                  </p>
                </div>
                <p>
                  Product <strong>in stock</strong> and ready to ship within
                  24 hours. Sell Out Risk:
                  <span>HIGH</span>
                </p>
                <!-- <p class="status-pr">Sell Out Risk: <span>HIGH</span></p> -->
              </div>

              <div class="product-selection">
                <!-- <div class="optbx dsplay">
                    <div class="subscribe pack-Opt checked">
                      <span></span>Subscribe & <br class="show-767" />Save
                    </div>
                    <div class="onetime pack-Opt">
                      <span></span>One-Time <br class="show-767" />Purchase
                    </div>
                  </div> -->


                <div class="product product3 active sel-prod" data-cbid="1" data-package-price="0.00"
                  data-prod-count="1">
                  <div class="package-item">
                    <div class="package-item__header">
                      <div class="title-block">
                        <span class="title-block__main">14-GUMMY SAMPLE PACK</span>
                        <span class="title-block__retail">Retail: <br /><span class="retail-price">$89.99</span></span>
                      </div>
                      <div class="shipping-row">
                        <span>PRIORITY SHIPPING</span>
                      </div>
                    </div>

                    <div class="package-item__content">
                      <div class="package-item__status">
                        <span></span>
                      </div>
                      <div class="package-images">
                        <div class="package-images__item">
                          <img alt="" src="<?= $path['images'] ?>/product.png" class="prod-btl1" />
                        </div>

                      </div>
                      <div class="package-info">
                        <span class="package-info__title">Try It Today And<br />
                          Be Blown Away!</span>
                        <span class="package-info__subTitle">&nbsp;</span>
                        <span class="package-info__price">
                          <p style="text-align: center;margin-bottom: 12px;" class="price">
                            FREE<!--119.95-->
                          </p>

                        </span>
                        <span class="package-info__btn">Selected!</span>
                      </div>
                    </div>
                  </div>
                </div>


              </div>

              <div class="guarantee-block">
                <div class="guarantee-top">30 day money back guarantee</div>
                <div class="guarantee-content">
                  <img alt="" class="guarantee-icon" src="<?= $path['images'] ?>/guarantee-ico.jpg" />
                  <div class="guarantee-text">
                    <p>
                      We are so confident in our products and services, that
                      we back it with a 30 day money back guarantee. If for
                      any reason you are not fully satisfied with our
                      products, simply return the purchased products in the
                      original container within 30 days of when you received
                      your order. We will refund you 100% of the purchase
                      price - with absolutely no hassle.
                    </p>
                  </div>
                </div>
              </div>


            </div>

            <div class="order__right">
              <div class="form__header">
                <h2>FINAL STEP:</h2>
                <h3>PAYMENT INFORMATION</h3>
              </div>

              <div class="steps">
                <div id="toggle-mob-cart" class="">
                  <div style="width: 100%; padding: 5px 0">
                    <div class="prod-box">
                      <div class="ord-lft">
                        <!-- <div class="prod-img">
                            <img src="<?= $path['images']; ?>/product.png" />
                          </div>
                          <div class="prod-count">5</div> -->
                        <div class="div-ord-title">
                          <p class="ord-title">
                            <span>Keto Fire Gummies</span><br />
                            14-Gummy Sample Pack<span3 id="span3-subs"></span3>
                          </p>
                        </div>
                      </div>
                      <div class="ord-right">
                        <!-- <p><span class="strikeout retail">$143.00</span></p> -->
                        <p class="package-price">FREE</p>
                      </div>
                    </div>

                    <div class="devider-cp" style="margin-top: 0px"></div>

                    <!-- <div id="expedited_chk" >
                            <label for="expedited_shipping" >
                              <input
                                type="checkbox"
                                name=""
                                id="expedited_shipping"
                                class="chkbox bill-inp"
                                style="margin-left: 5px;"
                              />
                              <span style="float: left;"
                                >Add Rush S&H (Only $9.95)
                              </span>
                            </label>
                          </div>
                          <div class="clear"></div> -->
                    <table class="cart-table" cellpadding="0" cellspacing="0" border="0">

                      <tr>
                        <td align="left"><span>Sub Total:</span></td>
                        <td align="right">
                          <span class="package-price">$0.00</span>
                        </td>
                      </tr>
                    </table>
                    <div class="devider-cp"></div>
                    <table class="cart-table" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td align="left"><span>Tax</span></td>
                        <td align="right">
                          <span id="tax">$0.00</span>
                        </td>
                      </tr>
                    </table>
                    <div class="devider-cp"></div>
                    <table class="cart-table" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td align="left">
                          <span id="shippingtext">Shipping:</span>
                        </td>
                        <td align="right">
                          <span id="shippingprice">$9.95</span>
                        </td>
                      </tr>
                    </table>
                    <div class="devider-cp expedited_div" style="display: none;"></div>
                    <table class="cart-table expedited_div" style="display: none;
                        cellpadding=" 0" cellspacing="0" border="0">
                      <tr>
                        <td align="left">
                          <span>Rush S&H</span>
                        </td>
                        <td align="right">
                          <span>$9.95</span>
                        </td>
                      </tr>
                    </table>
                    <div class="devider-cp"></div>
                    <table class="cart-table bdr" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left"><span>Total:</span></td>
                        <td align="right" class="total-txt">
                          <span class="totalprice" style="font-weight: 700">$9.95</span>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- end toggle-mob-cart -->
              </div>

              <div class="form__in">
                <!-- <form method="post" action="ajax.php?method=new_order_prospect" name="checkout_form" accept-charset="utf-8" enctype="application/x-www-form-urlencoded;charset=utf-8" class="paymentform form" >     -->
                <form method="post" action="ajax.php?method=new_order_prospect" name="checkout_form"
                  accept-charset="utf-8" enctype="application/x-www-form-urlencoded;charset=utf-8" id="frm">
                  <!-- <input
                      type="hidden"
                      name="no_use"
                      id="no_use"
                      value="utf-8"
                    />

                    <input
                      type="hidden"
                      name="campaigns[1][id]"
                      id="campaign1Id"
                      value="3"
                    /> -->
                  <input type="hidden" name="campaigns[1][id]" id="dynamic_input" value="1" />

                  <label for="payment_as_shipping" class="payment_as_shipping_label">
                    <input type="checkbox" name="" id="payment_as_shipping" style="display: none;"
                      class="chkbox bill-inp" />
                    <span>Billing/Shipping Info</span>
                  </label>
                  <span style="display: none">
                    <input type="radio" name="billingSameAsShipping" id="radio_1" value="yes" checked="checked" />
                    <input type="radio" name="billingSameAsShipping" value="no" id="radio_2" />
                  </span>
                  <div class="billing-info" style="display: block">
                    <p>
                      <label style="margin-top: 10px;">First Name</label>
                      <!-- <input type="text" name="billingFirstName" placeholder="Billing First Name" data-error-message="Please enter your billing first name!" maxlength="25"/> -->
                      <input type="text" name="firstName" placeholder="First Name" value=""
                        data-error-message="Please enter your first name!" />
                    </p>

                    <p>
                      <label>Last Name</label>
                      <!-- <input type="text" name="billingLastName" placeholder="Billing Last Name" data-error-message="Please enter your billing last name!" maxlength="25"/> -->
                      <input type="text" name="lastName" placeholder="Last Name" value=""
                        data-error-message="Please enter your last name!" />
                    </p>
                    <p>
                      <label>Address</label>
                      <!-- <input type="text" name="billingAddress1" placeholder="Billing Address" data-error-message="Please enter your billing address!" maxlength="25"/> -->
                      <input type="text" name="shippingAddress1" placeholder="Address" value=""
                        data-error-message="Please enter your address!" id="gmap_autocomplete" />
                    </p>
                    <p>
                      <label>City</label>
                      <!-- <input type="text" name="billingCity" placeholder="Billing City" data-error-message="Please enter your billing city!" maxlength="25"/> -->
                      <input type="text" name="shippingCity" placeholder="City" id="city" value=""
                        data-error-message="Please enter your shipping city!" />
                    </p>
                    <p style="display: none">
                      <label>Country: </label>
                      <select data-selected="US" name="shippingCountry"
                        data-error-message="Please select your country!">
                        <option value="">Select Country</option>
                      </select>
                    </p>
                    <p>
                      <label>State</label>

                      <!-- ? <input type="text" name="billingState" placeholder="Billing State" data-error-message="Please select your billing state!" /> -->
                      <input type="text" name="shippingState" placeholder="State" data-selected=""
                        data-error-message="Please enter your state!" id="shippingState" />
                    </p>
                    <p>
                      <label>Zip Code</label>
                      <!-- <input type="tel" name="billingZip" onkeyup="javascript: this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Billing Zip Code" minlength="5" maxlength="5" data-error-message="Please enter a valid billing zip code!" /> -->
                      <input type="text" name="shippingZip" placeholder="Zip Code" value=""
                        data-error-message="Please enter a valid zip code!" maxlength="7" id="zip" />
                    </p>
                    <p>
                      <label>Phone</label>
                      <!-- <input type="tel" name="billingZip" onkeyup="javascript: this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Billing Zip Code" minlength="5" maxlength="5" data-error-message="Please enter a valid billing zip code!" /> -->
                      <input type="tel" name="phone" placeholder="Phone" value="" data-validate="phone"
                        data-min-length="14" data-max-length="14"
                        data-error-message="Please enter a valid contact number!" maxlength="15" id="phone"
                        class="required" />
                    </p>
                    <p>
                      <label>Email Address</label>
                      <!-- <input type="tel" name="billingZip" onkeyup="javascript: this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Billing Zip Code" minlength="5" maxlength="5" data-error-message="Please enter a valid billing zip code!" /> -->
                      <input type="email" name="email" placeholder="Email Address" value="" class="required"
                        data-validate="email" data-error-message="Please enter a valid email!" />
                    </p>
                  </div>
                  <span class="accept-text">We Accept:</span>
                  <!-- <ul class="form__cards">
                      <li>
                        <img alt="" src="<?= $path['images'] ?>/visa.png" />
                      </li>
                      <li>
                        <img alt="" src="<?= $path['images'] ?>/mastercard.png" />
                      </li>
                      <li>
                        <img
                          alt=""
                          src="<?= $path['images'] ?>/visacard-new.png"
                        />
                      </li>
                                 </ul> -->
                  <div class="cards_sp">
                    <span class="card-visa allCards"></span>

                    <span class="card-mastercard allCards"></span>

                    <span class="card-discover allCards"></span>
                  </div>
                  <p style="display: none" id="cc_type" type="select" name="cc_type">
                    <select name="creditCardType" class="required cctype" data-deselect="false"
                      data-error-message="Please select valid card type!">
                      <option value="">Card Type</option>
                      <option value="master">Master Card</option>
                      <option value="visa">Visa</option>
                      <option value="discover">Discover</option>
                    </select>
                  </p>
                  <div class="margin-bottom-5">
                    <div class="phone-12 columns">
                      <label>Card Number:</label>
                    </div>
                  </div>

                  <div class="phone-12 columns form-holder">
                    <input type="tel" name="creditCardNumber" id="cc_number" data-threeds="pan"
                      class="form-control required masked" placeholder="Card Number" maxlength="16"
                      data-error-message="Please enter a valid credit card number!" pattern="[0-9]*" type="tel"
                      placeholder="•••• •••• •••• ••••" />
                    <div class="accept-icon"></div>
                  </div>

                  <div class="row margin-bottom-5">
                    <div class="phone-12 columns">
                      <label>Card Expiry Date:</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="phone-6 columns form-holder">
                      <select name="expmonth" data-threeds="month" id="fields_expmonth" class="required form-control"
                        data-error-message="Please select a valid expiry month!">
                        <option value="">Month</option>
                        <option value="01">(01) January</option>
                        <option value="02">(02) February</option>
                        <option value="03">(03) March</option>
                        <option value="04">(04) April</option>
                        <option value="05">(05) May</option>
                        <option value="06">(06) June</option>
                        <option value="07">(07) July</option>
                        <option value="08">(08) August</option>
                        <option value="09">(09) September</option>
                        <option value="10">(10) October</option>
                        <option value="11">(11) November</option>
                        <option value="12">(12) December</option>
                      </select>
                    </div>

                    <div class="phone-6 columns form-holder">
                      <select name="expyear" data-threeds="year" id="fields_expyear" class="required form-control"
                        data-error-message="Please select a valid expiry year!">
                        <option value="">Year</option>

                        <option value="25">2025</option>
                        <option value="26">2026</option>
                        <option value="27">2027</option>
                        <option value="28">2028</option>
                        <option value="29">2029</option>
                        <option value="30">2030</option>
                        <option value="31">2031</option>
                        <option value="32">2032</option>
                        <option value="33">2033</option>
                        <option value="34">2034</option>
                        <option value="35">2035</option>
                        <option value="36">2036</option>
                        <option value="37">2037</option>
                        <option value="38">2038</option>
                        <option value="39">2039</option>
                        <option value="40">2040</option>
                        <option value="41">2041</option>
                        <option value="42">2042</option>
                        <option value="43">2043</option>
                        <option value="44">2044</option>
                      </select>
                    </div>
                  </div>

                  <div class="row margin-bottom-5">
                    <div class="phone-12 columns">
                      <label>CVV:</label>
                    </div>
                  </div>

                  <div class="row">
                    <div class="phone-6 columns form-holder">
                      <input type="tel" name="CVV" id="cc_cvv" class="form-control fcheckout-field required"
                        data-validate="cvv" maxlength="4" placeholder="CVV"
                        data-error-message="Please enter a valid CVV code!"
                        onKeyUp="javascript: this.value = this.value.replace(/[^0-9]/g, '');" />
                    </div>
                    <div class="sepa-block" style="display: none">
                      <p>
                        <label>SEPA IBAN: </label>
                        <input type="text" name="sepa_iban" data-error-message="Please enter SEPA IBAN!" />
                      </p>
                      <p>
                        <label>SEPA BIC: </label>
                        <input type="text" name="sepa_bic" data-error-message="Please enter SEPA BIC!" />
                      </p>
                      <p>
                        <label>PHONE PIN: </label>
                        <input type="text" name="pin_number" data-error-message="Please enter valid pin number!" />
                        <span id="pin-msg">Please check your mobile for the pin that was sent
                          to you.</span>
                      </p>
                    </div>
                    <div class="directdebit-block" style="display: none">
                      <p>
                        <label>IBAN: </label>
                        <input type="text" name="iban" data-error-message="Please enter IBAN!" />
                      </p>
                      <p>
                        <label>BIC: </label>
                        <input type="text" name="ddbic" data-error-message="Please enter BIC!" />
                      </p>
                    </div>
                    <div class="phone-6 columns">
                      <span class="cvv-link">
                        <a class="ccvwhatsthis form-link cvvbox" href="javascript:void(0)"
                          style="margin: 9px 0px 0px 2px">
                          CVV?</a>
                      </span>
                    </div>
                  </div>
                  <div class="clear"></div>
                  <div class="cvv-image" style="display: none">
                    <img alt="" src="<?= $path['images'] ?>/cvv.jpg" />
                  </div>
                  <div class="clear"></div>
                  <div class="form__footer" style="position: relative;">

                    <button class="send-btn loading-btn pulse" id="submit_btn" type="submit">
                      <span>RUSH MY SAMPLE</span>
                    </button>
                    <div class="secure-icon">
                      <span>Secure 256-bit SSL Encryption</span>
                    </div>
                    <div class="line-block">
                      <div class="bnr-slider"></div>
                      <div class="line">
                        <div class="text-center">
                          HURRY! CONFIRM YOUR ORDER NOW!
                        </div>
                      </div>
                      <div class="arrow-right"></div>
                    </div>
                    <div class="clear"></div>

                  </div>
                </form>
              </div>

            </div>
            <!-- end order__right -->
          </div>
          <div style="width: 100%;text-align: center;">
            <div class="product-selection">
              <p class="guarantee-text" style="color:gray;">
                When you order a 14-Gummy Sample Pack of Keto Fire Gummies you will have 10 days to decide if the
                product is right for you. If you do nothing after 10 days you will be billed and shipped 1 bottle of
                Keto Fire Gummies at the regular price of $79.97. This will continue on a monthly basis until you
                cancel your subscription.</p>
            </div>
            <div style="text-align: center;margin: 25px 0;">
              <label for="free_trial" class="payment_as_shipping_label">
                <input type="checkbox" name="" id="free_trial" checked class="chkbox bill-inp" />
                <span style="color:gray;"> Get 1 Week Of FitnessXR & USADC</span>
              </label>
            </div>
            <img class="img-responsive secure-icons" src="<?= $path['images'] ?>/or-secureicons.jpg" />
          </div>
        </div>
        <!-- end container -->
      </div>

      <footer class="footer">
        <div class="container">

          <p style="border: 1px solid #979797; padding: 10px">
            Notice: The products and information found on this site are not
            intended to replace professional medical advice or treatment.
            These statements have not been evaluated by the Food and Drug
            Administration. These products are not intended to diagnose,
            treat, cure or prevent any disease. Individual results may vary.
          </p>
          <!-- <p>
              *FREE Bottle(s) Included With Purchase Of Multi-Bottle Packages
            </p> -->
          <p>
            &copy;
            <script>
              var date = new Date();
              document.write(date.getFullYear());
            </script>
            Keto Fire Gummies. All Rights Reserved.
          </p>

          <ul class="terms-links">
            <li>
              <a href="javascript:void(0);" onclick="javascript:openNewWindow('page-privacy.php','modal');">Privacy
                Policy |</a>
            </li>
            <li>
              <a href="javascript:void(0);" onclick="javascript:openNewWindow('page-terms.php','modal');">Terms and
                Conditions |</a>
            </li>
            <li>
              <a href="javascript:void(0);" onclick="javascript:openNewWindow('page-contact.php', 'modal');">Contact
                Us</a>
            </li>
          </ul>
        </div>
      </footer>
    </div>
  </div>

  <section class="custom-social-proof">
    <div class="custom-notification">
      <div class="custom-notification-container">
        <div class="custom-notification-image-wrapper">
          <img src="<?= $path['images'] ?>/product.png" />
        </div>
        <div class="custom-notification-content-wrapper">
          <p class="custom-notification-content">
            <span id="notify-customer">Eli H</span>. -
            <span id="notify-state">TX</span><br />
            Purchased
            <strong><span id="notify-quantity">7</span></strong> Bottle(s) of
            Keto Fire Gummies
            <small><span id="notify-ago">9 minutes ago</span></small>
          </p>
        </div>
      </div>
      <div class="custom-close"></div>
    </div>
  </section>

  <div class="upsell-popup" style="display: none">
    <div class="popup-content">
      <div class="upsell-box">
        <a href="#" onClick="processUpsell();"><img src="<?= $path['images'] ?>/upsell.png" class="upsell-btn" /></a>
        <div style="clear: both"></div>
        <div><img src="<?= $path['images'] ?>/security-icons.png" /></div>
        <a href="#" class="upsell-decline" onClick="processWithoutUpsell();"><img
            src="<?= $path['images'] ?>/thnx-ic.png" /> &nbsp;No, thanks I
          don't want to lose more weight!</a>
      </div>
    </div>
  </div>

  <div class="popup-loading-wrapper" style="display: none">
    <div class="popup">
      <figure class="product-image"></figure>
      <p>Reserving Your Bottle Of</p>
      <h2>Keto Fire Gummies</h2>
      <img src="<?= $path['images'] ?>/icon-loading.png" alt="" class="loading-image" />
    </div>
  </div>

  <div class="loading-screen" style="display: none">
    <div class="loading-pop">
      <div class="pop-content">
        <img src="<?= $path['images'] ?>/loading.gif" class="loading-img" />
        <ul class="pop-list">
          <li class="show-1">
            <img src="<?= $path['images'] ?>/pop-tik.png" /> Checking
            Inventory
          </li>
          <li class="show-2">
            <img src="<?= $path['images'] ?>/pop-tik.png" /> Processing
            Transaction
          </li>
          <li class="show-3">
            <img src="<?= $path['images'] ?>/pop-tik.png" /> Sending to
            Fulfillment
          </li>
          <li class="show-4">
            <img src="<?= $path['images'] ?>/pop-tik.png" /> Order Confirmed
          </li>
        </ul>
        <div id="grp-progress">
          <div id="progress-bar">
            <div id="text_bar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
    include 'general/__scripts__.tpl';
    include 'general/__analytics__.tpl';
    perform_body_tag_close_actions();
?>
  <?php if (defined('GOOGLE_PLACES_API_ID') && !empty(GOOGLE_PLACES_API_ID)) { ?>
  <script type="text/javascript" src="<?= $path['assets_js'] ?>/places.js"></script>
  <script type="text/javascript" async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_PLACES_API_ID; ?>&libraries=places&callback=initAutocomplete"></script>
  <?php } ?>
  <script type="text/ecmascript" src="<?= $path['assets_js'] ?>/jquery.magnific-popup.js"></script>

  <!-- <script
      type="text/javascript"
      src="<?= $path['js'] ?>/social-proof.js"
    ></script> -->
  <script type="text/javascript" src="<?= $path['js'] ?>/scripts.js"></script>
  <script>
    $(function () {
      $('.views-coll').html(generateRandomFloatInRange(12, 19) + ' others ')

      $("#payment_as_shipping").change(function () {
        if ($(this).is(":checked")) {
          $("#radio_1").prop("checked", true).trigger("change");
          centerArrow();
        } else {
          $("#radio_2").prop("checked", true).trigger("change");
          initAutocompleteBilling();
          centerArrow();
        }
      });
    });
    const mediaQuery = window.matchMedia('(min-width: 1000px)')
    function handleMediaChange(e) {
      // Check if the media query is true
      if (e.matches) {

        centerArrow();
      }
    }

    // Register event listener
    mediaQuery.addListener(handleMediaChange)


    handleMediaChange(mediaQuery);
    var selectButtons = $(".package-info__btn");
    function centerArrow() {
      return;
      var offset = $("#submit_btn").offset();
      var arrTop = (offset.top - 967).toFixed(0).toString();
      $(".line-block").css("margin-top", arrTop + "px");
    }
    function generateRandomFloatInRange(min, max) {
      return ((Math.random() * (max - min + 1)) + min).toFixed(0).toString();
    }

    $(document).ready(function () {


      // $(".subscribe").trigger("click");

      function setCart() {
        $(".package-price").html(
          "$" + $(".product.active").attr("data-package-price")
        );
        $(".prod-count, .prod-count1").html(
          $(".product.active").attr("data-prod-count")
        );
        $("#dynamic_input").val($(".product.active").attr("data-cbid"));
        if ($(".product.active").hasClass("product3")) {
          $("#shippingtext").html("Shipping");
          $("#shippingprice").html("$9.95");
          calcTot();

        } else {
          // $(".totalprice").html(
          //   "$" + $(".product.active").attr("data-package-price")
          // );
          $("#shippingtext").html("Shipping");
          $("#shippingprice").html("FREE");
          calcTot();
        }
      }
      function calcTot() {
        var addToTotal = 0;
        if ($("#expedited_shipping").is(":checked")) {
          addToTotal = + 995;
        }
        if ($(".product.active").hasClass("product3")) {
          addToTotal += 595;
        }
        $(".totalprice").html(
          "$" +
          (
            parseFloat($(".product.active").attr("data-package-price")) +
            (addToTotal / 100)
          ).toFixed(2)
        );
      }
      // setCart();

      $(".billingtoggle").change(function () {
        if ($("input[name=billingSameAsShipping]").val() == "yes") {
          $("#billingSameAsShipping").val("no").trigger("change");
          initAutocompleteBilling();
        } else {
          $("#billingSameAsShipping").val("yes").trigger("change");
        }
      });

      $(".contact").magnificPopup({
        type: "iframe",
        mainClass: "contact-page",
      });
      $(".cvv").magnificPopup({
        type: "iframe",
        mainClass: "cvv-page",
      });
      $(".privacy-link").magnificPopup({
        type: "iframe",
        mainClass: "privacy-page",
      });
      // if (shipState != "") {
      //   $("#shippingState").val(shipState);
      // }

      $(".cctype").on("change", function (event) {
        /* Act on the event */
        if ($(this).val() != "") {
          switch ($(this).val()) {
            case "visa":
              $(".allCards").addClass("inactive");
              $(".card-visa").removeClass("inactive");
              break;
            case "master":
              $(".allCards").addClass("inactive");
              $(".card-mastercard").removeClass("inactive");
              break;
            case "discover":
              $(".allCards").addClass("inactive");
              $(".card-discover").removeClass("inactive");
              break;
            default:
              console.log("Credit Card type not found");
          }
        }
      });

      $(".numeric").on("keyup", function () {
        var value = $(this).val();
        var regex_cell = /[^[0-9 ]]*/gi;
        var new_value = value.replace(regex_cell, "");
        $(this).val(new_value);
      });

      $("input[name=creditCardNumber]").blur(function () {
        if (
          $("input[name=creditCardNumber]").val() == "" &&
          $("select[name=creditCardType]").val() != ""
        ) {
          $(".allCards").removeClass("inactive");
        }
      });

      $("#expedited_shipping").click(function () {
        if ($("#expedited_shipping").is(":checked")) {
          $('.expedited_div').show();
          calcTot();
        } else {
          $('.expedited_div').hide();
          calcTot();
        }
        centerArrow();
        calcTot();
      })
      $(document).off("click", "#submit_btn");
      $(document).on("click", "#submit_btn", function (e) {
        // if(!$('#chkAgree').is(':checked')){
        //     toastr.warning('Please check agree before continue.').css("font-size","0.8em");
        //     e.preventDefault();
        //     return;
        // }

        cb.beforeFormSubmitEvents.pop();

        cb.beforeFormSubmitEvents.push(function (e) {
          $("#loading-indicator").show();
          var configData = $("#frm").serialize();
          $.ajax({
            url: AJAX_PATH + "downsell",
            method: "post",
            data: configData,
          })
            .success(function (data) {
              setTimeout(function () {
                $("#loading-indicator").hide();
                if (data.errors) {
                  cb.errorHandler([
                    "This transaction has been declined. Please check your card and try again; if you still have issues please contact customer service at 1-888-506-2483",
                  ]);
                } else {
                  if ($("#expedited_shipping").is(":checked")) {
                    doExpeditedUpsell();
                  } else {
                    doFitness();
                  }
                }
              }, 2000);
            })
            .fail(function () {
              console.log("error");
            });
        });
      });
      centerArrow();
      getTid();
    });

    function doExpeditedUpsell() {
      $("#loading-indicator").show();
      var frmData = encodeURI(
        "campaigns[1][id]=13&campaigns[1][quantity]=1& campaigns[1][step]=2"
      );

      $.ajax({
        url: AJAX_PATH + "upsell",
        method: "post",
        data: frmData,
      })
        .done(function (data) {
          window.onbeforeunload = null;
          window.location.href = "upsell1.php";
        })
        .fail(function () {
          console.log("error");
        });
    }

    function doFitness() {
      if ($("#free_trial").is(":checked")) {
        $.ajax({
          url: 'ajaxfitxr.php',
          type: 'POST',
          processData: false,
          contentType: false,
          success: function (res) {
            console.log('ajaxfitxr done')
            doUsadc();
          },
          fail: function () {
            console.log('ajaxfitxr fail')
            doUsadc();
          }
        });
      }
      else {
        window.onbeforeunload = null;
        window.location.href = "upsell1.php";
      }

    }

    function doUsadc() {

      $.ajax({
        url: 'ajaxusadc.php',
        type: 'POST',
        processData: false,
        contentType: false,
        success: function (res) {
          console.log('ajaxusadc done')
          window.onbeforeunload = null;
          window.location.href = "upsell1.php";
        },
        fail: function () {
          console.log('ajaxusadc fail')
          window.onbeforeunload = null;
          window.location.href = "upsell1.php";
        }
      });

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
  </script>
</body>

</html>