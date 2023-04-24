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

        <p class="mt-4 mb-2 text-bold">Select Constants</p>
        <div id="SelectGrid"></div>
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
    $(function() {

        var FoQusDateTimeField = function(config) {
            jsGrid.Field.call(this, config);
        };
        FoQusDateTimeField.prototype = new jsGrid.Field({
            /*         sorter: function (date1, date2) {
            return new Date(date1) - new Date(date2);
            }, */

            itemTemplate: function(value) {
                if (value === null) {
                    return '';
                } else {
                    return value;
                    /* formatedvalue=moment(value).format("YYYY-MM-DDThh:mm");
                    this._editPicker = $('<input type="datetime-local"  value=' + formatedvalue+'>');
                    return this._editPicker; */

                }
            },

            insertTemplate: function(value) {
                this._insertPicker = $('<input type="datetime-local">')
                return this._insertPicker;
            },

            editTemplate: function(value) {
                formatedvalue = moment(value).format("YYYY-MM-DDThh:mm");
                this._editPicker = $('<input type="datetime-local" value=' + formatedvalue + '>');
                return this._editPicker;
            },

            insertValue: function() {
                var insertValue = moment(this._editPicker.val()).format("YYYY-MM-DDThh:mm:ss");
                if (typeof insertDate !== 'undefined' && insertDate !== null) {
                    return insertDate.format('L LTS');
                } else {
                    return null;
                }
            },

            editValue: function() {

                var editValue = moment(this._editPicker.val()).format("YYYY-MM-DDThh:mm:ss");
                //var editValue= moment(this._editPicker.value).format('L LTS');
                console.log(editValue); // always returns current date and time
                if (typeof editValue !== 'undefined' && editValue !== null) {
                    return editValue;
                } else {
                    return null;
                }
            },

        });
        jsGrid.fields.FoQusDateTimeField = FoQusDateTimeField;
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
                    type: "FoQusDateTimeField",
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

<!--  SELECT Constants -->
<script>
    $("#SelectGrid").jsGrid({
        width: "100%",
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
                    url: "/admin/system-constants/select",
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
            }

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
                type: "select",
                editTemplate: function(value, row) {
                    let options = '';
                    this.items = JSON.parse(row.Options);

                    JSON.parse(row.Options).forEach(element => {
                        options += `<option ${element.value == value  ? 'selected':''}  value="${element.value}">${element.name}</option>`;
                    });
                    this.$select = $(`<select>${options}</select>`);
                    return this.$select;
                },
                itemTemplate: function(value, row) {

                    return JSON.parse(row.Options).find((op) => op.value == value)?.name;
                },
                editValue: function() {
                    return this.$select.val();
                },

                width: 100,
                validate: "required",
                items: []
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