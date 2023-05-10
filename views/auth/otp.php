<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?
    foreach (errors() as $key => $value) {
        echo '<p style="color:red">' . $key . $value . '</p>';
    } ?>
    <form action="/auth/otp" method="post">
        <input style="display: none;" type="text" name="verifying-email" value="<?= $_SESSION['verifying-email'] ?>">
        <? if (constant('MC_REQUIRE_EMAIL_OTP')) { ?>
            <section>
                <h2>Ref : <?= $_SESSION['mail-ref'] ?></h2>
                <label for="">Email OTP</label>
                <input type="text" name="mail-otp">
                <?= '<p style="color:red">' . errors('email-otp') . '</p>' ?>
            </section>
        <? } ?>

        <? if (constant('MC_REQUIRE_PHONE_OTP')) { ?>
            <section>
                <h2>Ref : <?= $_SESSION['mobile-ref'] ?></h2>

                <label for="">Mobile OTP</label>
                <input type="text" name="mobile-otp">
                <?= '<p style="color:red">' . errors('mobile-otp') . '</p>' ?>

            </section>
        <? } ?>

        <button class="btn btn-primary">Submit</button>
    </form>
</body>

</html>