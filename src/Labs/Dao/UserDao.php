<?php 

namespace Labs\Dao;

use Labs\Model\User;
use PDO;

class UserDao {

    private $conn;
	
    /**
     * @codeCoverageIgnore
     * @param PDO $conn
     */
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }
	
    public function byId($id) {
        $statement = $this->conn->prepare("select * from `tbUsers` where id = :id", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $statement->execute(array(':id' => $id));
        return $statement->fetchAll();
    }
	
    public function actives() {
        $sqlString = "SELECT * FROM `tbUsers` WHERE status=1";
        $result = $this->conn->query($sqlString);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }
	
    public function listAll() {
        $sqlString = "SELECT * FROM `tbUsers`";
        $result = $this->conn->query($sqlString);
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }
	
    public function addNew(User $user) {
		$login = $user->getLogin();
		$name = $user->getName();
		$email = $user->getEmail();
		$pwd = $user->getPwd();
		$type = $user->getType();
		$status = $user->getStatus();
        $sqlString = "INSERT INTO `tbUsers` (login, name, email, pwd, type, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sqlString);
        $stmt->bindParam(1, $login);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $email);
		$stmt->bindParam(4, $pwd);
		$stmt->bindParam(5, $type);
		$stmt->bindParam(6, $status);
		$stmt->execute();
        return $this->conn;
    }
}