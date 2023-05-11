<div class="card card-primary">
    <div class="card-header">
        <h3><?= __('files')  ?></h3>
    </div>
    <div class="card-body">
        <table class="" id="FilesGrid"></table>

    </div>
</div>


<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>


<script>
    $("#FilesGrid").jsGrid({
        width: "100%",
        editing: true,
        inserting: true,
        deleting: false,
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
                    url: "/api/admin/upload-files",
                    data: filter
                });
            },
            insertItem: function(insertingItem) {
                var formData = new FormData();
                formData.append("description", insertingItem.description);
                formData.append("language", insertingItem.language);
                formData.append("file_name", insertingItem.file_name, insertingItem.file_name.name);

                return $.ajax({
                    type: "POST",
                    url: "/api/admin/upload-files",
                    data: formData,
                    contentType: false,
                    processData: false
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
                    url: "/api/admin/upload-files",
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
                name: "description",
                title: <?= "'" . __('description') . "'" ?>,
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
                name: "file_name",
                title: <?= "'" . __('file') . "'" ?>,
                type: "custom",
                editing: true,
                itemTemplate: function(value) {
                    return 'file';
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                insertValue: function() {
                    return this.insertControl[0].files[0];
                },
            },
            {
                type: "control",
                editButton: true, // show edit button
                deleteButton: false, // show delete button
            }
        ]

    });
</script>