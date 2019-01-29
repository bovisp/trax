@extends('layouts.app')

@section('content')

	<ul>
		@forelse ($categories as $category)
			<li>
				{{ $category->name }}
			</li>
		@empty
			<li>
				There are currently no categories
			</li>
		@endforelse
	</ul>
@endsection