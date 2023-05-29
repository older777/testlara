<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\CurrExController;

class CurrExControllerTest extends TestCase
{

    private $currEx;

    /**
     *
     * {@inheritdoc}
     * @see \Illuminate\Foundation\Testing\TestCase::setUp()
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->currEx = new CurrExController();
    }

    /**
     *
     * {@inheritdoc}
     * @see \Illuminate\Foundation\Testing\TestCase::tearDown()
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRouteCurrex()
    {
        $response = $this->get('/currex');
        $response->assertStatus(200);
        ob_clean();
    }

    /**
     * Page test integrated
     *
     * @return void
     */
    public function testPageInteg()
    {
        $this->expectOutputRegex('/EUR/');
        $result = $this->currEx->page();
    }

    public function testPageUnit()
    {
        $content = '1 USD = 0.93112463 EUR<br />
                    1 USD = 7.06 CNY<br />
                    1 USD = 139.84 JPY<br />
                    1 USD = 82 RUB<br />
                    1 USD = 0.81 GBP<br />
                    1 USD = 5 BRL<br />';
        $currExController = $this->createMock(CurrExController::class);
        $currExController->method('page')->will($this->returnValue($content));

        $this->assertMatchesRegularExpression('/EUR/', $currExController->page());
    }
}
