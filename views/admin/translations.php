<table id="TranslationGrid"></table>


<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>


<!--  SELECT Constants -->
<script>
    $("#TranslationGrid").jsGrid({
        width: "100%",
        editing: false,
        inserting: true,
        deleting: true,
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
                    url: "/api/admin/translations",
                    data: filter
                });
            },
/*             updateItem: function(item) {

                return $.ajax({
                    type: "PUT",
                    url: "/api/admin/translations",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                });
            }, */
            insertItem: function(item) {
                return $.ajax({
                    type: "POST",
                    url: "/api/admin/translations",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message);
                    } else {
                        toastr.error(res.message);
                    }
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/translations",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message);
                    } else {
                        toastr.error(res.message);
                    }
                });
            },
        },

        fields: [{
                name: "Key",
                type: "text",
                editing: false,
            },

            <?php
            foreach ($languages  as $key => $lang) {
                echo '
                {
                    name: "Value_' . $lang['Language_ID'] . '",
                    title: "' . $lang['Language_ID'] . '",
                    type: "text",
                    editing: true,
                    width: 200,
                    validate: "required"
                },
                ';
            }
            ?> {
                type: "control",
                editButton: false, // show edit button
                deleteButton: true, // show delete button
            }
        ]

    });
</script>