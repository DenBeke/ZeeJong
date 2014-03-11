<?php

namespace UnitTest;




class Equals extends UnitTest {

	public function Zero() {
		$this->REQUIRE_EQUAL(0,0);
	}

	public function One() {
		$this->REQUIRE_EQUAL(0,1);
		$this->REQUIRE_EQUAL(1,-1);
	}
	
	
	public function Two() {
		$this->REQUIRE_EQUAL(0,0);
	}
	
	public function Three() {
		$this->REQUIRE_EQUAL(0,0);
	}
	
	public function Four() {
		$this->REQUIRE_EQUAL(0,0);
	}
	
	public function Five() {
		$this->REQUIRE_EQUAL(0,0);
	}
	

}

?>