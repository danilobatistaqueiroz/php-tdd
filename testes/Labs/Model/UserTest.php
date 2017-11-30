<?php

namespace Labs\Model;

use PHPUnit\Framework\TestCase;

/**
 * @group Labs
 */
class UserTest extends TestCase
{
	
    private $className = 'Labs\Model\User';
    private $class;

    protected function setUp()
    {
        parent::setUp();
        $this->class = new $this->className('danilo','Danilo Batista de Queiroz', 'danilo.queiroz@gmail.com', '123', 'Admin');
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
	
    /**
     * @covers Labs\Model\User::getStatus()
     */
    public function testGetStatus()
    {
        $this->assertInternalType('boolean', $this->class->getStatus());
        $this->assertEquals(false, $this->class->getStatus());
    }
    
    /**
     * @covers Labs\Model\User::getName()
     */
    public function testGetName()
    {
        $this->assertNotNull($this->class->getName());
        $this->assertInternalType('string', $this->class->getName());
        $this->assertEquals('Danilo Batista de Queiroz', $this->class->getName());
    }

    /**
     * @covers Labs\Model\User::deactivate()
     * @covers Labs\Model\User::getStatus()
     */
    public function testDeactivate()
    {
        $this->class->deactivate();
        $this->assertFalse($this->class->getStatus());
    }

}
