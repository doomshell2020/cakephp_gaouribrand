<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
  "key": "rzp_test_ZL1wkQfxNIacl5",
  "amount": 50000,
  "currency": "INR",
  "order_id": "order_S8W43dIHXZbcOz",
  "handler": function (response){
      console.log(response);
      // response.razorpay_payment_id
      // response.razorpay_order_id
      // response.razorpay_signature
  }
};
var rzp1 = new Razorpay(options);
rzp1.open();
</script>