<div class="page">
    <div class="row">
        <div class="col-md-12">

            <div class="card card-primary">
                <div class="card-header cursor-pointer" onclick="toggleForm()">
                    <h3 class="card-title"><?= __('create-presenter') ?></h3>
                </div>


                <form action="/api/admin/presenters" method="POST" id="createAdminForm">
                    <div class="card-body">
                        <!-- row -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label><?= __('user-name') ?></label>
                                <input type="text" class="form-control" name="user-name">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= __('title') ?></label>
                                <input type="text" class="form-control" name="title">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label><?= __('first-name') ?></label>
                                <input type="text" class="form-control" name="first-name">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= __('last-name') ?></label>
                                <input type="text" class="form-control" name="last-name">
                            </div>
                        </div>
                        <!-- row -->
                        <!-- row -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label><?= __('email') ?></label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= __('password') ?></label>
                                <input type="text" class="form-control" name="password" />
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for=""><?= __('mobile') ?></label>
                                <input type="text" class="form-control" name="mobile" />
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= __('role') ?></label>
                                <select name="role" class="form-control">
                                    <option value="Company Secretary">Company Secretary</option>
                                    <option value="Director">Director</option>
                                    <option value="Guest">Guest</option>
                                    <option value="Director1">Director1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                    <!-- row -->
                    <div class="row">

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
                    url: "/api/admin/presenters",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/api/admin/presenters",
                    data: item
                }).then(res => {
                    res.status ? toastr.success(res.message) : toastr.error(res.message);
                }).catch(re => {
                    if (re.responseJSON?.errors) {
                        Object.values(re.responseJSON?.errors).forEach(element => {
                            toastr.error(element)
                        });
                    }
                });
            },

            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/presenters",
                    data: item
                }).then(res => {
                    res.status ? toastr.success(res.message) : toastr.error(res.message);
                });
            },
        },

        fields: [

            {
                name: "title",
                title: <?= "'" . __('title') . "'" ?>,
                type: "text",
                editing: false,
            },
            {
                name: "first-name",
                title: <?= "'" . __('first-name') . "'" ?>,
                type: "text",
                editing: true,
                width: 100,

                validate: "required"
            },
            {
                name: "last-name",
                title: <?= "'" . __('last-name') . "'" ?>,
                type: "text",
                editing: true,
                width: 100,

                validate: "required"
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
                name: "role",
                title: <?= "'" . __('role') . "'" ?>,
                type: "select",
                items: [{
                        Name: "Company Secretary",
                        Id: "Company Secretary"
                    },
                    {
                        Name: "Director",
                        Id: "Director"
                    },
                    {
                        Name: "Guest",
                        Id: "Guest"
                    },
                    {
                        Name: "Director1",
                        Id: "Director1"
                    }
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
                name: "mobile",
                title: <?= "'" . __('mobile') . "'" ?>,
                type: "text",
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