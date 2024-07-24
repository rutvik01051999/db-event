@extends('layouts.admin')
@section('content')
<style>
    td.editor-edit button,
td.editor-delete button {
    background: transparent;
    border: none;
    color: inherit;
}
</style>
<br>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Quetion List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Event name</th>
                                <th>Image</th>
                                <th>Start Date</th>
                                <th>Close Date</th>
                                <th>Quation list</th>
                                <th>Event edit</th>
                                <th>Event delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                <div class="model-append">

                </div>
              </div>
        </div>
    </section></div>
    @section('content-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script> 
        var url = '{{ env('APP_URL') }}';
        console.log(name)


          var table = $('#example2').DataTable({

              processing: true,
              serverSide: true,
              order: [[1, 'asc']],
              page:2,

            //   "pageLength": 2,


              'aoColumnDefs': [{
        'bSortable': false,
        'aTargets': [-1,-2] /* 1st one, start by the right */
    }],
              
              ajax: "{{ route('event.list') }}",
              columns: [
                 {data: 'id', name: 'id'},
                  {data: 'name', name: 'name'},
                //   {data: 'image', name: 'image'},
                
                { data: "image" ,
              "render": function ( data) {
              return '<img width="30px" src="'+url+'/storage/images/'+data+'">';}
            },
                  {data: 'start_date', name: 'start_date'},
                  {data: 'close_date', name: 'close_date'},
        // {
        //     data: "id",
        //     className: 'dt-center editor-edit',
        //     defaultContent: '<button data-id='+data+'><i class="fa fa-edit"/></button>',
        // },
        { 
            data: "id" ,
              "render": function ( data) {
              return '<a class="dt-center" href="question/list/'+data+'"><i class="fa fa-eye"/></a>';}
        },
        { 
            data: "id" ,
              "render": function ( data) {
              return '<button class="dt-center editor-edit" data-id='+data+'><i class="fa fa-edit"/></button>';}
        },
        { 
            data: "id" ,
              "render": function ( data) {
              return '<button class="dt-center editor-delete" data-id='+data+'><i class="fa fa-trash"/></button>';}
        },
        // {
        //     data: "id",
        //     className: 'dt-center editor-delete',
        //     defaultContent: '<button><i class="fa fa-trash"/></button>',
        // }
                  

              ]
          });

         

          table
    .on('order.dt search.dt', function () {
        let i = 1;
 
        table
            .cells(null, 0, { search: 'applied', order: 'applied' })
            .every(function (cell) {
                this.data(i++);
            });
    })
    .draw();


//edit event
$(document).ready(function(){

$(document).on( 'click', '.editor-edit', function () { 
    var id = $(this).attr("data-id");
    $.ajax({
        // headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // },
        url : "{{ url('event/edit') }}",
        data : {
            'id' : id,
            "_token": "{{ csrf_token() }}",
        },
        
        type : 'POST',
        dataType : 'json',
        success : function(result){

            console.log("===== " + result + " =====");
            $('.model-append').html(result.html)
            $('#eventeditmodel').modal('show');


        }
    });
});
});

//datepicker
$( function() {
    $("body").delegate(".datepicker", "focusin", function(){
        $(this).datepicker();
    });
    $(".datepicker").datepicker({
  minDate: 0,
   dateFormat: 'yy-mm-dd',
  onSelect: function(date) {
    console.log(date)
  }
});  } );



$(document).on( 'click', '.event-update', function () { 
    var id = $(this).attr("data-id");
    var formData = new FormData(); // Currently empty
    var _token = $("#_token").val().trim();
    console.log(_token);

    formData.append('event_title', $("#event_title").val());
    $.ajax({
        url : "{{ url('event/update') }}",
        data : {
            "_token": "{{ csrf_token() }}",
        },
        
        type : 'POST',
        dataType : 'json',
        cache : false,
  processData: false,
  contentType: false,
        success : function(result){

            console.log("===== " + result + " =====");
            $('.model-append').html(result.html)
            $('#eventeditmodel').modal('show');


        }
    });
});
      </script>
    @endsection
@endsection
