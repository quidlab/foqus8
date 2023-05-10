<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="/auth/mobile-otp" method="post">
        <section>
            <label for="">Mobile OTP</label>
            <input type="text" name="otp">
            <?
            foreach (errors() as $key => $error) {
                echo '<p style="color:red">' . $error . '</p>';
            }
            ?>
            <button class="btn btn-primary">Submit</button>

        </section>
    </form>
</body>

</html>