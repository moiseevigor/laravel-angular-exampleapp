@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@foreach ($forms as $form)
			<div class="panel panel-default">
				<div class="panel-heading">
					{{ $form->name }}
				</div>
				<div class="panel-body">
					<div style="float: right;">
						<button type="button" class="btn btn-success" onclick="location='{{ action('OrderController@create', ['formId' => $form->id]) }}'">Create order</button>
					</div>
					<table class="table table-bordered table-striped">
						@forelse ($orders as $order)
							@if( $order->form_id == $form->id)
							<tr>
								<td>{{ $order->name }}</td>
								<td>{{ $order->user->name }}</td>
								<td width="200" align="center">
									<button type="button" class="btn btn-primary" onclick="location='{{ action('OrderController@edit', ['formId' => $form->id, 'orderId' => $order->id]) }}'">Edit</button>
									<button type="button" class="btn btn-danger remove-order" data-user-order-id="{{ $order->id }}" data-action-url="{{ action('OrderController@destroy', ['formId' => $form->id, 'orderId' => $order->id]) }}">Remove</button>
								</td>
							</tr>
							@endif
						@empty No orders registered yet!
						@endforelse
					</table>

				</div>
			</div>
			@endforeach

		</div>
	</div>
</div>

<div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirm</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to remove order?&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger">Remove</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('js')
<script>
	$(document).ready(function() {
    	$(".remove-order").on('click', function() {
    		var orderId = $(this).data('orderId'),
    			actionUrl = $(this).data('actionUrl');
    	
	    	$('.modal').modal({ 
	    		backdrop: 'static', 
	    		keyboard: false 
	    	});

	    	$(".modal .btn-danger").on('click', function() {
	    		$.post(actionUrl, {
	    			_method: 'DELETE',
	    			_token: '{{ csrf_token() }}'
	    		}, function() {
	    			location.reload(); 
	    		});
	    	});
    	});
	});
</script>
@endsection
