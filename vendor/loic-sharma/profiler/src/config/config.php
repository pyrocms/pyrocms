<?php

return array(
	
	/*
	| -----------------------------------------------------------------------------
	| Enable profiler
	| -----------------------------------------------------------------------------
	|
	| By default, enabled is set to null. This tells the profiler to use the
	| application's debug configuration. However, if enabled is set to true the
	| profiler will be displayed even if the application's debugging is disabled.
	| Likewise, setting enabled to false will hide the profiler even if debugging
	| is on.
	|
	*/

	'enabled' => null,

	/*
	| -----------------------------------------------------------------------------
	| Password for enabling profiler
	| -----------------------------------------------------------------------------
	|
	| This password is required to enable the profiler on selected environments.
	| 
	| You should change it after installation.
	|
	*/

	'password' => false,

	/*
	| -----------------------------------------------------------------------------
	| Require password on selected environments
	| -----------------------------------------------------------------------------
	|
	| The profiler can be enabled by running directing your browser to:
	| /_profiler/enable/{password}
	|
	| The following environments will require a password to be given.
	|
	*/

	'require_password' => array('production', 'prod'),

);
