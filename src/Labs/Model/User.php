<?php

namespace Labs\Model;

class User
{
	private $id;
	public $login;
    public $name;
	public $email;
    public $pwd;
    public $type;
    private $status = false;

    /**
     * @codeCoverageIgnore
     * @param type $login
     * @param type $name
     * @param type $email
	 * @param type $pwd
	 * @param type $type
	 * @param type $status
     */
    public function __construct($login, $name, $email, $pwd, $type)
    {
        $this->login = $login;
        $this->name = $name;
        $this->email = $email;
		$this->pwd = $pwd;
		$this->type = $type;
    }
	
    function getName()
    {
        return $this->name;
    }

    function getLogin()
    {
        return $this->login;
    }

    function getEmail()
    {
        return $this->email;
    }

    public function getPwd()
    {
        return $this->pwd;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
	
    public function getType()
    {
        return $this->type;
    }
    
    public function activate()
    {
        $this->status = true;
    }
	
    public function deactivate()
    {
        $this->status = false;
    }

}
