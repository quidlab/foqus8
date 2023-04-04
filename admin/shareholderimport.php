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
        <!-- Shareholer Selection -->
<div class="card shadow mb-4">
			        <div class="card-header py-3">
                <h6 class="m-0 " style="display: inline;" >Import Shareholders Data</h6><span style="float: right" class="m-0 " id="log">Import progress ...</span>
			
              </div>
              
              <div class="card-body">
                <div id="result"></div>
                <div class="columns">

                <div class="col1">
                <h6 style="color:blue;">Required Files</h6>
                <ul id="" class="back">
                  <li id="Account_ID" class="li-class">TSD Registration No.</li>
                  <li id="n_title" class="li-class">Title</li>
                  <li id="n_first" class="li-class">First Name</li>
                  <li id="n_last" class="li-class">Last Name</li>
                  <li id="a_holder" class="li-class">Address</li>
                  <li id="i_zip" class="li-class">Zip code</li>
                  <li id="h_phone" class="li-class">Phone No.</li>
                  <li id="q_share" class="li-class">No. of Shares Held</li>
                  <li id="i_ref" class="li-class">ID Card No.</li>
                </ul>
<iframe name="hidden-iframe" style="display: none;"></iframe>
                <div class="upload-btn-wrapper">
                  <form action="agm/import.php" enctype="multipart/form-data" id="import_form" method="post" target="hidden-iframe">
                      <input type="hidden" name="action" value="save_data">
                      <input type="hidden" name="shorting_field" value="" id="after_shorting">
                      <button class="btn btn-primary btn-sm">Select Excel File</button>
                  <input type="file" name="uploadFile" onchange="handleFile()" id='file' accept=".xlsx, .xls, .csv"/>
                    </form>
                    
                </div>
              </div>

              <div class="col2">
                <h6 style="color:blue;">Fields in Excel Files</h6>
                  <ul id="sortable" class="back b1">
              <!--      <li id="result" class="ui-state-default"></li> -->
                  </ul>
              <button onclick="sortFields()" id="sort_btn" class="btn btn-primary btn-sm">Sort</button>
              <button id="import_btn" type="button" class="btn-primary btn-sm" style="display: none;">Import</button>
                  
              </div>

              </div>  

              
            </div>
          </div>
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
 <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="agm/js/xlsx.full.min.js"></script>

  <script>
          function deleteAllData(){
              $.ajax({
                type:"POST",
                url:"agm/ajax.php",
                data: { db_field: shorting_list, action : 'delete_record'},
                success:function(data){
                    if(data == "true"){
                       $("#import_form").submit();
						startProgress();
                    }else{
                        alert(data);
                        alert("Opps something went wrong");
                    }
                }
            })
          }
          
          
        $("#import_btn").on("click",function(){
                          
               $.ajax({
                type:"POST",
                url:"agm/import.php",
                data: { action : 'check_record'},
                success:function(data){
                 if(data != "empty"){
                        var r = confirm("Record already exist. You want to delete??");
                        if (r == true) {
                            deleteAllData();
                        }else {
                            txt = "you click Cancel!";
                        }
                        
                    } 
					else{
                  $("#import_form").submit();
					startProgress();
					}
				} 
}); 
	});				   
						
                        
                 //   }
               // }
	////////		   console.log('fileupload finish');
         //   startProgress();  
	////////		})
     //     })
	 
/* 	 $('#import_form').submit(function(e) {
	console.log('fileupload started');
    e.preventDefault();    
    var formData = new FormData(this);

    $.ajax({
        url: "agm/import.php",
        type: 'POST',
        data: formData,
        success: function (result) {
          console.log(result);
		  startProgress();
        },
        cache: false,
        contentType: false,
        processData: false
    });
}); */
	 
      </script>

    <script>
    $( function() {
      $( "#sortable" ).sortable({
        revert: true
      });
      $( "#draggable" ).draggable({
        connectToSortable: "#sortable",
        helper: "clone",
        revert: "invalid"
      });
      $( "ul, li" ).disableSelection();
    } );
    </script>


    <script>
 $( function() {
   var progressbar = $( "#progressbar" ),
     progressLabel = $( ".progress-label" );

   progressbar.progressbar({
     value: false,
     change: function() {
       progressLabel.text( progressbar.progressbar( "value" ) + "%" );
     },
     complete: function() {
       progressLabel.text( "Complete!" );
     }
   });

   function progress() {
     var val = progressbar.progressbar( "value" ) || 0;

     progressbar.progressbar( "value", val + 2 );

     if ( val < 99 ) {
       setTimeout( progress, 80 );
     }
   }

   setTimeout( progress, 2000 );
 } );
 </script>



<script>
  function extractHeader(ws) {
    const header = []
    const columnCount = XLSX.utils.decode_range(ws['!ref']).e.c + 1
    for (let i = 0; i < columnCount; ++i) {
      header[i] = ws[`${XLSX.utils.encode_col(i)}1`].v
    }
    return header
  }

  function handleFile() {
    const input = document.getElementById("file")
    const file = input.files[0]

    if (file.type !== 'application/vnd.ms-excel')  { 
    
     // renderError() 
    }

    const reader = new FileReader()
    const rABS = !!reader.readAsBinaryString
    reader.onload = e => {
      /* Parse data */
      const bstr = e.target.result

      const wb = XLSX.read(bstr, { type: rABS ? 'binary' : 'array' })
      /* Get first worksheet */
      const wsname = wb.SheetNames[0]
      const ws = wb.Sheets[wsname]

      const header = extractHeader(ws)
    //console.log(sheet_to_json(ws));
  //  JSON.stringify(rowObject,undefined,4)
    //console.log(JSON.stringify(ws));
      //alert(XLSX.utils.sheet_to_json(ws, {header:1}))
	  var ExcelData1= XLSX.utils.sheet_to_json(ws, {header:1});
	  var ExcelData= XLSX.utils.sheet_to_json(ws);
    //console.log(XLSX.utils.sheet_to_json(ws, {header:1}));
	console.log(ExcelData);
	
      AddListItem(header)
	//var ExcelDataMapped =  ExcelData.map(({Account_ID,n_title,n_first,n_last,a_holder,i_zip,h_phone,q_share,i_ref}) => ({Account_ID,n_title,n_first,n_last,a_holder,i_zip,h_phone,q_share,i_ref}))
    var ExcelDataMapped =  ExcelData.map(ExcelData => ({Account_ID:ExcelData.Account_ID,
	n_title:ExcelData.n_title,
	n_first:ExcelData.n_first,
	n_last:ExcelData.n_last,
	a_holder:ExcelData.a_holder,
	i_zip:ExcelData.i_zip,
	h_phone:ExcelData.h_phone,
	q_share:ExcelData.q_share,
	i_ref:ExcelData.i_ref}));
	console.log(ExcelDataMapped);
	}

    if (rABS) reader.readAsBinaryString(file)
      else reader.readAsArrayBuffer(file)
  }

  function AddListItem(header) {
 
document.getElementById("sortable").innerHTML = "";
     for (let i in header) {
  //     console.log (header[i]);
       var ul = document.getElementById("sortable");
        var li = document.createElement("li");
        li.setAttribute("id","l"+i);
		//add <i> class="li-class"
		li.setAttribute("class","li-class");
   li.appendChild(document.createTextNode(header[i]));
   ul.appendChild(li);

    }

 
  }

  function renderError() {
    const errorMsg = 'Unexpected file type'
    const error = document.createElement('p')
    error.setAttribute('class', 'error')
    const txt = document.createTextNode(errorMsg)
    error.appendChild(txt)
    document.getElementById('result').appendChild(error)
    throw new Error(errorMsg)
  }
</script>
<script>
    
    var shorting_list = '';
    
function sortFields() {
	if ($("#sort_btn").text() == "Finished Sorting") { $("#import_btn").show(); } 																						  
var requiredFields =['Account_ID','n_title','n_first','n_last','a_holder','i_zip','h_phone','q_share','i_ref'  ];
var presentFields = [];
let lis = document.getElementById('sortable').childNodes;
for(var i=0;i < lis.length; i++) {
    var arrValue = lis[i].innerHTML;
    presentFields.push(arrValue);
}
    
console.log(presentFields);
    shorting_list = presentFields;
    $("#after_shorting").val(shorting_list);
    //alert();
    
    
    
let checker = (arr, target) => target.every(v => arr.includes(v));

if (checker( presentFields,requiredFields)){
$(sortable).empty();
    
AddListItem(requiredFields);
	sortFieldsSecond();													   
    $("#import_btn").show();   
}
else{
	if ($("#sort_btn").text() == "Finished Sorting") { $("#import_btn").show(); }
	else
	{		
  //  $("#import_btn").show();
   $("#sort_btn").text("Finished Sorting");																			  
    alert("Fields do not match, please arrange manually");
	
	}
}
}
    
    
    
function sortFieldsSecond() {
var requiredFields =['Account_ID','n_title','n_first','n_last','a_holder','i_zip','h_phone','q_share','i_ref'  ];
var presentFields = [];
let lis = document.getElementById('sortable').childNodes;
for(var i=0;i < lis.length; i++) {
    var arrValue = lis[i].innerHTML;
    presentFields.push(arrValue);
}
    
console.log(presentFields);
    shorting_list = presentFields;
    $("#after_shorting").val(shorting_list);
    //alert();
    
let checker = (arr, target) => target.every(v => arr.includes(v));

if (checker( presentFields,requiredFields)){
$(sortable).empty();
    
AddListItem(requiredFields);
    $("#import_btn").show();   
	
}
else{
    $("#import_btn").show();
}
}
    
    
</script>
<script>

function startProgress() {
	console.log('added');
//var button = document.getElementById('import_btn');
    var progress = document.getElementById('progress');
    var log = document.getElementById('log');

//button.addEventListener('click', function(){
	   console.log('started');
        var sse = new EventSource('agm/progress.php');

        sse.addEventListener('open',function(event){
			console.log('open');
            log_to_display('Connection opened', 0);
//  });

        sse.addEventListener('progress',function(event){
            var data = JSON.parse(event.data);
            log_to_display(data.message, data.progress);
			console.log(data.message);
        });

        sse.addEventListener('error',function(event){
            console.log(event);
			sse.close();
           console.log('error');
			log_to_display("Error!");
        });

        sse.addEventListener('close',function(event){
            sse.close();
			console.log('close');
            var data = JSON.parse(event.data);
            log_to_display(data.message, data.progress);
      });
  });

    function log_to_display(message, progressValue = 0){
        //progress.value = progressValue;
      // var div = document.createElement('div');
      //  div.textContent = message + ' (progress: ' + progressValue + ')';
       // document.getElementById("log").innerHTML = message + ' (progress: ' + progressValue + ')';
	   //log.prepend(div);
	   //log.InnerHTML = 'abc';
	 //  $('#log').html(message + ' (progress: ' + progressValue + ')');
	 if ( message == null ) {message=" ";}
	 $('#log').html(message);
    }
}
	
	
	
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