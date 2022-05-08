@extends('layouts.app')
@section('content')    
    <!DOCTYPE html>
    <html>
   <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Latest compiled and minified CSS -->
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</head>
    <body>
   <!-- Button trigger modal -->
   
<button type="button" id="popup"  class="btn btn-primary popup" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <h5 class="" id="err_modal"></h5>
        <br>
        
      </div>
      <div class="modal-body">
       <input class="form-control form-control-lg name" type="text" placeholder="Enter Name" name="name">
       <input class="form-control form-control-lg email" type="text" placeholder="Enter Email" name="email">
       <input class="form-control form-control-lg phone" type="text" placeholder="Enter Phone" name="phone">
       <input class="form-control form-control-lg course" type="text" placeholder="Enter Course" name="course">

      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary " id="">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- edit modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Modal title</h5>
        <h5 class="" id="err_modal"></h5>
        <br>
        
      </div>
      <div class="modal-body">
        <input class="form-control form-control-lg dataId" id="dataId" type="text"  name="dataId">
       <input class="form-control form-control-lg editname" id="editname" type="text" name="editname">
       <input class="form-control form-control-lg editemail" id="editemail" type="text"  name="editemail">
       <input class="form-control form-control-lg editphone" id="editphone" type="text" name="editphone">
       <input class="form-control form-control-lg editcourse" id="editcourse" type="text"  name="editcourse">

      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary " id="updatestudent">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- edit modal end -->
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"></th>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>
<!--  -->

<script type="text/javascript">
  $(document).on('click','#popup',function(e)
      {
        e.preventDefault();
         $('#exampleModal').modal('show');
      });

    $(document).ready(function(){
     // alert('hello');
      
        fetchFunction();
        function fetchFunction()
        {
            $.ajax({

                type: "get",
                url: "fetchdata",
                dataType: "json",
                success: function(response)
                {
                    // console.log(response);
                    $('tbody').html('');
                    $.each(response.student, function(key,collec){
                      $('tbody').append(' <tr>\
                      <th scope="row">'+collec.id+'</th>\
                      <td>'+collec.name+'</td>\
                      <td>'+collec.email+'</td>\
                      <td>'+collec.phone+'</td>\
                      <td>'+collec.course+'</td>\
    <td><button type="button" id="edit_student" value="'+collec.id+'" class="btn btn-primary btn-sm edit_student" name="'+collec.id+'">Edit</button></td>\
    <td><button type="button" id="delete_student" value="'+collec.id+'" class="btn btn-primary btn-sm delete_student" name="">Delete</button></td>\
                    </tr>');
                    });
                }
            });
        }
        $(document).on('click','.delete_student', function(e){
          e.preventDefault();
          // alert('working');
          var stu_id = $(this).val();
          // alert(stu_id);
          $.ajax({
               type: 'get',
               url: '/deleteStudent/'+stu_id,
               dataType: 'json',
               success: function(response)
               {
               fetchFunction();
               }
          });
        });
        $(document).on('click','#updatestudent',function(e){
          e.preventDefault();
          var stu_id = $('#dataId').val();
          var data = {
            "_token": "{{ csrf_token() }}",
          'name': $('#editname').val(),
          'email': $('#editemail').val(),
          'phone': $('#editphone').val(),
          'course': $('#editcourse').val(),

          }
          $.ajax({
            type: 'put',
               url: '/updateStudent/'+stu_id,
               data: data,
               dataType: 'json',
               success: function(response)
               {
                 if(response.success==200)
                {

                     fetchFunction();
                }
                  
                //console.log(response);
               }
          });

        });
    
          $(document).on('click','.edit_student',function(e) {
            
            var stu_id = $(this).val();
            // var idd = JSON.parse(stu_id);
             // alert(stu_id);
            //console.log(stu_id);
            $('#editModal').modal('show');
            $.ajax({
              type: 'get',
               url: '/editStudent/'+stu_id,
               dataType: 'json',
               success: function (response)
               {
                console.log(response);
                if(response.status==200)
                {
                  
                  $('#dataId').val(response.data.id);
                  $('#editname').val(response.data.name);
                  $('#editemail').val(response.data.email);
                  $('#editphone').val(response.data.phone);
                  $('#editcourse').val(response.data.course);
                }
               }
            });
         });

        $(document).click('#add_student_data',function(){
            //alert('demo');
          // e.preventDefault();
           var data = {
             "_token": "{{ csrf_token() }}",
            'name':$('.name').val(),
            'email':$('.email').val(),
            'phone':$('.phone').val(),
            'course':$('.course').val(),
           }
           // console.log(data);
           $.ajax({
            type: "post",
            url: "saveData",
            data: data,
            dataType: "json",
            success: function(response) {
                // console.log(response)
                if(response.status==400)
                {
                    
                        $('#err_modal').html('');
                        $('#err_modal').addClass('alert alert-danger');
                        $.each(response.errors , function (key , err_key){
                        $('#err_modal').append('<li>'+err_key+'</li>');
                    });
                }
                if(response.status==200)
                {

                     fetchFunction();
                }
            }
           });
            
            
        });
    });
</script>
    </body>
    </html>
@endsection

@section('scripts')