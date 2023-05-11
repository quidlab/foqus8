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
        <section>
            <h2>Ref : <?= $_SESSION['ref'] ?></h2>
            <label for="">OTP</label>
            <input type="text" name="otp">
        </section>
        <button class="btn btn-primary">Submit</button>
    </form>
</body>

</html>