@extends('layouts.app')

@section('content')
	<ul>
		@forelse ($roles as $role)
			<li>
				{{ $role->name }}
			</li>
		@empty
			<li>
				No roles added yet
			</li>
		@endforelse
	</ul>
@endsection