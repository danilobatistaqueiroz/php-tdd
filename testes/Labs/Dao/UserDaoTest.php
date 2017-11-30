<?php 

namespace Labs\Dao;

require "./vendor/autoload.php";

use PHPUnit\Framework\TestCase;

use Labs\Dao\UserDao;
use Labs\Model\User;
use PDO;
use Mockery;

/**
 * @group Labs
 */
class UserDaoTest extends TestCase
{
    private $conn;

    protected function setUp() {
        parent::setUp();
        $this->conn = new PDO("sqlite:test.db");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->createTable();
    }

    protected function tearDown() {
        parent::tearDown();
		$this->conn = null;
        unlink("test.db");
    }

    protected function createTable() {
		$sqlString = "CREATE TABLE IF NOT EXISTS tbUsers ";
		$sqlString .= " (id INTEGER PRIMARY KEY AUTOINCREMENT, login TEXT, name TEXT, email TEXT, pwd TEXT, type TEXT, status TINYINT(1) );";
        $this->conn->query($sqlString);
    }
	
    /**
     * @covers Labs\Dao\UserDao::addNew()
	 * @covers Labs\Dao\UserDao::byId()
     */
    public function testShouldAddNewUser() {
        $userDao = new UserDao($this->conn);
        $user = new User("danilo", "danilo batista de queiroz", "danilo.queiroz@gmail.com", "123", "admin");

        // Sobrescrevendo a conexão para continuar trabalhando
        // sobre a mesma já instanciada
        $conn = $userDao->addNew($user);

        // buscando pelo id para
        // ver se está igual o produto do cenário
        $saved = $userDao->byId($conn->lastInsertId());

		$this->assertEquals($saved[0]["login"], $user->getLogin());
        $this->assertEquals($saved[0]["name"], $user->getName());
        $this->assertEquals($saved[0]["email"], $user->getEmail());
		$this->assertEquals($saved[0]["type"], $user->getType());
        $this->assertEquals($saved[0]["status"], $user->getStatus());
    }
	
    /**
     * @covers Labs\Dao\UserDao::actives()
     */
    public function testShouldFilterActives() {
        $userDao = new UserDao($this->conn);
        $active = new User("danilo", "danilo batista de queiroz", "danilo.queiroz@gmail.com", "123", "admin");
        $inactive = new User("dell", "dell da silva", "dell.silva@gmail.com", "123", "user");
        $active->activate();
        $userDao->addNew($active);
        $userDao->addNew($inactive);
        $onlyActive = $userDao->actives();
        $this->assertEquals(1, count($onlyActive));
        $this->assertEquals("danilo", $onlyActive[0]["login"]);
		$this->assertEquals(2, count($userDao->listAll()));
    }
	
    /**
     * @covers Labs\Dao\UserDao::byId()
     */
    public function testById() {
        $conn = Mockery::mock('PDO');
		$conn->shouldReceive('prepare')->andReturn($conn);
        $conn->shouldReceive('execute')->andReturn($conn);
        $conn->shouldReceive('fetchAll')->andReturn(array('id' => 1));
        $userDao = new UserDao($conn);
        $this->assertNotNull($userDao->byId(1)); 
    }
	
}