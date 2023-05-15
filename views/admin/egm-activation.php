
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="Grid"></div>
    </div>
</section>
<!-- /.content -->

<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>


<script>
    $("#Grid").jsGrid({
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
                    url: "/api/admin/shareholders",
                    data: filter
                });
            },
            deleteItem: function(item) {

                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/shareholders",
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
                    url: "/api/admin/shareholders",
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
                name: "ID",
                title: <?= "'" . __('ID') . "'" ?>,
                type: "text",
                editing: false,
            },
            {
                name: "n_title",
                title: <?= "'" . __('n_title') . "'" ?>,
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