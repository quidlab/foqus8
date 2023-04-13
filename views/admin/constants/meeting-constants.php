<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div id="meetingConstantsGrid"></div>
    </div><!--/. container-fluid -->
</section>



<?php include __DIR__ . "/../../layouts/footer.php"; ?>
<?php include __DIR__ . "/../../layouts/scripts.php"; ?>

<script>
    $("#meetingConstantsGrid").jsGrid({
        width: "100%",
        height: "600px",
        editing: true,
        deleting: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        deleteConfirm: "Do you really want to delete data?",
        filtering: false,
        controller: {
            loadData: function(filter) {
                return $.ajax({
                    type: "GET",
                    url: "/admin/constants/meeting",
                    data: filter
                });
            },
            updateItem: function(item) {

                return $.ajax({
                    type: "PUT",
                    url: "/admin/constants/meeting",
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
                type: "text",
                editing: false,
                visible: false,
                width: 10
            },
            {
                name: "Constant_Name",
                title: "Constant Name",
                type: "text",
                editing: false,
                width: 200,

                validate: "required"
            },
            {
                name: "Constant_Value",
                title: "Constant Value",
                css: "hideoverflow",
                type: "text",
                width: 100,
                validate: "required"
            },
            {
                name: "Description",
                title: "Description",
                type: "text",
                width: 200,
                editing: false,

            },
            {
                type: "control",
                editButton: true, // show edit button
                deleteButton: false, // show delete button

            }
        ]

    });
</script>