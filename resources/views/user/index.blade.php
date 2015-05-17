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
								<td>{{ $user->role }}</td>
								<td width="200" align="center">
									<button type="button" class="btn btn-primary" onclick="location='{{ action('UserController@edit', ['userId' => $user->id]) }}'">Edit</button>
									<button type="button" class="btn btn-danger" onclick="location='{{ action('UserController@destroy', ['userId' => $user->id]) }}'">Remove</button>
								</td>
							</tr>
						@endforeach
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
