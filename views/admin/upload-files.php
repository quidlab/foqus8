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
        editing: false,
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
                if (insertingItem.file_name) {
                    formData.append("file_name", insertingItem.file_name, insertingItem.file_name.name);
                }

                let t = $.ajax({
                    type: "POST",
                    url: "/api/admin/upload-files",
                    data: formData,
                    contentType: false,
                    processData: false
                }).then(res => {
                    if (res.status) {
                        // 
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                }).catch(res => {
                    toastr.error(res.responseJSON?.message)
                }).then(res => {
                    $("#FilesGrid").jsGrid("render")
                });
                return t;
            },
            updateItem: function(item) {
                var formData = new FormData();
                formData.append("description", item.description);
                formData.append("language", item.language);
                formData.append("id", item.id);
                if (typeof item.file_name === 'object') {
                    formData.append("file_name", item.file_name, item.file_name.name);
                } else {
                    formData.append("file_name", null);
                }

                return $.ajax({
                    type: "POST",
                    url: "/api/admin/upload-files/update",
                    data: formData,
                    contentType: false,
                    processData: false
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                }).catch(res => {
                    toastr.error(res.responseJSON?.message)
                });
            },
            deleteItem: function(item) {
                return $.ajax({
                    type: "DELETE",
                    url: "/api/admin/upload-files",
                    data: item
                }).then(res => {
                    if (res.status) {
                        toastr.success(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                }).catch(res => {
                    toastr.error(res.responseJSON?.message)
                });
            },

        },

        fields: [{
                name: "id",
                title: <?= "'" . __('id') . "'" ?>,
                type: "text",
                editing: false,
                visible: false,
            },
            {
                name: "description",
                title: <?= "'" . __('description') . "'" ?>,
                type: "text",
                editing: true,
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
                    var re = /(?:\.([^.]+))?$/;
                    let ex = re.exec(value)
                    let icon = "";
                    if (['pdf'].includes(ex[1])) {
                        icon = '<i class="fa fa-file-pdf" aria-hidden="true"></i>';
                    } else if (['jpg', 'jpeg', 'png'].includes(ex[1])) {
                        icon = '<i class="fa fa-file-image" aria-hidden="true"></i>';
                    } else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ex[1])) {
                        icon = '<i class="fa fa-file" aria-hidden="true"></i>';
                    }
                    return `<a type="button" href="<?= assets() ?>${"/"+value}" download>${icon}</a>`;
                },
                insertTemplate: function() {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                editTemplate: function(value) {
                    var insertControl = this.insertControl = $("<input>").prop("type", "file");
                    return insertControl;
                },
                insertValue: function() {
                    return this.insertControl[0].files[0];
                },
                editValue: function() {
                    return this.insertControl[0].files[0];
                }
            },
            {
                type: "control",
                editButton: false, // show edit button
                deleteButton: true, // show delete button
            }
        ]

    });
</script>