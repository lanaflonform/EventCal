@extends('layout')

@section('contenu')
	<h2>A propos</h2>
	
	<p>Ce site...</p>
	
	<h2>Contact</h2>
	
	@include('tools.errors')
	
    {{ Form::open(array('url' => 'about','method' => 'post')) }}    
        {{ Form::label('email', 'Votre e-mail : ') }}
        {{ Form::email('email', $email) }}
        
        {{ Form::label('title', 'Votre titre : ') }}
        {{ Form::text('title') }}
        
        {{ Form::label('msg', 'Votre message : ') }}
        {{ Form::textarea('msg') }}
        
        {{ Form::submit('Envoyer') }}
	{{ Form::close() }}
		
@stop
