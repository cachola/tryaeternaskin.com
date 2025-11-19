<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'general/__header__.tpl'; ?>

    <link href="<?= $path['css'] ?>/app.css" rel="stylesheet" />
    <link href="<?= $path['assets_css'] ?>/cards_sp.css" rel="stylesheet" />
    <link
      href="<?= $path['css'] ?>/inner.css?v=7"
      type="text/css"
      rel="stylesheet"
    />
    <link
      href="<?= $path['css'] ?>/btn-animation.css"
      type="text/css"
      rel="stylesheet"
    />
    <style>
      .chkbox {
        width: auto !important;
        height: auto !important;
        appearance: checkbox !important;
        outline: auto !important;
        display: inline !important;
        text-align: center !important;
      }

      .frmCheckElemts {
        margin-top: 15px;
        text-align: center;
      }

      .frmCheckElemts label {
        font-size: 12px !important;
        font-weight: normal;
      }

      form {
        padding: 0;
      }
    </style>

    <style>
      #toggle-mob-cart {
        width: 90%;
        /* border: 2px solid hsl(0, 0%, 87%); */
        /* padding: 40px 14px; */
        /* margin-bottom: 30px;*/
        margin: 0 auto 30px auto;
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
        margin: 10px 0 50px 0;
      }
      .ord-lft {
        width: 75%;
        position: relative;
        /* padding-left: 92px; */
        display: table-cell;
        vertical-align: top;
        padding-top: 10px;
      }
      .ord-lft p {
        float: left;
        width: 100%;
        text-align: left;
      }

      .prod-img {
        position: absolute;
        width: 80px;
        height: 80px;
        line-height: 80px;
        left: 0;
        top: 0;
        text-align: left;
      }
      .prod-img img {
        display: inline-block;
        vertical-align: middle;
        max-height: 100%;
        width: auto;
      }
      .prod-count {
        left: 16px;
        height: 24px;
        width: 24px;
        line-height: 24px;
        top: 0px;
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
      .ord-title {
        color: #878787;
        font-size: 15px;
        line-height: 21px;
        font-family: "Mark Pro";
      }
      .ord-title span {
        font-size: 20px;
        color: red;
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
      .product2 img.chk-plus {
        left: 139px;
      }
      .span-orange {
        color: black;
        float: right;
        padding-left: 5px;
        font-weight: bold;
      }

      #expedited_chk {
        margin: 0 auto;
        width: 270px;
        font-size: 15px;
        margin-bottom: 10px;
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
          margin: 0;
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

      /* garantia */

      .guarantee-block {
        border: 1px solid #6b0d7d;
        border-radius: 10px;
        overflow: hidden;
        text-align: center;
        font-family: Montserrat, Arial, Helvetica, sans-serif;
        margin: 0 auto 17px auto;
        width: 95%;
      }
      .guarantee-top {
        background-color: #6b0d7d;
        color: #fff;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 24px;
        line-height: 26px;
        padding: 3px 5px 4px;
      }
      .guarantee-content {
        overflow: hidden;
        padding: 7px 15px 10px 5px;
      }
      .guarantee-icon {
        /* float: left; */
        width: 30%;
        margin: 10px auto;
      }
      .guarantee-text {
        overflow: hidden;
      }
      .guarantee-text p {
        margin: 0;
        font-size: 15px;
        line-height: 24px;
        font-family: inherit;
        font-weight: 400;
        color: #393f40;
      }

      /* end garantia */
      .disclaimer {
        border: 0.0625rem solid #ccc;
        background-color: #fff;
        padding: 19px 17px;
        margin-top: 0.625rem;
        margin-left: 10px;
        margin-right: 10px;
        font-size: 14px;
        color: gray;
      }
      @media only screen and (max-width: 767px) {
        .prod-box {
          margin: 10px 0 10px;
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
      }
    </style>
  </head>

  <body data-mobile-id="5984" style="max-width: 600px; margin: 0 auto">
    <?php perform_body_tag_open_actions(); ?>
    <p id="loading-indicator" style="display: none">Processing...</p>
    <div id="app">
      <div class="checkout-page" id="pagecontainer">
        <div id="top-1">
          <center>
            <img
              src="<?= $path['images'] ?>/logo2-strips.png"
              style="width: 158px; margin: 6px 0 10px 0"
            />
          </center>
          <div class="breadcrumbs">
            <ul class="breadcrumbs__list">
              <li class="breadcrumbs__item">
                <span>Qualify Now</span>
              </li>
              <li class="breadcrumbs__item breadcrumbs__item_2">
                <span>Select Package</span>
              </li>
              <li
                class="breadcrumbs__item breadcrumbs__item_3 breadcrumbs__item_active"
              >
                <span>Confirm Order</span>
              </li>
            </ul>
          </div>

          <p style="text-align: center">
            <br />
            <b style="color: #000; font-size: 18px"
              >Final Step - Payment Information</b
            ><br />
            <span style="color: #444; font-size: 11px">
              <em>Your order will be processed on our secure servers</em>
            </span>
            <br />
          </p>
          <div class="steps">
            <div id="toggle-mob-cart" class="">
              <div style="width: 100%;">
                <div class="prod-box">
                  <div class="ord-lft">
                    <!-- <div class="prod-img">
                      <img src="<?= $path['images']; ?>/product.png" />
                    </div>
                    <div class="prod-count">1</div> -->
                    <p class="ord-title">
                      <span>Keto Fire Gummies</span><br />
                      <span1 class="prod-count1"></span1>14-Gummy Sample
                      Pack<span3 id="span3-subs" style="display: none"
                        ><br />Sample</span3
                      >
                    </p>
                  </div>
                  <div class="ord-right">
                    <!-- <p><span class="strikeout retail">$143.00</span></p> -->
                    <p class="package-price">FREE</p>
                  </div>
                </div>

                <div class="clear"></div>
                <!-- <div class="devider-cp"></div>
                <div id="expedited_chk" style="    margin-top: 10px;margin-bottom: 5px;" >
                  <label for="free_trial" >
                    <input
                      type="checkbox"
                      name=""
                      id="free_trial"
                      class="chkbox bill-inp"
                      style="margin-left: 5px;"
                      checked
                    />
                    <span style="float: left"
                      >Get 1 Week Of FitnessXR & USADC
                    </span>
                  </label>
                </div>
                <div class="clear"></div> -->
                <!-- <div class="devider-cp"></div>
                <div id="expedited_chk">
                  <label for="expedited_shipping">
                    <input
                      type="checkbox"
                      name=""
                      id="expedited_shipping"
                      class="chkbox bill-inp"
                      style="margin-left: 7px;"
                    />
                    <span style="float: left;color:red;">Add Rush S&H (Only $9.95) </span>
                  </label>
                </div>
                <div class="clear"></div> -->
                <table
                  class="cart-table"
                  cellpadding="0"
                  cellspacing="0"
                  border="0"
                >
                  <tr>
                    <td align="left"><span>Sub Total:</span></td>
                    <td align="right">
                      <span class="package-price" style="font-weight: bold"
                        >$0.00</span
                      >
                    </td>
                  </tr>
                </table>
                <div class="devider-cp"></div>
                <table
                  class="cart-table"
                  cellpadding="0"
                  cellspacing="0"
                  border="0"
                >
                  <tr>
                    <td align="left"><span>Tax</span></td>
                    <td align="right">
                      <span id="tax" style="font-weight: bold">$0.00</span>
                    </td>
                  </tr>
                </table>
                <div class="devider-cp"></div>
                <table
                  class="cart-table"
                  cellpadding="0"
                  cellspacing="0"
                  border="0"
                >
                  <tr>
                    <td align="left">
                      <span id="shippingtext">Shipping:</span>
                    </td>
                    <td align="right">
                      <span id="shippingprice" style="font-weight: bold"
                        >$9.95</span
                      >
                    </td>
                  </tr>
                </table>
                <div
                  class="devider-cp expedited_div"
                  style="display: none"
                ></div>
                <table
                  class="cart-table expedited_div"
                  style="display: none"
                  cellpadding="0"
                  cellspacing="0"
                  border="0"
                >
                  <tr>
                    <td align="left">
                      <span>Rush S&H</span>
                    </td>
                    <td align="right">
                      <span style="font-weight: bold">$9.95</span>
                    </td>
                  </tr>
                </table>
                <div class="devider-cp"></div>
                <table class="cart-table bdr" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left"><span>Total:</span></td>
                    <td align="right" class="total-txt">
                      <span class="totalprice" style="font-weight: bold"
                        >$9.95</span
                      >
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- end toggle-mob-cart -->
          </div>

          <div
            id="shortcheckoutcontainer"
            style="max-width: 95%; margin: 0 auto"
          >
            <form
              method="post"
              action="ajax.php?method=new_order_prospect"
              name="checkout_form"
              accept-charset="utf-8"
              enctype="application/x-www-form-urlencoded;charset=utf-8"
              id="frm"
            >
              <input
                type="hidden"
                name="campaigns[1][id]"
                id="dynamic_input"
                value="1"
              />

              <label
                for="payment_as_shipping"
                class="payment_as_shipping_label"
              >
                <input
                  type="checkbox"
                  name="payment_as_shipping"
                  id="payment_as_shipping"
                  checked
                  class="bill-inp"
                />
                <span>Billing same as Shipping</span>
              </label>
              <p style="display: none">
                <input
                  type="radio"
                  name="billingSameAsShipping"
                  id="radio_1"
                  value="yes"
                  checked=""
                />
                YES
                <input
                  type="radio"
                  name="billingSameAsShipping"
                  id="radio_2"
                  value="no"
                />
                NO
              </p>
              <div
                class="billing-info"
                style="display: none; margin-bottom: 15px"
              >
                <div class="billing-form">
                  <div class="billing-title">Billing Information</div>

                  <div class="form-holder">
                    <span>First Name: </span>
                    <input
                      class="form-control"
                      data-placement="auto left"
                      name="billingFirstName"
                      id="billingFirstName"
                      placeholder="First Name*"
                      title="First Name"
                      type="text"
                      data-error-message="Please enter your billing first name!"
                      maxlength="25"
                    />
                  </div>

                  <div class="form-holder" placeholder="Last Name*">
                    <span>Last Name: </span>
                    <input
                      class="form-control"
                      data-placement="auto left"
                      name="billingLastName"
                      id="billingLastName"
                      placeholder="Last Name*"
                      title="Last Name"
                      type="text"
                      data-error-message="Please enter your billing last name!"
                      maxlength="25"
                    />
                  </div>

                  <div class="form-holder">
                    <label>Address:</label>
                    <input
                      class="form-control"
                      data-placement="auto left"
                      name="billingAddress1"
                      id="billingAddress1"
                      placeholder="Address*"
                      title="Address"
                      type="text"
                      value=""
                      data-error-message="Please enter your billing address!"
                      maxlength="25"
                    />
                  </div>

                  <div class="form-holder">
                    <label>Zip Code:</label>
                    <input
                      class="form-control"
                      data-placement="auto left"
                      name="billingZip"
                      id="billingZip"
                      placeholder="Zip Code*"
                      title="Zip Code"
                      type="tel"
                      value=""
                      onKeyUp="javascript: this.value = this.value.replace(/[^0-9]/g, '');"
                      data-error-message="Please enter a valid billing zip code!"
                      minlength="5"
                      maxlength="5"
                    />
                  </div>

                  <div class="form-holder">
                    <label>City:</label>
                    <input
                      class="form-control"
                      data-placement="auto left"
                      name="billingCity"
                      id="billingCity"
                      placeholder="City*"
                      title="City"
                      type="text"
                      data-error-message="Please enter your billing city!"
                      maxlength="25"
                    />
                  </div>

                  <p style="display: none">
                    <label>Billing Country: </label>
                    <select
                      style="line-height: normal"
                      name="billingCountry"
                      data-error-message="Please select your billing country!"
                      data-selected="US"
                    >
                      <option value="">Select Country</option>
                    </select>
                  </p>

                  <div class="form-holder">
                    <label>State:</label>
                    <input
                      type="text"
                      name="billingState"
                      id="billingState"
                      placeholder="Billing State"
                      class="form-control"
                      data-error-message="Please select your billing state!"
                    />
                  </div>
                  <div class="billing-title">Payment Information</div>
                </div>
              </div>
              <span class="accept-text">We Accept:</span>
              <div class="cards_sp">
                <span class="card-visa allCards"></span>

                <span class="card-mastercard allCards"></span>

                <span class="card-discover allCards"></span>
              </div>
              <select
                name="creditCardType"
                class="required cctype"
                data-deselect="false"
                data-error-message="Please select valid card type!"
                style="display: none"
              >
                <option value="">Card Type</option>
                <option value="master">Master Card</option>
                <option value="visa">Visa</option>
                <option value="discover">Discover</option>
              </select>
              <div class="checkout-form-wrapper">
                <div class="form-holder">
                  <label>Card Number:</label>
                  <input
                    pattern="[0-9]*"
                    type="tel"
                    name="creditCardNumber"
                    id="cc_number"
                    data-threeds="pan"
                    class="form-control required masked"
                    maxlength="16"
                    placeholder="•••• •••• •••• ••••"
                    data-error-message="Please enter a valid credit card number!"
                  />
                </div>

                <div class="form-fields">
                  <label>Card Expiry Date:</label>
                  <div class="form-holder" id="expire_m">
                    <select
                      name="expmonth"
                      data-threeds="month"
                      id="fields_expmonth"
                      class="required form-control"
                      data-error-message="Please select a valid expiry month!"
                    >
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
                  <div class="form-holder" id="expire_y">
                    <select
                      name="expyear"
                      data-threeds="year"
                      id="fields_expyear"
                      class="required form-control"
                      data-error-message="Please select a valid expiry year!"
                    >
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
                <div class="form-holder" id="cvv">
                  <label>CVV:</label>
                  <input
                    pattern="[0-9]*"
                    type="tel"
                    name="CVV"
                    id="cc_cvv"
                    class="form-control fcheckout-field required"
                    data-validate="cvv"
                    maxlength="4"
                    placeholder="CVV"
                    data-error-message="Please enter a valid CVV code!"
                    oninput="javascript: this.value = this.value.replace(/[^0-9]/g, '');"
                  />
                </div>
                <div class="sepa-block" style="display: none">
                  <p>
                    <label>SEPA IBAN: </label>
                    <input
                      type="text"
                      name="sepa_iban"
                      data-error-message="Please enter SEPA IBAN!"
                    />
                  </p>
                  <p>
                    <label>SEPA BIC: </label>
                    <input
                      type="text"
                      name="sepa_bic"
                      data-error-message="Please enter SEPA BIC!"
                    />
                  </p>
                  <p>
                    <label>PHONE PIN: </label>
                    <input
                      type="text"
                      name="pin_number"
                      data-error-message="Please enter valid pin number!"
                    />
                    <span id="pin-msg"
                      >Please check your mobile for the pin that was sent to
                      you.</span
                    >
                  </p>
                </div>
                <div class="directdebit-block" style="display: none">
                  <p>
                    <label>IBAN: </label>
                    <input
                      type="text"
                      name="iban"
                      data-error-message="Please enter IBAN!"
                    />
                  </p>
                  <p>
                    <label>BIC: </label>
                    <input
                      type="text"
                      name="ddbic"
                      data-error-message="Please enter BIC!"
                    />
                  </p>
                </div>
                <div class="cvv-link left">
                  <a
                    href="javascript:void(0)"
                    style="margin: 30px 0px 0px 17px; display: inline-block"
                    >CVV?</a
                  >
                </div>
                <div class="clear"></div>
                <div class="cvv-image" style="display: none">
                  <img
                    alt=""
                    src="<?= $path['images'] ?>/cvv.jpg"
                    style="margin: 0px 0px 15px !important; width: 100%"
                  />
                </div>
                <div id="rushtop">
                  <input
                    alt="Submit"
                    border="0"
                    class="pulsebutton cformbtn-default btn_pulse btn-click"
                    id="submit_btn"
                    name=""
                    src="<?= $path['images'] ?>/RushButton.jpg"
                    style="width: 100%; outline: none"
                    type="image"
                    value="submit"
                  />
                </div>

                <div class="clear"></div>
              </div>
            </form>
          </div>

          <div class="linebreak" style="margin: 2px 0"></div>
          <div class="guarantee-block">
            <div class="guarantee-top">30 day money back guarantee</div>
            <div class="guarantee-content">
              <img
                alt=""
                class="guarantee-icon"
                src="<?= $path['images'] ?>/guarantee-ico.jpg"
              />
              <div class="guarantee-text">
                <p>
                  We are so confident in our products and services, that we back
                  it with a 30 day money back guarantee. If for any reason you
                  are not fully satisfied with our products, simply return the
                  purchased products in the original container within 30 days of
                  when you received your order. We will refund you 100% of the
                  purchase price - with absolutely no hassle.
                </p>
              </div>
            </div>
          </div>
          <div class="disclaimer">
            When you order a 14-Gummy Sample Pack of Keto Fire Gummies you will have 10 days to decide if the product is right for you. If you do nothing after 10 days you will be billed and shipped 1 bottle of Keto Fire Gummies at the regular price of $79.97. This will continue on a monthly basis until you cancel your subscription.
          </div>
          <div id="expedited_chk" style="    margin-top: 2px;margin-bottom: 5px;" >
            <label for="free_trial" >
              <input
                type="checkbox"
                name=""
                id="free_trial"
                class="chkbox bill-inp"
                style="margin-left: 5px;"
                checked
              />
              <span style="float: left"
                >Get 1 Week Of FitnessXR & USADC
              </span>
            </label>
          </div>
          <div class="clear"></div>


          <div class="linebreak" style="margin: 15px 0"></div>
          <div id="content-3">
            <div style="color: #7b0600; font-size: 11px; text-align: center">
              We care about your privacy.
            </div>
          </div>
          <!-- <div id="top-2">
            <img src="<?= $path['images'] ?>/godaddyimg.png" />
          </div>
          <div class="linebreak" style="margin: 15px 0"></div> -->

          <div id="top-3">
            <img src="<?= $path['images'] ?>/safe.png" />
          </div>
          <div id="footer">
            <br />
            <center>
              <ul class="terms-links">
                <li>
                  <a
                    href="javascript:void(0);"
                    onClick="openNewWindow('../page-privacy.php','modal');"
                    >Privacy Policy |</a
                  >
                </li>
                <li>
                  <a
                    href="javascript:void(0);"
                    onClick="openNewWindow('../page-terms.php','modal');"
                    >Terms and Conditions |</a
                  >
                </li>
                <li>
                  <a
                    href="javascript:void(0);"
                    onclick="javascript:openNewWindow('../page-contact.php', 'modal');"
                    >Contact Us</a
                  >
                </li>
              </ul>
              <br />
              <div class="text-center">
                <p>
                  Keto Fire Gummies is committed to maintaining the highest
                  quality products and the utmost integrity in business
                  practices. All products sold on this website are certified by
                  Good Manufacturing Practices (GMP), which is the highest
                  standard of testing in the supplement industry.
                </p>
                <br />
                <p>
                  Notice: The products and information found on this site are
                  not intended to replace professional medical advice or
                  treatment. These statements have not been evaluated by the
                  Food and Drug Administration. These products are not intended
                  to diagnose, treat, cure or prevent any disease. Individual
                  results may vary.
                </p>
              </div>
              <br />
            </center>

            <center>
              <div class="text-center">
                <p class="cop-text">
                  &copy;
                  <script>
                    var date = new Date();
                    document.write(date.getFullYear());
                  </script>
                  <span class="product-name">Keto Fire Gummies</span>. All
                  Rights Reserved.
                </p>
                <br />
              </div>
            </center>
            <p></p>
          </div>
        </div>
      </div>
    </div>

    <div class="upsell-popup" style="display: none">
      <div class="popup-content">
        <div class="upsell-box">
          <a href="#" onClick="processUpsell();"
            ><img src="<?= $path['images'] ?>/upsell.png" class="upsell-btn"
          /></a>
          <div style="clear: both"></div>
          <div><img src="<?= $path['images'] ?>/security-icons.png" /></div>
          <a href="#" class="upsell-decline" onClick="processWithoutUpsell();"
            ><img src="<?= $path['images'] ?>/thnx-ic.png" /> &nbsp;No, thanks I
            don't want to lose more weight!</a
          >
        </div>
      </div>
    </div>

    <p id="loading-indicator" style="display: none">Processing...</p>
    <p id="crm-response-container" style="display: none">
      Limelight messages will appear here...
    </p>

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
    <script
      type="text/javascript"
      src="<?= $path['assets_js'] ?>/places.js"
    ></script>
    <script
      type="text/javascript"
      async
      defer
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_PLACES_API_ID; ?>&libraries=places&callback=initAutocomplete"
    ></script>
    <?php } ?>
    <script
      type="text/ecmascript"
      src="<?= $path['assets_js'] ?>/jquery.magnific-popup.js"
    ></script>

    <script>
      var packPrice;
      $(document).ready(function () {
        // setCart();

        //         function setCart() {
        //           if (localStorage.getItem("data-cbid") !== null) {
        //             $("#dynamic_input").val(localStorage.getItem("data-cbid"));
        //           }

        //           if (localStorage.getItem("data-package-price") !== null) {
        //             packPrice=localStorage.getItem("data-package-price");
        //             $(".package-price").html("$" + localStorage.getItem("data-package-price"));
        //           }
        //           if (localStorage.getItem("data-package-price") !== null) {
        //             $(".totalprice").html(localStorage.getItem("totalprice"));
        //           }

        //           if (localStorage.getItem("data-prod-count") !== null) {
        //             $(".prod-count, .prod-count1").html(
        //               localStorage.getItem("data-prod-count")
        //             );
        //             if (localStorage.getItem("data-prod-count") == 1) {
        //               $("#shippingtext").html("Shipping");
        //               $("#shippingprice").html("$9.95");
        //             } else {
        //               $("#shippingtext").html("Shipping");
        //               $("#shippingprice").html("FREE");
        //             }
        //           }

        //           if (localStorage.getItem("isSubscription") == "true") {
        //             $("#span3-subs").show();
        //           }
        // calcTot();
        //         }

        function calcTot() {
          var addToTotal = 595;
          if ($("#expedited_shipping").is(":checked")) {
            addToTotal += 995;
          }

          $(".totalprice").html("$" + (addToTotal / 100).toFixed(2));
        }
        $("#expedited_shipping").click(function () {
          if ($("#expedited_shipping").is(":checked")) {
            $(".expedited_div").show();
          } else {
            $(".expedited_div").hide();
          }
          calcTot();
        });
        $("#payment_as_shipping").change(function () {
          if ($(this).is(":checked")) {
            //alert("Please select")
            $("#radio_1").prop("checked", true).trigger("change");
          } else {
            $("#radio_2").prop("checked", true).trigger("change");
            initAutocompleteBilling();
          }
        });

        $(".cvv-link").click(function () {
          $(".cvv-image").toggle();
        });

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

        $(document).off("click", "#submit_btn");
        $(document).on("click", "#submit_btn", function (e) {
          // if(!$('#chkAgree').is(':checked')){
          //     toastr.warning('Please check agree before continue.').css("font-size","0.8em");
          // e.preventDefault();
          //     return;
          // }

          cb.beforeFormSubmitEvents.pop();

          cb.beforeFormSubmitEvents.push(function (e) {
            $("#loading-indicator").show();
            var configData = $("#frm").serialize();
            $.ajax({
              url: AJAX_PATH + "checkout",
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
            doFitness();
          })
          .fail(function () {
            console.log("error");
            doFitness();
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
    </script>
  </body>
</html>
