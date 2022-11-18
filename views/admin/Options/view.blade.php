@extends('admin.layouts.master')
@section('mainContent')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
@endif

<!--Start::Content-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-label">
            Options
            <!-- <div class="text-muted pt-2 font-size-sm">custom colu rendering</div> -->
         </h3>
      </div>
   </div>
   <div class="card-body">
      <!--begin: Datatable-->
      <div id="kt_datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
         <div class="row">
            <div class="col-sm-12">
               <table class="table table-separate table-head-custom datatable table-checkable" id="kt_datatable">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Option</th>
                        <th>Value</th>
                        <th>Status</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                  @foreach ($options as $key => $option)
                     <tr>
                        <td>{{ $option->id }}</td>
                        <td>{{ $option->title }}</td>
                        <td>
                              {{Str::limit($option->description, 80)}}
                        </td>
                        <td> @if( $option->status == '1')
                                 <span style="color:green">Active</span>
                              @elseif($option->status == '0')
                                 <span style="color:Red;">InActive</span>
                              @endIf
                        </td>
                        <td nowrap="nowrap">
                           <a href="#" id="statusId" data-toggle="modal" data-name="{{ $option->status}}" class="btn btn-sm btn-success status" data-target="#statModal" data-id="{{ $option->id }}">Change Status</a>                  
                           <a href="#" id="editId" data-toggle="modal" class="btn btn-sm btn-info" data-target="#mainModal" data-id="{{ $option->id }}">Update</a>
                           <!-- <a href="#" data-name="{{ $option->name }}" class="btn btn-sm btn-danger delete" data-toggle="modal" data-id="{{ $option->id }}" disabled="'true'" data-target="#confModal">Delete</a> -->
                        </td>
                     </tr>
                  @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!--end: Datatable-->
   </div>
</div>

<!-- Modal-->
<div class="modal fade" id="mainModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="align:center;" role="document">
	<form  class="form fv-plugins-bootstrap fv-plugins-framework" method="POST" action="" id="kt_form_1" novalidate="novalidate">
		@csrf
		@if(@$models)
			@method('post')
		@endif
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Save Options</h5>
                <button type="button" class="close mainclose" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            <div class="form-group row fv-plugins-icon-container has-danger">
					<label class="col-form-label text-right col-lg-3 col-sm-12">Description *</label>
					<div class="col-lg-9 col-md-9 col-sm-12">
                  <textarea class="form-control summernote" name="description" value="" id="editdesc" placeholder="Enter Description"></textarea>
   				</div>
				</div>
            <input type="hidden" id="idforEdit" />
			   <input type="hidden">            
         </div>
         <div class="modal-footer">
               <button type="reset" class="btn btn-light-primary font-weight-bold reset" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary font-weight-bold" id="submit"> Save changes</button>
         </div>
        </div>
		</form>
    </div>
</div>

<!--end::Content-->

@endsection
@push('js')
<script>
      //Submit
      $('#submit').click(function(event){ 
            event.preventDefault();
         var data = $('#kt_form_1').serialize();
         var id = $('#idforEdit').val();
         var uri = "http://127.0.0.1:8001/api/options/update/" + id;
         $.ajax({  
            url: uri,
            method:"POST",  
            data:data,  
            success:function(data){
               $('#mainModal').modal('hide');
               $('#okModal').modal('show');
               clear();
               reLoad();
            }  
         });  
      });  
      $(document).on('click', '.mainclose', function(e){
         clear();
      });
      //Clear
      var clear = function(){
         $("#idforDel").val('');
         $("#record").html('');
      };
      //Status Changed
      $(document).on('click' ,'#statusId', function (event) {
         event.preventDefault();
         let id = $(this).data('id');
         let status = $(this).data('name'); 
         if(status == '1')
         {
            $("#currStatus").text('Active');
            $("#InAcStat").show();
            $("#AcStat").hide();
         }else if(status == '0')
         {
            $("#currStatus").text('InActive');
            $("#InAcStat").hide();
            $("#AcStat").show();
         }
         $('#idforstat').val(id);
      });
      //Change Status
      // for Active Status 
      $(document).on('click' ,'#AcStat', function (e) {
         e.preventDefault();
         let id = $("#idforstat").val();
         let Active = $('#Active').data('id');
         uri   = 'http://127.0.0.1:8001/api/options/setActive';
         // var tr = $(this).closest('tr');
         $.ajax({
               url: uri,
               type: "POST",
               data: {
               id: id,
               status: Active,
               _token:'{{csrf_token()}}',
            },
            success: function (data) {
                  toastr.success(data.message)
                  $('#kt_form_1').trigger("reset");
                  $("[data-dismiss=modal]").trigger({ type: "click" });
                  reLoad();
            },error: function(responce)
            {
               var err = JSON.parse(responce.responseText);
               toastr.error(err.message);
            }  
         });
      });
      // for InActive Status 
      $(document).on('click' ,'#InAcStat', function (e) {
         e.preventDefault();
         let id = $("#idforstat").val();
         let Active = $('#InActive').data('id');
         uri   = 'http://127.0.0.1:8001/api/options/setInActive';
         // var tr = $(this).closest('tr');
         $.ajax({
               url: uri,
               type: "POST",
               data: {
               id: id,
               status: Active,
               _token:'{{csrf_token()}}',
            },
            success: function (data) {
                  toastr.success(data.message)
                  $('#kt_form_1').trigger("reset");
                  $("[data-dismiss=modal]").trigger({ type: "click" });
                  reLoad();
            },error: function(responce)
            {
               var err = JSON.parse(responce.responseText);
               toastr.error(err.message);
            }  
         });
      });
      $(document).on('click', '#editId', function (event) {
         event.preventDefault();
         var id = $(this).data('id');
         $.get("http://127.0.0.1:8001/api/options/getData/"+id+"", function (data) {
            console.log('data', data);
            $('#idforEdit').val(data.id);
            $('#editdesc').summernote('code',data.description);
         })
      });

      //DataTable
      var table = $('#kt_datatable').DataTable();
      // Sort by column 1 and then re-draw
      table
      .order( [ 0, 'desc' ] )
      .draw();
      // For Auto Refresh
      var Refresh = function(){
         $.ajax({  
            url:"http://127.0.0.1:8001/api/options/get",  
            method:"GET",  
            success:function(data){
               var table = '';
               for (var j = 0; j < data.length; j++)
               {
                  table += '<tr>'
                  table += '<td>' + data[j]['id'] + '</td>'
                  table += '<td>' + data[j]['title'] + '</td>'
                  table += '<td>' + data[j]['name'] + '</td>'
                  table += '<td>' + data[j]['description'] + '</td>'
                  table += '<td>' + data[j]['priority'] + '</td>'
                  table += '<td>' + data[j]['status'] + '</td>'
                  table += '<td>$nbsp;</td>'
                  table += '</tr>';
               }
               $('#kt_datatable tbody').append(table);
            }  
         });  
      };
</script>
@endpush