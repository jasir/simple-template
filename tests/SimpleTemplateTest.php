<?php

namespace jasir;

require_once __DIR__ . '/../src/SimpleTemplate.php';

class SimpleTemplateTest extends \PHPUnit_Framework_TestCase
{

	public function test_Replacing()
	{
		$variables = array('bar' => 'hello', 'foo' => 'world', 'user.name' => 'Jasir');
		$this->assertEquals(
			'...hello world, Jasir! {this.is.not.replaced}',
			SimpleTemplate::replaceVariables(
				'...{bar} {foo}, {user.name}! {this.is.not.replaced}',
				$variables
			)
		);
	}

	public function test_replacing_using_callback() {
		$replace = function($replace) {
			return strtoupper($replace);
		};

		$this->assertEquals(
			'...{BAR} {FOO}, {USER.NAME}!',
			SimpleTemplate::replaceVariables(
				'...{bar} {foo}, {user.name}!',
				$replace
			)
		);
	}


	public function test_Replacing_with_own_marks()
	{
		$variables = array('bar' => 'hello', 'foo' => 'world', 'user.name' => 'Jasir', 'font-size' => '12px');
		$this->assertEquals(
			'...hello world, Jasir! {%this.is.not.replaced%}, font-size: 12px',
			SimpleTemplate::replaceVariables(
				'...{%bar%} {%foo%}, {%user.name%}! {%this.is.not.replaced%}, font-size: {%font-size%}',
				$variables,
				'{%', '%}'
			)
		);
	}


}