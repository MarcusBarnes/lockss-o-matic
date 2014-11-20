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

namespace LOCKSSOMatic\UserBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use LOCKSSOMatic\UserBundle\Entity\User;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class AdminUserControllerAccessTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    private static $em;
    
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
        $this->logger = $this->container->get('logger');
        self::$em = $this->container->get('doctrine')->getManager();
    }
    
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        $user = new User();
        $user->setUsername('user@example.com');
        $user->setEmail('user@example.com');
        $user->setFullname('Test User');
        $user->setInstitution('Test Institution');
        $user->setEnabled(true);
        $user->setPlainPassword('supersecret');
        self::$em->persist($user);
        
        $admin = new User();
        $admin->setUsername('admintest@example.com');
        $admin->setEmail('admintest@example.com');
        $admin->setFullname('Test User');
        $admin->setInstitution('Test Institution');
        $admin->setEnabled(true);
        $admin->setPlainPassword('supersecret');
        $admin->addRole('ROLE_ADMIN');
        self::$em->persist($admin);
        
        self::$em->flush();
    }
    
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        $user = self::$em->getRepository('LOCKSSOMaticUserBundle:User')->findOneBy(array(
            'email' => 'user@example.com'
        ));
        self::$em->remove($user);
        $admin = self::$em->getRepository('LOCKSSOMaticUserBundle:User')->findOneBy(array(
            'email' => 'admintest@example.com'
        ));
        self::$em->remove($admin);
        self::$em->flush();
    }

    public function doLogin($username, $password)
    {
        $client = self::createClient();
        $client->restart();
        
        $crawler = $client->request('GET', '/login');
        $response = $client->getResponse();
        $form = $crawler->selectButton('Login')->form();
        $form['_username'] = $username;
        $form['_password'] = $password;
        
        $crawler = $client->submit($form);
        $response = $client->getResponse();
        if($response->getStatusCode() !== 200) {
            $this->logger->error($response->getContent());
        }
        return $client;
    }

    public function testAccessControlAnon()
    {
        $client = self::createClient();
        $client->restart();
        
        $crawler = $client->request('GET', '/admin/user/');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }
    
    public function testAccessControlUser()
    {
        $client=$this->doLogin('user@example.com', 'supersecret');
        
        $crawler = $client->request('GET', '/admin/user/');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
    }
    
    public function testAccessControlAdmin()
    {
        $client=$this->doLogin('admintest@example.com', 'supersecret');
        
        $crawler = $client->request('GET', '/admin/user/');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
    
}
