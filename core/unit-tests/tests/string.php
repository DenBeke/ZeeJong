<?php

namespace UnitTest;

class String extends UnitTest {


	public function Word() {
		$this->REQUIRE_EQUAL('word', 'word');
	}

	public function Sentence() {
		$var1 = 'hello world!';
		$var2 = 'hello world!';
		$this->REQUIRE_EQUAL($var1, $var2);
	}
	
	public function SentenceWithMoreThanTwoWords() {
		$this->REQUIRE_EQUAL('this is a sentence', 'which will not be equal to this part');
	}
	
	public function AnotherSentence() {
		$this->REQUIRE_EQUAL('hello world!', 'hello world!');
	}
	
	public function LoremIpsum() {
		$this->REQUIRE_EQUAL('hello world!', 'hello world!');
	}
	
	public function DolerSit() {
		$this->REQUIRE_EQUAL('hello world!', 'hello world!');
	}

}

?>