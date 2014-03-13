<?php 

namespace UnitTest;

require_once(dirname(__FILE__) . '/../../../database.php');
require_once(dirname(__FILE__) . '/../../../config.php');
require_once(dirname(__FILE__) . '/../../unit-test.php');

class BasicCountryTest extends UnitTest {

	private $db;
	private $countryName1;
	private $countryName2;
	private $countryName3;
	private $countryId1;
	private $countryId2;
	private $countryId3;



	public function __construct() {

		$this->countryName1 = "Germanolia";
		$this->countryName2 = "Francibium";
		$this->countryName3 = "Molta";
		$db = new \Database(DB_HOST, DB_USER, DB_PASS, "TestDB");
		$this->db = $db;

		$this->countryId1 = $this->db->addCountry($this->countryName1);
		$this->countryId2 = $this->db->addCountry($this->countryName2);
		$this->countryId3 = $this->db->addCountry($this->countryName3);
	}

	public function basicGetters() {

		$this->REQUIRE_EQUAL($this->db->getCountryById($this->countryId1)->getName(), $this->countryName1);
		$this->REQUIRE_EQUAL($this->db->getCountryById($this->countryId2)->getName(), $this->countryName2);
		$this->REQUIRE_EQUAL($this->db->getCountryById($this->countryId3)->getName(), $this->countryName3);
		$this->REQUIRE_NOTEQUAL($this->db->getCountryById($this->countryId1)->getName(), $this->countryName2);
		$this->REQUIRE_NOTEQUAL($this->db->getCountryById($this->countryId2)->getName(), $this->countryName3);
		$this->REQUIRE_NOTEQUAL($this->db->getCountryById($this->countryId3)->getName(), $this->countryName1);
	}

	public function checkDuplicates() {

		$this->REQUIRE_EQUAL($this->db->addCountry($this->countryName1), $this->countryId1);
		$this->REQUIRE_EQUAL($this->db->addCountry($this->countryName2), $this->countryId2);
		$this->REQUIRE_EQUAL($this->db->addCountry($this->countryName3), $this->countryId3);
	}

}


class BasicPlayerTest extends UnitTest {

	private $db;
	private $id1;
	private $firstName1;
	private $lastName1;
	private $countryId1;
	private $dateOfBirth1;
	private $height1;
	private $weight1;
	private $position1;
	private $imageUrl1;
	private $id2;
	private $firstName2;
	private $lastName2;
	private $countryId2;
	private $dateOfBirth2;
	private $height2;
	private $weight2;
	private $position2;
	private $imageUrl2;
	private $id3;
	private $firstName3;
	private $lastName3;
	private $countryId3;
	private $dateOfBirth3;
	private $height3;
	private $weight3;
	private $position3;
	private $imageUrl3;

	public function __construct() {

		$this->firstName1 = "Timo";
		$this->lastName1 = "Truyts";
		$this->countryId1 = 1;
		$this->dateOfBirth1 = 124;
		$this->height1 = 168;
		$this->weight1 = 70;
		$this->position1 = "Defender";
		$this->firstName2 = "Mathias";
		$this->lastName2 = "Beke";
		$this->countryId2 = 2;
		$this->dateOfBirth2 = 125;
		$this->height2 = 180;
		$this->weight2 = 89;
		$this->position2 = "Attacker";
		$this->firstName3 = "Bruno";
		$this->lastName3 = "VDV";
		$this->countryId3 = 3;
		$this->dateOfBirth3 = 183;
		$this->height3 = 182;
		$this->weight3 = 43;
		$this->position3 = "Playmaker";

		$db = new \Database(DB_HOST, DB_USER, DB_PASS, "TestDB");
		$this->db = &$db;

		$this->id1 = $this->db->addPlayer($this->firstName1, $this->lastName1, $this->countryId1, $this->dateOfBirth1, $this->height1, $this->weight1, $this->position1);
		$this->id2 = $this->db->addPlayer($this->firstName2, $this->lastName2, $this->countryId2, $this->dateOfBirth2, $this->height2, $this->weight2, $this->position2);
		$this->id3 = $this->db->addPlayer($this->firstName3, $this->lastName3, $this->countryId3, $this->dateOfBirth3, $this->height3, $this->weight3, $this->position3);

	}

	public function basicGetters() {

		//Checking first names
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id1)->getFirstName(), $this->firstName1);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id2)->getFirstName(), $this->firstName2);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id3)->getFirstName(), $this->firstName3);

		//Checking last names
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id1)->getLastName(), $this->lastName1);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id2)->getLastName(), $this->lastName2);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id3)->getLastName(), $this->lastName3);

		//Checking countries
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id1)->getCountry()->getId(), $this->countryId1);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id2)->getCountry()->getId(), $this->countryId2);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id3)->getCountry()->getId(), $this->countryId3);

		//Checking date of birth
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id1)->getDateOfBirth(), $this->dateOfBirth1);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id2)->getDateOfBirth(), $this->dateOfBirth2);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id3)->getDateOfBirth(), $this->dateOfBirth3);

		//Checking height
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id1)->getHeight(), $this->height1);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id2)->getHeight(), $this->height2);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id3)->getHeight(), $this->height3);

		//Checking weight
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id1)->getWeight(), $this->weight1);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id2)->getWeight(), $this->weight2);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id3)->getWeight(), $this->weight3);

		//Checking position
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id1)->getPosition(), $this->position1);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id2)->getPosition(), $this->position2);
		$this->REQUIRE_EQUAL($this->db->getPlayerById($this->id3)->getPosition(), $this->position3);		
	}

	public function checkDuplicates() {

		$this->REQUIRE_EQUAL($this->db->addPlayer($this->firstName1, $this->lastName1, $this->countryId1, $this->dateOfBirth1, $this->height1, $this->weight1, $this->position1), $this->id1);
		$this->REQUIRE_EQUAL($this->db->addPlayer($this->firstName2, $this->lastName2, $this->countryId2, $this->dateOfBirth2, $this->height2, $this->weight2, $this->position2), $this->id2);
		$this->REQUIRE_EQUAL($this->db->addPlayer($this->firstName3, $this->lastName3, $this->countryId3, $this->dateOfBirth3, $this->height3, $this->weight3, $this->position3), $this->id3);		
	}

}

class BasicTeamTest extends UnitTest {

	private $db;
	private $id1;
	private	$name1;
	private $country1;
	private $countryId1;
	private $id2;
	private	$name2;
	private $country2;
	private $countryId2;
	private $id3;
	private	$name3;
	private $country3;
	private $countryId3;

	public function __construct() {

		$this->name1 = "De Timos";
		$this->country1 = "Germanolia";
		$this->countryId1 = 1;
		$this->name2 = "De Mathiassen";
		$this->country2 = "Francibium";
		$this->countryId2 = 2;
		$this->name3 = "Funkyzeit mit Bruno";
		$this->country3 = "Molta";		
		$this->countryId3 = 3;
	
		$db = new \Database(DB_HOST, DB_USER, DB_PASS, "TestDB");
		$this->db = &$db;

		$this->id1 = $this->db->addTeam($this->name1, $this->countryId1);
		$this->id2 = $this->db->addTeam($this->name2, $this->countryId2);
		$this->id3 = $this->db->addTeam($this->name3, $this->countryId3);

	}

	public function basicGetters() {

		//Checking names
		$this->REQUIRE_EQUAL($this->db->getTeamById($this->id1)->getName(), $this->name1);
		$this->REQUIRE_EQUAL($this->db->getTeamById($this->id2)->getName(), $this->name2);
		$this->REQUIRE_EQUAL($this->db->getTeamById($this->id3)->getName(), $this->name3);

		//Checking countries
		$this->REQUIRE_EQUAL($this->db->getTeamById($this->id1)->getCountry()->getName(), $this->country1);
		$this->REQUIRE_EQUAL($this->db->getTeamById($this->id2)->getCountry()->getName(), $this->country2);
		$this->REQUIRE_EQUAL($this->db->getTeamById($this->id3)->getCountry()->getName(), $this->country3);		
	}

	public function checkDuplicates() {

		$this->REQUIRE_EQUAL($this->db->addTeam($this->name1, $this->countryId1), $this->id1);
		$this->REQUIRE_EQUAL($this->db->addTeam($this->name2, $this->countryId2), $this->id2);
		$this->REQUIRE_EQUAL($this->db->addTeam($this->name3, $this->countryId3), $this->id3);		
	}	
}

?>