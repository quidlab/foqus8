<div class="card card-primary">
    <div class="card-header">
        <h3><?= __('proxy-names')  ?></h3>
    </div>
    <div class="card-body">
        <table class="" id="proxyNamesGrid"></table>

    </div>
</div>


<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>


<script>
    $("#proxyNamesGrid").jsGrid({
        width: "100%",
        editing: false,
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
                    url: "/api/admin/proxy-name",
                    data: filter
                });
            },
            deleteItem: function(item) {

                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/proxy-name",
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
                    url: "/api/admin/proxy-name",
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

        fields: [{
                name: "Proxy_Name",
                title: <?= "'" . __('proxy-name') . "'" ?>,
                type: "text",
                editing: false,
            },
            {
                type: "control",
                editButton: false, // show edit button
                deleteButton: true, // show delete button
            }
        ]

    });
</script>