<div class="page">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-primary">
                <div class="card-header cursor-pointer" onclick="toggleForm()">
                    <h3 class="card-title"><?= __('create-admin') ?></h3>
                </div>


                <form action="/api/admin/users" method="POST" id="createAdminForm">
                    <div class="card-body">
                        <!-- row -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?= __('user-id') ?></label>
                                <input type="text" class="form-control" name="user-id">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1"><?= __('user-name') ?></label>
                                <input type="text" class="form-control" name="user-name">
                            </div>
                        </div>
                        <!-- row -->
                        <!-- row -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?= __('email') ?></label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1"><?= __('password') ?></label>
                                <input type="text" class="form-control" name="password" />
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"><?= __('preferred-language') ?></label>
                                <select name="preferred-language" class="form-control" id=" ">
                                    <?
                                    foreach ($languages as  $language) {
                                        echo "<option value='" . $language['Language_ID'] . "'>" . $language['Language_Name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><?= __('mobile') ?></label>
                                <input type="text" class="form-control" name="mobile" />
                            </div>
                        </div>
                        <!-- row -->
                        <!-- row -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1"><?= __('role') ?></label>
                                <select name="role-id" class="form-control">
                                    <option value="1">Admin</option>
                                    <option value="2">REGISTRATION STAFF</option>
                                    <option value="3">VOTE COUNTING STAFF</option>
                                    <option value="4">MEETING ROOM DISPLAY</option>
                                    <option value="5">REGISTRATION AND VOTE COUNT</option>
                                    <option value="6">DOCUMENT CHECK STAFF</option>
                                    <option value="7">SUPER ADMIN</option>
                                </select>
                            </div>
                        </div>
                        <!-- row -->
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><?= __('submit') ?></button>
                    </div>
                </form>
            </div>



        </div>
    </div>
    <div class="card card-primary">
        <div class="card-header">
            <form action="/api/admin/users/import" method="post" class="float-right" enctype="multipart/form-data">
                <button class="btn btn-excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <?= __('import-users') ?> </button>
                <input type="file" accept=".csv,.xls,.xlsx" name="excel-file" id="" required>
            </form>
            <a download="" href="<?= assets('/assets/templates/users.xlsx') ?>" class="btn btn-excel float-right mr-2"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <?= __('download-sample') ?> </a>
            <p class=" text-bold"><?= __('admin-users') ?></p>
        </div>
        <div class="card-body">
            <div id="AdminsGrid"></div>
        </div>
    </div>
</div>





<?php include __DIR__ . "/../../layouts/footer.php"; ?>
<?php include __DIR__ . "/../../layouts/scripts.php"; ?>


<script>
    <?
    foreach (successes() as $key => $value) {
        echo 'toastr.success("' . $value . '")';
    }
    ?>
</script>
<script>
    <?
    foreach (errors() as $key => $value) {
        echo 'toastr.error("' . $value . '");console.log("' . $value . '")';
    }
    ?>
</script>

<script>
    $('#createAdminForm').fadeOut(0);

    function toggleForm() {
        $('#createAdminForm').toggle(200);
    }
</script>

<script>
    $("#AdminsGrid").jsGrid({
        width: "100%",
        height: "auto",
        inserting: false,
        editing: true,
        deleting: true,
        sorting: false,
        paging: true,
        autoload: true,
        pageSize: 50,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete data?",
        filtering: false,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: "/api/admin/users",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/api/admin/users",
                    data: item
                }).then(res => {
                    res.status ? toastr.success(res.message) : toastr.error(res.message);
                });
            },
            /*             insertItem: function(item) {
                            return $.ajax({
                                type: "POST",
                                url: "/api/admin/users",
                                data: item
                            }).then(res => {
                                res.status ? toastr.success(res.message) : toastr.error(res.message);
                            });
                        }, */
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/users",
                    data: item
                }).then(res => {
                    res.status ? toastr.success(res.message) : toastr.error(res.message);
                });
            },
        },

        fields: [

            {
                name: "user-id",
                title: <?= "'" . __('ID') . "'" ?>,
                type: "text",
                editing: false,
            },
            {
                name: "user-name",
                title: <?= "'" . __('user-name') . "'" ?>,
                type: "text",
                editing: true,
                width: 100,

                validate: "required"
            },
            {
                name: "role-id",
                title: <?= "'" . __('role-id') . "'" ?>,
                type: "select",
                items: [{
                        Name: "Admin",
                        Id: 1
                    },
                    {
                        Name: "REGISTRATION STAFF",
                        Id: 2
                    },
                    {
                        Name: "VOTE COUNTING STAFF",
                        Id: 3
                    },
                    {
                        Name: "MEETING ROOM DISPLAY",
                        Id: 4
                    },
                    {
                        Name: "REGISTRATION AND VOTE COUNT",
                        Id: 5
                    },
                    {
                        Name: "DOCUMENT CHECK STAFF",
                        Id: 6
                    },
                    {
                        Name: "SUPER ADMIN",
                        Id: 7
                    },
                ],
                valueField: "Id",
                textField: "Name",
                editing: true,

            },
            {
                name: "email",
                title: <?= "'" . __('email') . "'" ?>,
                type: "text",
                editing: true,

            },
            {
                name: "preferred-language",
                title: <?= "'" . __('preferred-language') . "'" ?>,
                type: "select",
                items: [
                    <?
                    foreach ($languages as  $language) {
                        echo "{Id: '" . $language['Language_ID'] . "',Name:'" . $language['Language_Name'] . "'},";
                    }
                    ?>
                ],
                editing: true,
                valueField: "Id",
                textField: "Name",
            },
            {
                name: "mobile",
                title: <?= "'" . __('mobile') . "'" ?>,
                type: "text",
                editing: true,

            },
            {
                name: "active",
                title: <?= "'" . __('active') . "'" ?>,
                type: "select",
                items: [{
                        Id: 1,
                        Name: <?= "'" . __('active') . "'" ?>
                    },
                    {
                        Id: 0,
                        Name: <?= "'" . __('inactive') . "'" ?>
                    }
                ],
                valueField: "Id",
                textField: "Name",
                editing: true,

            },
            {
                name: "password",
                title: <?= "'" . __('new-password') . "'" ?>,
                type: "text",
                editing: true,

            },
            {
                type: "control",
                editButton: true, // show edit button
                deleteButton: true, // show delete button

            }
        ]

    });
</script>