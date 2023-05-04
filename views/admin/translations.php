<div class="card card-primary">
    <div class="card-header">
        <h3><?= __('languages')  ?></h3>
    </div>
    <div class="card-body">
        <table class="" id="LanguagesGrid"></table>

    </div>
</div>

<br>


<div class="card card-primary">
    <div class="card-header">
        <h3><?= __('translations')  ?></h3>
    </div>
    <div class="card-body">
        <section class="mb-2">
            <input class="form-control w-max d-inline-block " type="text" id="moduleFilter" placeholder="<?= __('filter-by-module') ?> EX: global,dashboard-page" />
            <button class="btn btn-primary" id="searchBtn"><?= __('search') ?></button>
        </section>
        <table id="TranslationGrid"></table>
    </div>
</div>


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
                    url: "/api/admin/translations?module=" + MODULE_FILTER_VALUE,
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
            ?> {
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

<script>
    $("#LanguagesGrid").jsGrid({
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
                    url: "/api/admin/languages",
                    data: filter
                });
            },
            updateItem: function(item) {

                return $.ajax({
                    type: "PUT",
                    url: "/api/admin/languages",
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
                visible:false
            },
            {
                name: "Language_Name",
                title: <?= "'" . __('name') . "'" ?>,
                type: "text",
                editing: false,
            },
            {
                name: "Active",
                title: <?= "'" . __('active') . "'" ?>,
                type: "select",
                items: [{
                        Name: <?= "'" . __('active') . "'" ?>,
                        Id: 1
                    },
                    {
                        Name: <?= "'" . __('inactive') . "'" ?>,
                        Id: 0
                    }
                ],
                valueField: "Id",
                textField: "Name",
                validate: "required",
                editing: true,
            },
            {
                name: "Approve",
                title: <?= "'" . __('approve') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "DisApprove",
                title: <?= "'" . __('disapprove') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "Abstain",
                title: <?= "'" . __('abstain') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "NoVote",
                title: <?= "'" . __('no-vote') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                name: "Void",
                title: <?= "'" . __('void') . "'" ?>,
                type: "text",
                editing: true,
            },
            {
                type: "control",
                editButton: true, // show edit button
                deleteButton: false, // show delete button
            }
        ]

    });
</script>