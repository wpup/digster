<?php

function fn_hello( $name ) {
	return 'Hello, ' . $name . '!';
}

add_filter( 'digster/filters', function ( $filters ) {
	return array_merge( $filters, [
		'hej' => function ( $text ) {
			return str_replace( 'Hello', 'Hej', $text );
		}
	] );
} );

add_filter( 'digster/functions', function ( $functions ) {
	return array_merge( $functions, [
		'uniqid' => 'uniqid'
	] );
} );
