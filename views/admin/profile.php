<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->

    <hr class="mt-0 mb-4">
    <div class="row">
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form method="POST" action="/admin/profile">
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername"><?= __('user-name') ?></label>
                            <input class="form-control" name="user-name" type="text" placeholder="Enter your username" value="<?= $user['user-name'] ?>" disabled>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName"><?= __('email') ?></label>
                                <input class="form-control" name="email" type="text" placeholder="Email" value="<?= $user['email'] ?>">
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName"><?= __('phone') ?></label>
                                <input class="form-control" name="mobile" type="text" placeholder="Mobile" value="<?= $user['mobile'] ?>">
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName"><?= __('preferred-language') ?></label>
                                <select name="preferred-language" class="form-control" id="">
                                    <option value="en" <?= $user['preferred-language'] == 'en' ? 'selected' : '' ?>>en</option>
                                    <option value="th" <?= $user['preferred-language'] == 'th' ? 'selected' : '' ?>>th</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">New Password</label>
                                <input class="form-control" name="password" type="text" placeholder="Enter your phone number" value="">
                            </div>

                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>
<script>
    <?
    foreach (successes() as $key => $value) {
        echo 'toastr.success("' . $value . '")';
    }
    ?>
</script>