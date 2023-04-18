<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="companyGrid"></div>

        <p class="mt-4 mb-2 text-bold">Date Constants</p>
        <div id="DatesGrid"></div>

        <p class="mt-4 mb-2 text-bold">Boolean Constants</p>
        <div id="BooleanGrid"></div>

        <p class="mt-4 mb-2 text-bold">Integer Constants</p>
        <div id="IntGrid"></div>

        <p class="mt-4 mb-2 text-bold">String Constants</p>
        <div id="StrGrid"></div>
    </div>
</section>
<!-- /.content -->


<?php include __DIR__ . "/../layouts/footer.php"; ?>
<?php include __DIR__ . "/../layouts/scripts.php"; ?>

<script>
    $('#companyGrid').off().on('keydown', 'input[type=text], input[type=number]', (event) => {
        if (event.which === 13) { // Detect enter keypress
            // args.jsGrid.updateItem(); // Update the row
            $("#companyGrid").jsGrid("updateItem");
        }
    });
    $('#DatesGrid').off().on('keydown', (event) => {
        if (event.which === 13) { // Detect enter keypress
            // args.jsGrid.updateItem(); // Update the row
            console.log('Enter key Captured');
            $("#DatesGrid").jsGrid("updateItem");
        }
    });
    /* 	 $('#BooleanGrid').on('afterEditCell' ,(event)=> {
            
    		   console.log('Enter key Captured');
    			$("#BooleanGrid").jsGrid("updateItem");
            
        }); */
</script>
<script>
    $("#companyGrid").jsGrid({
        width: "100%",
        height: "auto",
        // inserting: true,
        editing: true,
        deleting: true,
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
                    url: "/admin/company",
                    data: filter
                });
            },
            updateItem: function(item) {

                return $.ajax({
                    type: "PUT",
                    url: "/admin/company",
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
                name: "Company_Name",
                title: "Company Name",
                type: "text",
                editing: true,
                width: 250,

                validate: "required"
            },
            {
                name: "Meeting_Place",
                title: "Meeting Place",
                type: "text",
                width: 250,
                validate: "required"
            },
            {
                name: "Tlang",
                title: "Language",
                type: "select",

                items: [

                    {
                        Name: "Eng",
                        Id: 'en'
                    },
                    {
                        Name: "Thai",
                        Id: 'th'
                    }
                ],
                valueField: "Id",
                textField: "Name",
                validate: "required",
                filtering: true,
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
    $(function() {

        var FoQusDateTimeField = function(config) {
            jsGrid.Field.call(this, config);
        };
        FoQusDateTimeField.prototype = new jsGrid.Field({
            /*         sorter: function (date1, date2) {
            return new Date(date1) - new Date(date2);
            }, */

            itemTemplate: function(value) {
                return moment(value).locale('en').format('YYYY-MM-DD HH:mm:ss');

            },



            editTemplate: function(value) {
                return moment(value).locale('en').format('YYYY-MM-DD HH:mm:ss');
            },

        });
        jsGrid.fields.FoQusDateTimeField = FoQusDateTimeField;


    });
</script>


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
                    url: "/admin/constants/date",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/admin/constants/date",
                    data: item
                }).then(res => {
                    res.status?toastr.success(res.message):toastr.error(res.message);
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
                    url: "/admin/constants/bool",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/admin/constants/bool",
                    data: item
                }).then(res => {
                    res.status?toastr.success(res.message):toastr.error(res.message);
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
                    url: "/admin/constants/int",
                    data: filter
                });
            },
            updateItem: function(item) {
                return $.ajax({
                    type: "PUT",
                    url: "/admin/constants/int",
                    data: item
                }).then(res => {
                    res.status?toastr.success(res.message):toastr.error(res.message);
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
                type:'number'
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

<!--  Str Constants -->
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