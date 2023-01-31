<?php
use App\Http\Controllers\IgnoreThisController;
use Tests\TestCase;
use App\Http\Controllers\Controller;
use function PHPUnit\Framework\callback;

/**
 * IgnoreThisController test case.
 */
class IgnoreThisControllerTest extends TestCase
{

    /**
     *
     * @var IgnoreThisController
     */
    private $ignoreThisController;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // TODO Auto-generated IgnoreThisControllerTest::setUp()

        $this->ignoreThisController = new IgnoreThisController();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        // TODO Auto-generated IgnoreThisControllerTest::tearDown()
        $this->ignoreThisController = null;

        parent::tearDown();
    }

    /**
     * Tests IgnoreThisController->my()
     *
     * @group ignore
     */
    public function testMy()
    {
        $this->assertNull($this->ignoreThisController->my(/* parameters */));
    }

    /**
     * Tests IgnoreThisController->ok()
     * @ group ignore
     *
     * @covers App\Http\Controllers\IgnoreThisController::ok
     */
    public function testOk()
    {
        $this->assertNull($this->ignoreThisController->ok(/* parameters */));
        $this->assertFileIsReadable(public_path('test1'));
        $this->assertFileIsReadable(public_path('test2'));
        $this->assertFileEquals(public_path('test1'), public_path('test2'));
        $this->assertInstanceOf(Controller::class, $this->ignoreThisController);
        $f = function(){
            return 1;
        };
        $this->assertThat($f(), $this->logicalNot($this->isType('array')));
    }
}

