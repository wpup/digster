<?php

namespace Hello;

function hi() {
	echo 'hi ' . name();
	
	echo strip_tags('<p>hello</p>');
}

function name() {
	return 'Fredrik';
}

\Hello\hi();