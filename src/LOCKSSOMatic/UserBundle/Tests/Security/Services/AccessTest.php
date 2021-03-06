<?php

/* 
 * The MIT License
 *
 * Copyright 2014. Michael Joyce <ubermichael@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace LOCKSSOMatic\UserBundle\Tests\Security\Services;

use Doctrine\ORM\EntityManager;
use LOCKSSOMatic\UserBundle\Security\Serivces\Access;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use LOCKSSOMatic\UserBundle\Entity\User;

// http://stackoverflow.com/questions/8455776
// http://stackoverflow.com/questions/9621016/

class AccessTest extends WebTestCase
{

    /**
     * @var EntityManager
     */
    private $em;
    
    /**
     * @var Logger 
     */
    private $logger;
    
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct()
    {
        parent::__construct();
        
        static::bootKernel();
        $this->container = static::$kernel->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
        $this->logger = $this->container->get('logger');
    }
    
    public function testServiceDefinition()
    {
        $this->assertEquals(
            'LOCKSSOMatic\\UserBundle\\Security\\Services\\Access',
            get_class($this->container->get('lom.access'))
        );
    }

    /**
     * @expectedException Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function testRoleCheckFail()
    {
        // testing roles with fake users is totally fine.
        $securityContext = $this->container->get('security.context');
        $securityContext->setToken(
            new UsernamePasswordToken('testuser', null, 'main', array('ROLE_USER'))
        );
        /** @var Access */
        $am = $this->container->get('lom.access');
        $am->checkAccess('ROLE_PHONY');
    }

    public function testRoleCheckSuccess()
    {
        // testing roles with fake users is totally fine.
        $this->container->get('security.context')->setToken(
            new UsernamePasswordToken('testuser', null, 'main', array('ROLE_ADMIN'))
        );
        $am = $this->container->get('lom.access');
        $am->checkAccess('ROLE_ADMIN');
    }

    public function testHasAccess()
    {
        $user = new User();
        $user->addRole('ROLE_LOMADMIN');
        $user->addRole('ROLE_USER');

        $this->container->get('security.context')->setToken(
            new UsernamePasswordToken($user, null, 'main', $user->getRoles())
        );
        $am = $this->container->get('lom.access');
        
        // roles
        $this->assertFalse($am->hasAccess('ROLE_ADMIN'));
        $this->assertTrue($am->hasAccess('ROLE_LOMADMIN'));
        $this->assertTrue($am->hasAccess('ROLE_USER'));
    }

    public function testHasAccessWithUser()
    {
        $user = new User();
        $user->addRole('ROLE_LOMADMIN');
        $user->addRole('ROLE_USER');

        $am = $this->container->get('lom.access');
        
        $this->assertFalse($am->hasAccess('ROLE_ADMIN', null, $user));
        $this->assertTrue($am->hasAccess('ROLE_LOMADMIN', null, $user));
        $this->assertTrue($am->hasAccess('ROLE_USER', null, $user));
    }
    
    public function testGrantRevokeRole()
    {
        $user = new User();
        $user->addRole('ROLE_LOMADMIN');
        $user->addRole('ROLE_USER');

        $am = $this->container->get('lom.access');
        
        $this->assertTrue($user->hasRole('ROLE_LOMADMIN'));
        $am->revokeRole('ROLE_LOMADMIN', $user);
        
        $this->assertFalse($user->hasRole('ROLE_LOMADMIN'));
        $am->grantRole('ROLE_LOMADMIN', $user);
        $this->assertTrue($user->hasRole('ROLE_LOMADMIN'));
    }
}
