<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RackControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    public function testCreate(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/racks/');

        $this->assertResponseIsSuccessful();
        $client->clickLink('Create new');
        $client->submitForm('Save', [
            'rack[name]' => 'toto',
        ]);
        $this->assertResponseRedirects('/racks/');
    }

    /**
     * @dataProvider provideInvalidInput
     */
    public function testCreateWithInvalidInput(string $name, string $expected): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/racks/');

        $this->assertResponseIsSuccessful();
        $client->clickLink('Create new');
        $client->submitForm('Save', [
            'rack[name]' => $name,
        ]);
        $this->assertSelectorTextContains('li', $expected);
    }

    public function provideInvalidInput(): array
    {
        return [
            'empty' => ['', 'This value should not be blank.'],
            'toolong' => [str_repeat('a', 256), 'This value is too long. It should have 255 characters or less.'],
        ];
    }
}
