@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Edit user info</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ action('UserController@update', ['userId' => $user->id]) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="userId" value="{{ $user->id }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Role</label>
							<div class="col-md-6">
								<select name="role_id" class="form-control">
								@foreach (\App\Role::all() as $role)
									<option value="{{ $role->id }}" @if($user->role_id == $role->id)selected @endif @if($role->id == 1)  @endif>{{ $role->display_name }}</option>
								@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="@if(old('name') == ''){{ $user->name }}@else {{ old('name') }}@endif">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="@if(old('email') == ''){{ $user->email }}@else{{ old('email') }}@endif">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Save
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
