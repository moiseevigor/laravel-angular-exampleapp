@extends('app')

@section('css')
	<link href="{{ asset('/css/vendor.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/formbuilder.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Form <b>{{ $form->name }}</b></div>
				<div class="panel-body">
					<div class='fb-main'></div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')
	<script src="{{ asset('/js/vendor.min.js') }}"></script>
	<script src="{{ asset('/js/formbuilder.js') }}"></script>

	<script>
		$(document).ready(function() {

			fb = new Formbuilder({
		        selector: '.fb-main',
		        bootstrapData: @if($form->form_json == '') [] @else {!! $form->form_json !!} @endif
		      });

		      fb.on('save', function(payload){
	    		$.post("{{ action('UserFormController@update', ['formId' => $form->id]) }}", {
	    			_method: 'POST',
	    			_token: '{{ csrf_token() }}',
	    			form_json: payload
	    		});

		      })

		});
	</script>
@endsection
