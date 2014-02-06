<?php

namespace LOCKSSOMatic\CRUDBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContentProvidersControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/contentproviders/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /contentproviders/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'lockssomatic_crudbundle_contentproviders[contentOwnersId]'  => '1',
            'lockssomatic_crudbundle_contentproviders[type]'  => 'Test type',
            'lockssomatic_crudbundle_contentproviders[name]'  => 'Test name',
            'lockssomatic_crudbundle_contentproviders[name]'  => '123.456.789.111',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("123.456")')->count(), 'Missing element td:contains("123.456")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'lockssomatic_crudbundle_contentproviders[type]'  => 'Updated test type',
            'lockssomatic_crudbundle_contentproviders[name]'  => 'Updated test name',
            'lockssomatic_crudbundle_contentproviders[name]'  => '999.222.111.555',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains the updated value.
        $this->assertGreaterThan(0, $crawler->filter('html:contains("999.222")')->count(), 'Missing text "999.222"');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been deleted from the list
        $this->assertNotRegExp('/Updated\stest\sname/', $client->getResponse()->getContent());
    }

}
