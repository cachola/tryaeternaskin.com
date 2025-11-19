// Oscar Lassalle 05/21/2020
var autocomplete;
var autocompleteBilling;


function initAutocomplete() {

    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('gmap_autocomplete')),
        {types: ['geocode'],componentRestrictions: {country: [ "us"]}});
    

    autocomplete.addListener('place_changed', fillInAddress);

    // if($('#billingAddress').length > 0){

    //     autocompleteBilling = new google.maps.places.Autocomplete(
    //         (document.getElementById('billingAddress1')),
    //         {types: ['geocode'],componentRestrictions: {country: [ "us"]}});

    //     autocompleteBilling.addListener('place_changed', fillInBillingAddress);

    // }
}
function initAutocompleteBilling() {

   
        autocompleteBilling = new google.maps.places.Autocomplete(
            (document.getElementById('billingAddress1')),
            {types: ['geocode'],componentRestrictions: {country: [ "us"]}});

        autocompleteBilling.addListener('place_changed', fillInBillingAddress);

  
}
function fillInAddress() {
    var place = autocomplete.getPlace();

    if (place.address_components) {
        fieldsList=['#gmap_autocomplete','#shippingAddress2','#city','#zip','#shippingState'];
        assignAddress(place,fieldsList);
    }
 }


function fillInBillingAddress() {
    var place = autocompleteBilling.getPlace();

    if (place.address_components) {
        fieldsList=['#billingAddress1','#billingAddress2','#billingCity','#billingZip','#billingState'];
        assignAddress(place,fieldsList);
    }   
}

function assignAddress(place,fieldsList){

    var address = '';
    var locality = '';
    var city = '';
    var county = '';
    var postcode = '';

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
            var val = place.address_components[i].short_name;

            id = addressType;

            // if(addressType == "neighborhood") {
            //    locality=val
            // }
            // if(addressType == "sublocality_level_1") {
            //     locality=val
            //  }
            if(addressType == "postal_code") {
                postcode=val;
            }
            // if(addressType == "premise") {
            //     address+=val;
            // }
            if(addressType == "street_number") {
                address+=" "+val;
                address.trim();
            }

            if(addressType == "route") {
                address+=" "+val;
            }

            if(addressType == "administrative_area_level_1") {
                state = val;
            }
            if(addressType == "locality") {
                city=val;
            }
            if(addressType == "postal_town") {
                city=val;
             }
    }
    $(fieldsList[0]).val(address);
    $(fieldsList[1]).val(locality);
    $(fieldsList[2]).val(city);
    $(fieldsList[3]).val(postcode);
    $(fieldsList[4] ).val(state);
}






// var autocomplete;
// var autocompleteBilling;

// var componentForm = {
//     country: 'short_name',
//     street_number: 'short_name',
//     route: 'long_name',
//     locality: 'long_name',
//     administrative_area_level_1: 'short_name',
//     administrative_area_level_2: 'short_name',
//     postal_code: 'short_name'
// };

// function initAutocomplete() {
//     autocomplete = new google.maps.places.Autocomplete(
//         (document.getElementById('gmap_autocomplete')),
//         {types: ['geocode']});


//     //restrict countries
//     // autocomplete = new google.maps.places.Autocomplete(
//     //     (document.getElementById('gmap_autocomplete')),
//     //     {types: ['geocode'],componentRestrictions: {country: ["us", "ca"]}});
//     //

//     autocomplete.addListener('place_changed', fillInAddress);

//     if($('#billingAddress').length > 0){

//         autocompleteBilling = new google.maps.places.Autocomplete(
//             (document.getElementById('billingAddress')),
//             {types: ['geocode']});

//         autocompleteBilling.addListener('place_changed', fillInBillingAddress);

//     }
// }

// function fillInAddress() {
//     var place = autocomplete.getPlace();
//     for (var component in componentForm) {
//         if(typeof document.getElementById(component) !== "undefined" && document.getElementById(component) !== null)
//         {
//             document.getElementById(component).value = '';
//             document.getElementById(component).disabled = false;
//         }
//     }

//     var address = "";
//     var state = "";
//     var state2 = "";
//     var country = "";

//     var $GoogleShippingStatedropdown = $('#shippingState');
//     var $GoogleShippingCountrydropdown = $('#shippingCountry');
//     for (var i = 0; i < place.address_components.length; i++) {
//         var addressType = place.address_components[i].types[0];
//         if (componentForm[addressType]) {
//             var val = place.address_components[i][componentForm[addressType]];

//             id = addressType;

//             if(addressType == "locality") {
//                 id="city";
//             }
//             if(addressType == "postal_code") {
//                 id="zip";
//             }

//             if(addressType == "street_number") {
//                 address+=val;
//             }

//             if(addressType == "route") {
//                 address+=" "+val;
//             }

//             if(addressType == "administrative_area_level_1") {
//                 id="shippingState";
//                 state = val;
//             }

//             if(addressType == "administrative_area_level_2") {
//                 //id="shippingState";
//                 state2 = val;
//             }

//             if(addressType == "country") {
//                 id="shippingCountry";
//                 country = val;
//             }



//             if(typeof document.getElementById(id) !== "undefined" && document.getElementById(id) !== null){
//                 document.getElementById(id).value = val;
//             }
//         }
//     }
//     document.getElementById("gmap_autocomplete").value = address;

//     if (country != "") {
//         $GoogleShippingCountrydropdown.val(country);
//         $GoogleShippingCountrydropdown.trigger('change');

//         setTimeout(function () {

//             if (country != "GB") {
//                 if (state != "") {
//                     $GoogleShippingStatedropdown.val(state);
//                 }
//             } else {
//                 if (state2 != "") {
//                     var options = $GoogleShippingStatedropdown.find('option');
//                     var targetOption = $(options).filter(
//                         function () { return $(this).text() == state2; });
//                     $GoogleShippingStatedropdown.val(targetOption.val());
//                 }
//             }



//         }, 500);
//     }

// }


// function fillInBillingAddress() {
//     var place = autocompleteBilling.getPlace();
//     for (var component in componentForm) {
//         if(typeof document.getElementById(component) !== "undefined" && document.getElementById(component) !== null)
//         {
//             document.getElementById(component).value = '';
//             document.getElementById(component).disabled = false;
//         }
//     }

//     var address = "";
//     var state = "";
//     var state2 = "";

//     var country = "";

//     var $GoogleBillingStatedropdown = $('#billingState');
//     var $GoogleBillingCountrydropdown = $('#billingCountry');

//     for (var i = 0; i < place.address_components.length; i++) {
//         var addressType = place.address_components[i].types[0];
//         if (componentForm[addressType]) {
//             var val = place.address_components[i][componentForm[addressType]];

//             id = addressType;

//             if(addressType == "locality") {
//                 id="billingCity";
//             }
//             if(addressType == "postal_code") {
//                 id="billingZip";
//             }

//             if(addressType == "street_number") {
//                 address+=val;
//             }

//             if(addressType == "route") {
//                 address+=" "+val;
//             }

//             if(addressType == "administrative_area_level_1") {
//                 id="billingState";
//                 state = val;
//             }

//             if(addressType == "administrative_area_level_2") {
//                 //id="shippingState";
//                 state2 = val;
//             }

//             if(addressType == "country") {
//                 id="billingCountry";
//                 country = val;
//             }



//             if(typeof document.getElementById(id) !== "undefined" && document.getElementById(id) !== null){
//                 document.getElementById(id).value = val;
//             }
//         }
//     }
//     document.getElementById("billingAddress").value = address;

//     if (country != "") {
//         $GoogleBillingCountrydropdown.val(country);
//         $GoogleBillingCountrydropdown.trigger('change');
//         setTimeout(function () {
//             if (country != "GB") {
//                 if (state != "") {
//                     $GoogleBillingStatedropdown.val(state);
//                 }
//             } else {
//                 if (state2 != "") {
//                     var options = $GoogleBillingStatedropdown.find('option');
//                     var targetOption = $(options).filter(
//                         function () { return $(this).text() == state2; });
//                     $GoogleBillingStatedropdown.val(targetOption.val());
//                 }
//             }


//         }, 500);
//     }

// }

// //we have to add the id=gmap_autocomplete to the address field, zip for Postcode, city for City
// // <?php if(defined('GOOGLE_PLACES_API_ID') && !empty(GOOGLE_PLACES_API_ID)){ ?>
// // <script src="resources/gmap/places.js"></script>
// // <script type="text/javascript" async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_PLACES_API_ID; ?>&libraries=places&callback=initAutocomplete"></script>
// // <?php } ?>