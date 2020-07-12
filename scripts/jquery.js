// ---------------------------------------------------------------------------------
// jquery.js
// jquery functions
// ---------------------------------------------------------------------------------
$(document).ready(function()
{
  // Animate header
  $("#animate p").delay(1000).animate({"opacity": "1"}, 700);

  // Delete product from cart when checkbox is checked
  $('.checks').change(function()
  {
    if($(this).prop("checked") == true)
    {
      document.getElementById("update_cart").click();
      $(".checks").prop("checked", true);
    }
    if($(this).prop("checked") == false)
    {
        document.getElementById("update_cart").click();
        $(".checks" ).prop("checked", false);
    }
  });

  // Update cart on quantity change
  $('.cart-quantity').on('keyup change', function()
  {
    if($(this).val() != "")
    {
      document.getElementById("update_cart").click();
    } 
  });

  // Reset shipping checkbox to unchecked when viewing cart
  $("#checkout").click(function()
  {
    if($('#chkShipping').prop('checked', true))
    {
        localStorage.input = 'false';
    }
  });
  			
  // Alternative shipping address check
  $('#alt-chk').click(function()
  {
      // Checked?
      if($(this).prop("checked") == true)
      {       
        // Show alternate shipping form
        $('#chkbox span').html('*Uncheck to use primary address');
        $('#shipping-header h3').html('Alternate Shipping Data*');
        $('#alt-shipping').show();
        $('#main-shipping').hide();

        // Get shipping charge
        if($('#alt-chk').prop('checked') == true)
        {
          $('#alternate-shipping').val(shippingCharge.toFixed(2));   
        }
      }
      else if($(this).prop("checked") == false)
      {
        // Show primary shipping form 
        $('#chkbox span').html('*Alternate recipient/address');
        $('#shipping-header h3').html('Shipping Information*'); 
        $('#alt-shipping').hide();
        $('#main-shipping').show();
      }    
  });

  // Add/don't add shipping charges to order table and shipping forms
  $('#chkShipping').change(function()
  {    
    var shippingRate = 7.50;
    var productQuantity = $('#product-count').text(); 
    var productTotal = $('#subTotal').text();
    var shippingCharge = parseFloat(shippingRate * productQuantity);
    var orderTotal = parseFloat(productTotal) + parseFloat(shippingCharge);
    var total = parseFloat(orderTotal).toString();

    // If next-day shipping checked
    if($(this).prop("checked") == true)
    {                
      $('#shipping_charge').text(shippingCharge.toFixed(2));
      $('#order-total').text(total);      
      $('#prime-shipping').val(shippingCharge.toFixed(2));
      $('#alternate-shipping').val(shippingCharge.toFixed(2));            
    }
    // If unchecked
    if($(this).prop("checked") == false)
    {
      shippingCharge = 0;
      $('#shipping_charge').text(shippingCharge.toFixed(2));
      $('#order-total').text(productTotal);     
      $('#prime-shipping').val(shippingCharge.toFixed(2));     
      $('#alternate-shipping').val(shippingCharge.toFixed(2));      
    }       
  });

  // Payment button click
  $('#button').click(function()
  {    
    if($('#alt-chk').prop('checked'))
    {
      $("#submit-alternate").click(); 
    }
    else
    {       
      $("#submit-primary").click();        
    }    
  });
});  