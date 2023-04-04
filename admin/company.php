<?php 
include "inc/main.php";
if(isset($_SESSION['uname'])){
include "inc/meta.php"; ?>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
<?php include "inc/preloader.php"; ?>
<?php include "inc/popuplogout.php"; ?>
<?php include "inc/nav.php"; ?>
<?php include "inc/sidebar.php"; ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<?php include "inc/company_name_header.php"; ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
       <div id="companyGrid"></div>
	   <br/>
	   <div id="DatesGrid"></div>
	   <br/>
	   <div id="BooleanGrid"></div>
	   <?php //include "company2.php"; ?>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
 <?php include "inc/footer.php"; ?>
<script>
 $('#companyGrid').off().on('keydown','input[type=text], input[type=number]',(event) => {
        if(event.which === 13){ // Detect enter keypress
           // args.jsGrid.updateItem(); // Update the row
			$("#companyGrid").jsGrid("updateItem");
        }
    });
 	$('#DatesGrid').off().on('keydown',(event) => {
        if(event.which === 13){ // Detect enter keypress
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
	 filtering: false ,	
     controller: {
      loadData: function(filter){
       return $.ajax({
        type: "GET",
        url: "fetch_company.php",
        data: filter
       });
      },
      insertItem: function(item){
       return $.ajax({
        type: "POST",
        url: "fetch_company.php",
        data:item
       });
      },
      updateItem: function(item){
		  
       return $.ajax({
        type: "PUT",
        url: "fetch_company.php",
        data: item
       });
      },
      deleteItem: function(item){
		  
       return $.ajax({
        type: "DELETE",
        url: "fetch_company.php",
        data: item
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
     
     { Name: "Eng", Id: 'en' },
     { Name: "Thai", Id: 'th' }
    ], 
    valueField: "Id", 
    textField: "Name", 
    validate: "required",
	filtering: true,
	editing: false,
	
      },
      {
       type: "control",
	   editButton: true,                               // show edit button
	deleteButton: false,                             // show delete button
 
      }
     ]

    });
</script> 

<script>
     $(function () {

    var FoQusDateTimeField = function (config) {
        jsGrid.Field.call(this, config);
    };
    FoQusDateTimeField.prototype = new jsGrid.Field({
        /*         sorter: function (date1, date2) {
        return new Date(date1) - new Date(date2);
        }, */

        itemTemplate: function (value) {
            if (value === null) {
                return '';
            } else {
                return value;
                /* formatedvalue=moment(value).format("YYYY-MM-DDThh:mm");
                this._editPicker = $('<input type="datetime-local"  value=' + formatedvalue+'>');
                return this._editPicker; */

            }
        },

        insertTemplate: function (value) {
            this._insertPicker = $('<input type="datetime-local">')
                return this._insertPicker;
        },

        editTemplate: function (value) {
            formatedvalue = moment(value).format("YYYY-MM-DDThh:mm");
            this._editPicker = $('<input type="datetime-local" value=' + formatedvalue + '>');
            return this._editPicker;
        },

        insertValue: function () {
            var insertValue = moment(this._editPicker.val()).format("YYYY-MM-DDThh:mm:ss");
            if (typeof insertDate !== 'undefined' && insertDate !== null) {
                return insertDate.format('L LTS');
            } else {
                return null;
            }
        },

        editValue: function () {

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
	 filtering: false ,	
     controller: {
      loadData: function(filter){
       return $.ajax({
        type: "GET",
        url: "fetch_dates_constants.php",
        data: filter
       });
      },
      insertItem: function(item){
       return $.ajax({
        type: "POST",
        url: "fetch_dates_constants.php",
        data:item
       });
      },
      updateItem: function(item){
		  
       return $.ajax({
        type: "PUT",
        url: "fetch_dates_constants.php",
        data: item
       });
      },
      deleteItem: function(item){
		  
       return $.ajax({
        type: "DELETE",
        url: "fetch_dates_constants.php",
        data: item
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
	   editButton: true,                               // show edit button
	deleteButton: false,                             // show delete button
 
      }
     ]

    });
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
	 filtering: false ,	
     controller: {
      loadData: function(filter){
       return $.ajax({
        type: "GET",
        url: "fetch_booleanconstants.php",
        data: filter
       });
      },
      updateItem: function(item){
       return $.ajax({
        type: "PUT",
        url: "fetch_booleanconstants.php",
        data: item
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
	editTemplate: function (value) {
                // Retrieve the DOM element (select)
                // Note: prototype.editTemplate
                var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);

                // Attach onchange listener !
                $editControl.change(function(){
                    var selectedValue = $(this).val();

                    //alert(selectedValue);
					$("#BooleanGrid").jsGrid("updateItem");
					//jsGrid("updateItem");
                });

                return $editControl;
            
        },
	
	/////
    items: [
     { Name: "Y", Id: 1 },
     { Name: "N", Id: 0 }
    ], 
    valueField: "Id", 
    textField: "Name", 
    width: 50, 
	valueType: "number", // the data type of the value
    readOnly: false,            // a boolean defines whether select is readonly (added in v1.4)
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
	   editButton: true,                               // show edit button
	deleteButton: false,                             // show delete button
 
      }
     ]

    });
</script> 


</body>
</html>
<?php 
}
else{
	?>
	
	<script>
		window.location.href="logout.php"; 
	</script>

	<?php
}
?>
