<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div id="companyGrid"></div>
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
                    if(res.status){
                        toastr.success(res.message)
                    }else{
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


    });
</script>
