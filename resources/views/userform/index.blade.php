@extends('app')

@section('css')
	<link href="{{ asset('/css/vendor.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/formbuilder.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class='fb-main'></div>
@endsection

@section('js')
	<script src="{{ asset('/js/vendor.js') }}"></script>
	<script src="{{ asset('/js/formbuilder.js') }}"></script>

	<script>
		$(document).ready(function() {

			fb = new Formbuilder({
		        selector: '.fb-main',
		        bootstrapData: [
		          {
		            "label": "Do you have a website?",
		            "field_type": "website",
		            "required": false,
		            "field_options": {},
		            "cid": "c1"
		          },
		          {
		            "label": "Please enter your clearance number",
		            "field_type": "text",
		            "required": true,
		            "field_options": {},
		            "cid": "c6"
		          },
		          {
		            "label": "Security personnel #82?",
		            "field_type": "radio",
		            "required": true,
		            "field_options": {
		                "options": [{
		                    "label": "Yes",
		                    "checked": false
		                }, {
		                    "label": "No",
		                    "checked": false
		                }],
		                "include_other_option": true
		            },
		            "cid": "c10"
		          },
		          {
		            "label": "Medical history",
		            "field_type": "file",
		            "required": true,
		            "field_options": {},
		            "cid": "c14"
		          }
		        ]
		      });

		      fb.on('save', function(payload){
		        console.log(payload);
		      })

		});
	</script>
@endsection
