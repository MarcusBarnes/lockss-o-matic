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

namespace LOCKSSOMatic\SWORDBundle\Tests\Plugins\ausbyyear;

use J20\Uuid\Uuid;
use LOCKSSOMatic\CRUDBundle\Entity\Deposits;
use LOCKSSOMatic\SWORDBundle\Event\DepositContentEvent;
use LOCKSSOMatic\SWORDBundle\Event\ServiceDocumentEvent;
use LOCKSSOMatic\SWORDBundle\Plugins\ausbyyear\AusByYear;
use LOCKSSOMatic\SWORDBundle\Tests\Plugins\TestCases\DepositTestCase;
use LOCKSSOMatic\SWORDBundle\Utilities\Namespaces;
use SimpleXMLElement;

/**
 * Test the AuByYear plugin.
 */
class AusByYearTest extends DepositTestCase
{

    /**
     * Test getting the plugin from the service container.
     */
    public function testServiceContainer()
    {
        /** @var AusByYear */
        $plugin = $this->container->get('lomplugin.aus.year');
        $this->assertNotNull($plugin);
        $this->assertInstanceOf(
            'LOCKSSOMatic\PluginBundle\Plugins\AbstractPlugin',
            $plugin);
        $this->assertInstanceOf(
            'LOCKSSOMatic\SWORDBundle\Plugins\ausbyyear\AusByYear',
            $plugin);
        $this->assertEquals('lomplugin.aus.year', $plugin->getPluginId());
    }

    /**
     * Test that the plugin provides a description of itself for the 
     * service document.
     */
    public function testOnServiceDocument()
    {
        $ns = new Namespaces();
        $xml = new SimpleXMLElement('<root />');
        $ns->registerNamespaces($xml);

        /** @var AusByYear */
        $plugin = $this->container->get('lomplugin.aus.year');
        $event = new ServiceDocumentEvent($xml);
        $plugin->onServiceDocument($event);

        $nodes = $xml->xpath('//lom:plugin');
        $this->assertEquals(1, count($nodes));
        $node = $nodes[0];
        $this->assertEquals('lomplugin.aus.year', $node['pluginId']);
        $this->assertEquals('size, year', $node['attributes']);
    }

    /**
     * Attempt to deposit a single content item.
     */
    public function testOnDepositSingleContent()
    {
        $provider = $this->em->getRepository('LOCKSSOMaticCRUDBundle:ContentProviders')
            ->findOneBy(array('uuid' => $this->providerId));
        
        $xml = new SimpleXMLElement('<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" size="10" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>');
        $deposit = new Deposits();
        $deposit->setContentProvider($provider);
        $deposit->setUuid(Uuid::v4());
        $deposit->setTitle('Test deposit abst-todsc ');
        $this->em->persist($deposit);
        $event = new DepositContentEvent('lomplugin.aus.year', $deposit, $provider, $xml);

        /** @var AusByYear */
        $plugin = $this->container->get('lomplugin.aus.year');

        $plugin->onDepositContent($event);
        $this->em->refresh($provider);
        $this->assertEquals(1, $provider->getAus()->count());
    }

    /**
     * Attempt to deposit multiple content items - they should all go to to the
     * same AU, because they are all the same year and fit in a single AU.
     */
    public function testOnDepositSingleAu()
    {
        $provider = $this->em->getRepository('LOCKSSOMaticCRUDBundle:ContentProviders')
            ->findOneBy(array('uuid' => $this->providerId));
        
        $items = array(
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="4000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="1000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="2000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
        );
        
        /** @var AusByYear */
        $plugin = $this->container->get('lomplugin.aus.year');
        $deposit = new Deposits();
        $deposit->setContentProvider($provider);
        $deposit->setUuid(Uuid::v4());
        $deposit->setTitle('Test deposit abst-todsa');
        $this->em->persist($deposit);
        $this->em->flush();

        foreach($items as $item) {
            $xml = new SimpleXMLElement($item);        
            $event = new DepositContentEvent('lomplugin.aus.year', $deposit, $provider, $xml);
            $plugin->onDepositContent($event);
        }

        $this->em->refresh($provider);
        $this->assertEquals(1, $provider->getAus()->count());
    }

    /**
     * Attempt to deposit multiple content items. They don't fit in a single AU,
     * and would go in different years anyway.
     */
    public function testOnDepositMultipleAus()
    {
        $provider = $this->em->getRepository('LOCKSSOMaticCRUDBundle:ContentProviders')
            ->findOneBy(array('uuid' => $this->providerId));
        
        // These should go into four AUs, based on year AND size (the 2010 year is too large).
        $items = array(
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="4000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2011" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="1000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2011" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="2000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2012" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="4000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="1000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="2000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="4000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2012" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="1000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
            '<lom:content xmlns:lom="http://lockssomatic.info/SWORD2" year="2010" plugin="LOCKSSOMatic\PluginBundle\Plugins\ausbysize\AusBySize" size="2000" checksumType="md5" checksumValue="bd4a9b642562547754086de2dab26b7d">http://provider.example.com/download/file1.zip</lom:content>',
        );
        
        /** @var AusByYear */
        $plugin = $this->container->get('lomplugin.aus.year');
        $deposit = new Deposits();
        $deposit->setContentProvider($provider);
        $deposit->setUuid(Uuid::v4());
        $deposit->setTitle('Test deposit abst-todsa');
        $this->em->persist($deposit);
        $this->em->flush();

        foreach($items as $item) {
            $xml = new SimpleXMLElement($item);        
            $event = new DepositContentEvent('lomplugin.aus.year', $deposit, $provider, $xml);
            $plugin->onDepositContent($event);
        }

        $this->em->refresh($provider);
        $this->assertEquals(4, $provider->getAus()->count());
    }

}
