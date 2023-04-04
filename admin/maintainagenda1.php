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
       <div id="AgendaGrid"></div>

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
 $('#AgendaGrid').off().on('keydown','input[type=text], input[type=number]',(event) => {
        if(event.which === 13){ // Detect enter keypress
           // args.jsGrid.updateItem(); // Update the row
			$("#AgendaGrid").jsGrid("updateItem");
        }
    });


</script> 
<script>
$(function () {

    var ButtonField = function (config) {
        jsGrid.Field.call(this, config);
    };
ButtonField.prototype = new jsGrid.Field({
                //css: "date-field", // redefine general property 'css'
                align: "center", // redefine general property 'align'
                filtering: false,
                sorting: false,
                editing: false,
                label: "+",
                onClick: $.noop,
                itemTemplate: function (value, item) {
                    var self = this;
                    var $customButton = $("<button>")
                            .text(this.label)
                            .click(function (e) {
								var $pk=item.ID ;
								//$pk= $("#AgendaGrid").jsGrid.onItemEditing ;
								//console.log($pk);
								//$("#AgendaGrid").jsGrid.onItemEditing(console.log(item.ID));
								/////////////////
								//$('#AgendaModal').modal('show');
								//$('#AgendaDetails').text($pk);
								//////////
								//$('#AgendaModal').modal('show');
                                //self.onClick(item);
                                //e.stopPropagation();
                            });
                    return $customButton;
                }
            });
            jsGrid.fields.button = ButtonField;

    $("#AgendaGrid").jsGrid({
    width: "100%",
	height: "auto",
	inserting: true,
    editing: true,
	deleting: true,
    sorting: false,
    paging: true,
    autoload: true,
    pageSize: 10,
    pageButtonCount: 5,
    deleteConfirm: "Do you really want to delete data?",
	filtering: false ,
						/////////////////
				rowRenderer: function(item) {
				var row = $("<tr>");
				//var row=AgendaGrid.jsGrid.item
				var AgendaDetails = $('<td colspan="11">').hide();
				AgendaDetails.jsGrid({
					width: "auto",
        height: "auto",
        inserting: false,
        editing: true,
        deleting: false,
        sorting: false,
        paging: true,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
				controller: {
            loadData: function (filter) {
                return $.ajax({
                    type: "GET",
                    url: "fetch_agendasdetails.php",
                    data: filter
                }).fail(function(err){
            alert(JSON.stringify(err)); 
        });
            },
            insertItem: function (item) {
                return $.ajax({
                    type: "POST",
                    url: "fetch_agendasdetails.php",
                    data: item
                });
            },
            updateItem: function (item) {

                return $.ajax({
                    type: "PUT",
                    url: "fetch_agendasdetails.php",
                    data: item
                });
            },
            deleteItem: function (item) {

                return $.ajax({
                    type: "DELETE",
                    url: "fetch_agendasdetails.php",
                    data: item
                });
            },
        },
        onItemInserted: function (args) {
            // prints [{ field: "Name", message: "Enter client name" }]
            console.log(args.item);
            //$('#logoutModal').modal('show');
        },
        onError: function (args) {
            // prints [{ field: "Name", message: "Enter client name" }]
            console.log(args.item);

        },
				fields: [
            {
                name: "ID",
                type: "text",
                editing: false,
                visible: false
            }, {
                name: "AGENDAID",
                title: "AGENDAID",
                type: "text",
                editing: true,
                width: 30,
                validate: "required"
            }, {
                name: "Agenda_Name",
                title: "Agenda_Name",
                type: "textarea",
                width: 25,
                validate: "required"
            }, {
                name: "Agenda_Info",
                title: "Agenda_Info",
                type: "textarea",
                width: 100,
                editing: true
            }, {
                name: "Approve_Text",
                title: "Approve_Text",
                type: "text",
                width: 35,
                editing: true
            }, {
                name: "DisApprove_Text",
                title: "DisApprove_Text",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                name: "Abstain_Text",
                title: "Abstain_Text",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                name: "NoVote_Text",
                title: "NoVote_Text",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                name: "Language",
                title: "Language",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                type: "control",
                editButton: true,
                deleteButton: false
            }
        ]
      })
	  items = Object.keys(item)
      for(let key in item){
		  
		if(item.hasOwnProperty(key)){
			if (key == 'ID') {continue;}
			var getwidth = $("#AgendaGrid").jsGrid("fieldOption", key, "width");
			//alert (getwidth);
			//var TD="<td style='width=" + getwidth +"'>";
			//alert (TD);
          //var cell1 = $("<td style='width=" + getwidth + "'>").addClass("jsgrid-cell").append(item[key]);
		  ////var cell1 = $("<td style='width=" + getwidth + "'>").addClass("jsgrid-cell").width(getwidth).append(item[key]);
		  var cell1 = $("<td>").addClass("jsgrid-cell").append(item[key]).width(getwidth);
		  //cell1.width=getwidth;
          row.append(cell1);
        }
		
      } 
	 //row.append('<td>');
      row.click(function() {
        AgendaDetails.toggle();
      })
      return row.add(AgendaDetails);
    },
 // });
//}),
				//},
				//////////
    controller: {
      loadData: function(filter){
       return $.ajax({
        type: "GET",
        url: "fetch_agendas.php",
        data: filter
       });
      },
      insertItem: function(item){
       return $.ajax({
        type: "POST",
        url: "fetch_agendas.php",
        data:item
       });
      },
      updateItem: function(item){
		  
       return $.ajax({
        type: "PUT",
        url: "fetch_agendas.php",
        data: item
       });
      },
      deleteItem: function(item){
		  
       return $.ajax({
        type: "DELETE",
        url: "fetch_agendas.php",
        data: item
       });
      },
     },
	 onItemInserted: function(args) {
        // prints [{ field: "Name", message: "Enter client name" }]
        console.log(args.item);
		//$('#logoutModal').modal('show');
    },
	onError: function(args) {
        // prints [{ field: "Name", message: "Enter client name" }]
        console.log(args.item);
		
    },

     fields: [
	 
      { name: "ID", type: "text",editing: false, visible: false },
	  { name: "BTN", type: "button",editing: false,visible: true },//width: 10
      { name: "Sort_ID", title: "Sort", type: "text",editing: true, validate: "required" }, //width: 30
      { name: "AGENDA_ID",title: "AG ID",type: "text", validate: "required"}, //width: 25
	  {	name: "Special_Formula",title: "Formula",type: "select",
	  items: [     
     { Name: "NORMAL", Id: 'NORMAL' },
     { Name: "EXCLUDE_ABSTAIN", Id: 'EXCLUDE_ABSTAIN' },
	 { Name: "EXCLUDE_VOID", Id: 'EXCLUDE_VOID' },
	 { Name: "EXCLUDE_ABSTAIN_AND_VOID", Id: 'EXCLUDE_ABSTAIN_AND_VOID' },
	 { Name: "EXCLUDE_NO_VOTE", Id: 'EXCLUDE_NO_VOTE' },
	 { Name: "EXCLUDE_NO_VOTE_AND_VOID", Id: 'EXCLUDE_NO_VOTE_AND_VOID' },
	 { Name: "EXCLUDE_ABSTAIN_AND_VOID_AND_NOVOTE", Id: 'EXCLUDE_ABSTAIN_AND_VOID_AND_NOVOTE' }
    ], 
    valueField: "Id", 
    textField: "Name", 
    validate: "required",
	filtering: true,
	editing: true
	
      },
	 {name: "Voting_Required",title: "Voting",	type: "select", 
	 items: [
     
     { Name: "YES", Id: 'Y' },
     { Name: "NO", Id: 'N' },
	 { Name: "CUMULATIVE", Id: 'C' },
	 { Name: "SELECTION", Id: 'S' }
    ], 
    valueField: "Id", 
    textField: "Name", 
    validate: "required",
	filtering: true,
	//width: 35,
	editing: true
	
      },
	{name: "Reverse_Vote",title: "INITIAL VOTE",type: "select",
	
    items: [
     
     { Name: "Approve", Id: 'Approve' },
     { Name: "DisApprove", Id: 'DisApprove' },
	 { Name: "Abstain", Id: 'Abstain' },
	 { Name: "NoVote", Id: 'NoVote' }
    ], 
    valueField: "Id", 
    textField: "Name", 
    validate: "required",
	filtering: true,
	//width: 50,
	editing: true
	
      },
	  {
       name: "Approval_Percent",
	title: "Approve %",	   
    type: "text", 
    //width: 30, 
    validate: "required"
      },
	  {
       name: "Approval_Percent_SH",
	title: "Approve % Persons",	   
    type: "text", 
    //width: 30, 
    validate: "required"
      },
	  {
       name: "NumberOfDirectorsToEleect",
	title: "Directors to Select",	   
    type: "text", 
    //width: 30, 
    validate: "required"
      },
	  {	
    name: "Voting_Started",
	title: "Voting Started",	   
    type: "select", 
	
    items: [
     
     { Name: "YES", Id: 'Y' },
     { Name: "NO", Id: 'N' }

    ], 
    valueField: "Id", 
    textField: "Name", 
    validate: "required",
	filtering: true,
	//width: 30,
	editing: true
	
      },
	  {	
    name: "Percent_Based_On_FullShares",
	title: "% on Full Shares",	   
    type: "select", 
	
    items: [
     { Name: "NO", Id: 'N' },
     { Name: "YES", Id: 'Y' }
     

    ], 
    valueField: "Id", 
    textField: "Name", 
    validate: "required",
	filtering: true,
	//width: 30,
	editing: true
	
      },
      {
       name:"control",
	   type: "control",
	   //insertButton:true,
	   editButton: true,                               // show edit button
		deleteButton: true                             // show delete button
 
      }
     ]
	 
    });
		  });
$(document).ready(function(){
  $(document).ajaxError(function(){
    alert("An error occured!");
  });
});
</script> 
<script>
/* $(function () {
    $("#AgendaDetails").jsGrid({
        width: "100%",
        height: "auto",
        inserting: false,
        editing: true,
        deleting: false,
        sorting: false,
        paging: true,
        autoload: true,
        pageSize: 10,
        pageButtonCount: 5,
        controller: {
            loadData: function (filter) {
                return $.ajax({
                    type: "GET",
                    url: "fetch_agendasdetails.php",
                    data: filter
                }).fail(function(err){
            alert(JSON.stringify(err)); 
        });
            },
            insertItem: function (item) {
                return $.ajax({
                    type: "POST",
                    url: "fetch_agendasdetails.php",
                    data: item
                });
            },
            updateItem: function (item) {

                return $.ajax({
                    type: "PUT",
                    url: "fetch_agendasdetails.php",
                    data: item
                });
            },
            deleteItem: function (item) {

                return $.ajax({
                    type: "DELETE",
                    url: "fetch_agendasdetails.php",
                    data: item
                });
            },
        },
        onItemInserted: function (args) {
            // prints [{ field: "Name", message: "Enter client name" }]
            console.log(args.item);
            //$('#logoutModal').modal('show');
        },
        onError: function (args) {
            // prints [{ field: "Name", message: "Enter client name" }]
            console.log(args.item);

        },

        fields: [
            {
                name: "ID",
                type: "text",
                editing: false,
                visible: false
            }, {
                name: "AGENDAID",
                title: "AGENDAID",
                type: "text",
                editing: true,
                width: 30,
                validate: "required"
            }, {
                name: "Agenda_Name",
                title: "Agenda_Name",
                type: "textarea",
                width: 25,
                validate: "required"
            }, {
                name: "Agenda_Info",
                title: "Agenda_Info",
                type: "textarea",
                width: 100,
                editing: true
            }, {
                name: "Approve_Text",
                title: "Approve_Text",
                type: "text",
                width: 35,
                editing: true
            }, {
                name: "DisApprove_Text",
                title: "DisApprove_Text",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                name: "Abstain_Text",
                title: "Abstain_Text",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                name: "NoVote_Text",
                title: "NoVote_Text",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                name: "Language",
                title: "Language",
                type: "text",
                width: 30,
                validate: "required"
            }, {
                type: "control",
                editButton: true,
                deleteButton: false
            }
        ]

    });
});
 */

</script>
   <div class="modal fade" id="AgendaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Input Extra Fields</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="AgendaDetails1" ></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
         
        </div>
      </div>
    </div>
  </div>


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
