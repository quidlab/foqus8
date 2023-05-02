<section class="mb-2">
    <label class="d-block" for=""><?= __('filter-by-module') ?></label>
    <input type="text" id="moduleFilter" placeholder="EX: global,dashboard-page" />
    <button id="searchBtn"><?= __('search') ?></button>
</section>
<table id="TranslationGrid"></table>


<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>


<!-- Filters -->
<script>
    var MODULE_FILTER_VALUE = '';
    $('#searchBtn').on("click", function() {
        MODULE_FILTER_VALUE = $('#moduleFilter').val();
        $("#TranslationGrid").jsGrid("option", "data", []);
        $("#TranslationGrid").jsGrid("loadData");
    });
</script>


<script>
    $("#TranslationGrid").jsGrid({
        width: "100%",
        editing: true,
        inserting: false,
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
                    url: "/api/admin/translations?module="+MODULE_FILTER_VALUE,
                    data: filter
                });
            },
            updateItem: function(item) {

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
            },
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
                title: <?= "'" . __('key') . "'" ?>,
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
            ?>{
                name: "Module",
                title: <?= "'" . __('module') . "'" ?>,
                type: "text",
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