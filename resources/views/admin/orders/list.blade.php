@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    {{ $page_head }}
                </div>

                <div class="card-body">
                    
                    @if (Session::has('_error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('_error') }}
                        </div>
                    @endif
                    @if (Session::has('_success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('_success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped" id="orders_list">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Order #</th>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>Total Product</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</div>

{{-- update status modal --}}

<div class="modal fade" id="updateOrderStatusModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Change Status</h5>
            </div>
            <form action="javascript:void(0)" method="POST" style="display: inline" id="update_order_status">

            <div class="modal-body">

                <input type="hidden" name="order_id" value="0">
                <div class="row">
                    <div class="col-sm-12">
                                
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">select</option>
                                <option value="accept">Accept</option>
                                <option value="reject">Reject</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close_order_status_modal" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('script')



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">


    $(function () {
      
      var table = $('#orders_list').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin:orders') }}",
          columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_no',
                    name: 'order_no'
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'contact_no',
                    name: 'contact_no'
                },
                {
                    data: 'total_products',
                    name: 'total_products',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'total_price',
                    name: 'total_price'
                },
                {
                    data: 'order_status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
          ]
      });
      
    });

    $(document).on('click','.update_status',function(){

        // Get the data-id attribute of the clicked button
        let order_id = $(this).attr('data-id');
    
        $('input[name=order_id]').val(order_id)

        // Show the confirmation modal
        $('#updateOrderStatusModal').modal('show');


    })

    $(document).on('click','#close_order_status_modal',function(){
    // hide the confirmation modal
    $('#updateOrderStatusModal').modal('hide');
    })

    // update status
    $(document).on('submit','#update_order_status',function(e){

        e.preventDefault()
        
        let data = $(this).serialize()

        $.ajax({
            type : 'post',
            url : "{{ route('admin:update_order_status')}}",
            data: data,
            dataType : 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(response)
            {
                console.log(response);

                window.location.href = response.redirect
            }
        })
    })
</script>
@endsection
