<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <p class="mt-4 mb-2 text-bold">Date Constants</p>
        <div id="DatesGrid"></div>

        <p class="mt-4 mb-2 text-bold">Boolean Constants</p>
        <div id="BooleanGrid"></div>

        <p class="mt-4 mb-2 text-bold">Number Constants</p>
        <div id="IntGrid"></div>

        <p class="mt-4 mb-2 text-bold">String Constants</p>
        <div id="StrGrid"></div>
    </div>
</section>
<!-- /.content -->

<?php include __DIR__ . "/../../layouts/footer.php"; ?>
<?php include __DIR__ . "/../../layouts/scripts.php"; ?>

<!-- String Constants -->
<script>
    $("#StrGrid").jsGrid({
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
                    url: "/admin/system-constants/string",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/admin/system-constants/string",
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

<!-- Date Constants -->
<script>
    $("#DatesGrid").jsGrid({
        width: "100%",
        height: "auto",
        editing: true,
        deleting: false,
        sorting: false,
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
                    url: "/admin/system-constants/date",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/admin/system-constants/date",
                    data: item
                }).then(res => {
                    res.status ? toastr.success(res.message) : toastr.error(res.message);
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
                width: 100,
                validate: "required"
            },
            {
                name: "Constant_Value",
                title: "Constant Value",
                type: "text",
                css: "hideoverflow",
                width: 200,
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

<!-- Bool Constants -->
<script>
    $("#BooleanGrid").jsGrid({
        width: "100%",
        height: "auto",
        inserting: false,
        editing: true,
        deleting: false,
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
                    url: "/admin/system-constants/bool",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/admin/system-constants/bool",
                    data: item
                }).then(res => {
                    res.status ? toastr.success(res.message) : toastr.error(res.message);
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
                title: "Constant_Name",
                type: "text",
                editing: false,
                width: 100,

                validate: "required"
            },
            {
                name: "Constant_Value",
                title: "Constant_Value",
                css: "hideoverflow",
                type: "select",
                //////
                editTemplate: function(value) {
                    // Retrieve the DOM element (select)
                    // Note: prototype.editTemplate
                    var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);

                    // Attach onchange listener !
                    $editControl.change(function() {
                        var selectedValue = $(this).val();

                        //alert(selectedValue);
                        $("#BooleanGrid").jsGrid("updateItem");
                        //jsGrid("updateItem");
                    });

                    return $editControl;

                },

                /////
                items: [{
                        Name: "Y",
                        Id: 1
                    },
                    {
                        Name: "N",
                        Id: 0
                    }
                ],
                valueField: "Id",
                textField: "Name",
                width: 50,
                valueType: "number", // the data type of the value
                readOnly: false, // a boolean defines whether select is readonly (added in v1.4)
                validate: "required"
            },
            {
                name: "Description",
                title: "Description",
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

<!-- Number Constants -->
<script>
    $("#IntGrid").jsGrid({
        width: "100%",
        height: "auto",
        inserting: false,
        editing: true,
        deleting: false,
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
                    url: "/admin/system-constants/number",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/admin/system-constants/number",
                    data: item
                }).then(res => {
                    res.status ? toastr.success(res.message) : toastr.error(res.message);
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
                title: "Constant_Name",
                type: "text",
                editing: false,
                width: 100,

                validate: "required"
            },
            {
                name: "Constant_Value",
                title: "Constant_Value",
                css: "hideoverflow",
                valueType: "number", // the data type of the value
                visible: true,
                type: 'number'
            },
            {
                name: "Description",
                title: "Description",
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