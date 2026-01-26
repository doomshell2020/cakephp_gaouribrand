<!DOCTYPE html>
<html>

<head>
    <title>Get the App !</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input:focus-visible {
            outline: none;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="text"] {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Get the App !</h1>
        <form action="referral_info" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="mobile">Mobile:</label>
            <!-- <input type="number" id="mobile" name="mobile_no" pattern="[0-9]{10}" required> -->
            <input type="text" id="mobile" name="mobile_no" required onkeypress="return isNumber(event)" maxlength="10">
            <br>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <input type="submit" value="Download APP">
        </form>
    </div>
</body>

</html>

<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode < 48 || charCode > 57) { // Check if the character code is not a digit (0-9)
            return false;
        }
        return true;
    }
</script>