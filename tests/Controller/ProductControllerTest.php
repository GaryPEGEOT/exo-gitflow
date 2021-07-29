<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    public function testCreate(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/products/');

        $this->assertResponseIsSuccessful();
        $client->clickLink('Create new');
        $client->submitForm('Save', [
            'product[name]' => 'tata',
            'product[rack]' => static::$fixtures['rack_1']->getId(),
        ]);
        $this->assertResponseRedirects('/products/');
    }

    /**
     * @dataProvider provideInvalidInput
     */
    public function testCreateWithInvalidInput(string $name, string $expected): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/products/');

        $this->assertResponseIsSuccessful();
        $client->clickLink('Create new');
        $crawler = $client->submitForm('Save', [
            'product[name]' => $name,
        ]);
    }

    public function provideInvalidInput(): array
    {
        return [
            'empty' => ['', 'This value should not be blank.'],
            'toolong' => [str_repeat('a', 256), 'This value is too long. It should have 255 characters or less.'],
        ];
    }
}
