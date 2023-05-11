<div class="card card-primary">
    <div class="card-header">
        <h3><?= __('coupons')  ?></h3>
    </div>
    <div class="card-body">
        <table class="" id="CouponsGrid"></table>

    </div>
</div>


<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>


<script>
    $("#CouponsGrid").jsGrid({
        width: "100%",
        editing: true,
        inserting: true,
        deleting: true,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 20,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete data?",
        filtering: false,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: "/api/admin/coupons",
                    data: filter
                });
            },
            deleteItem: function(item) {

                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/coupons",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                });
            },
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: "/api/admin/coupons",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/api/admin/coupons",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                });
            },

        },

        fields: [
            {
                name: "ID",
                title: <?= "'" . __('ID') . "'" ?>,
                type: "text",
                editing: false,
                visible: false,
            },
            {
                name: "coupon-id",
                title: <?= "'" . __('coupon-id') . "'" ?>,
                type: "text",
                editing: false,
            },
            {
                name: "name",
                title: <?= "'" . __('name') . "'" ?>,
                type: "text",
                editing: false,
            },
            {
                name: "language",
                title: <?= "'" . __('language') . "'" ?>,
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
                name: "coupon-type",
                title: <?= "'" . __('coupon-type') . "'" ?>,
                type: "select",
                items: [{
                        Name: "One for Everyone",
                        ID: "1"
                    },
                    {
                        Name: "One per Person",
                        ID: "2"
                    },
                    {
                        Name: "Self + one Per proxy",
                        ID: "3"
                    },
                    {
                        Name: "Factory Visit",
                        ID: "4"
                    },
                    {
                        Name: "Suggestion",
                        ID: "5"
                    },
                ],
                valueField: "ID",
                textField: "Name",
                editing: true,
            },
            {
                name: "print-coupon",
                title: <?= "'" . __('print-coupon') . "'" ?>,
                type: "select",
                items: [{
                        Name: "Yes",
                        ID: 1
                    },
                    {
                        Name: "No",
                        ID: 0
                    },
                ],
                valueField: "ID",
                textField: "Name",
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