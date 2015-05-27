@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div style="margin-bottom: 20px;">
				<button type="button" class="btn btn-success" onclick="location='{{ action('UserController@create') }}'">Create user</button>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Users list</div>
				<div class="panel-body">
					<table class="table table-bordered table-striped">
						@foreach ($users as $user)
							<tr>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{* $user->role->name *}</td>
								<td width="200" align="center">
									<button type="button" class="btn btn-primary" onclick="location='{{ action('UserController@edit', ['userId' => $user->id]) }}'">Edit</button>
									<button type="button" class="btn btn-danger remove-user" data-user-id="{{ $user->id }}" data-action-url="{{ action('UserController@destroy', ['userId' => $user->id]) }}">Remove</button>
								</td>
							</tr>
						@endforeach
					</table>

				</div>
			</div>
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
        <p>Are you sure you want to remove user?&hellip;</p>
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
    	$(".remove-user").on('click', function() {
    		var userId = $(this).data('userId'),
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
