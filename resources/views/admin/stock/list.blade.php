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
                    <span>
                        <a href="{{ route('admin:remove_stock') }}" class="text-danger" style="float: right;">Remove Stock</a>
                        <a href="{{ route('admin:add_stock') }}" style="float: right;padding-right:10px;">Add Stock</a>
                    </span>
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
                        <table class="table table-striped" id="stock_list">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Qty</th>
                                {{-- <th>Actions</th> --}}
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

{{-- delete modal --}}

<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="javascript:void(0)" method="POST" style="display: inline" id="delete_product_modal">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
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
      
      var table = $('#stock_list').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin:stocks') }}",
          columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'product.title',
                    name: 'product.title',
                    render: function (data, type, row) {
                        
                    if (data === null) {
                        return 'null';
                    }
                    return data;
                    }
                },
                {
                    data: 'type',
                    name: 'type',
                    render: function (data, type, row) {
                        
                    if (data === null) {
                        return 'null';
                    }
                    return data;
                    }
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     searchable: false
                // },
          ]
      });
      
    });

    $(document).on('click','.delete_row',function(){

        
         // Get the data-id attribute of the clicked button
    let product_id = $(this).attr('data-id');
    
    // Set the action URL for the delete form
    let action_url = "{{ url('admin/delete_product') }}/"+product_id
    // Update the action attribute of the delete form
    $('#delete_product_modal').attr('action', action_url);
    
    // Show the confirmation modal
    $('#deleteProductModal').modal('show');


    })

</script>
@endsection
