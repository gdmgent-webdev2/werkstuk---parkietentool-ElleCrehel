<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Submitted</h1>
    <p>Your order has been submitted successfully!</p>
    <script>
        setTimeout(function() {
            window.location.href = '/order';
        }, 2000); // Redirect back to the order form after 3 seconds
    </script>
</body>
</html>
