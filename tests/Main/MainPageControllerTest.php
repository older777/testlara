<?php
declare(strict_types = 1);
namespace Tests\Main;

use App\Http\Controllers\MainPageController;
use Illuminate\Http\Request;
use Tests\TestCase;
use Exception;
use Throwable;
use PHPUnit\Framework\Error\Notice;
use SebastianBergmann\Invoker\Invoker;
use SebastianBergmann\Invoker\TimeoutException;
use Illuminate\Testing\Concerns\TestDatabases;
use Illuminate\Support\Facades\DB;
use App\Models\ProductModel;
require 'tests/CsvFileIterator.php';

/**
 * MainPageController test case.
 */
class MainPageControllerTest extends TestCase
{

    use TestDatabases;

    protected static $data;

    protected $invok;

    /**
     *
     * @var MainPageController
     */
    private $mainPageController;

    public static function setUpBeforeClass(): void
    {
        self::$data = 'testy';
        $GLOBALS['testy'] = self::$data;
    }

    public static function tearDownAfterClass(): void
    {
        self::$data = null;
        // $GLOBALS['testy'] = null;
    }

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // TODO Auto-generated MainPageControllerTest::setUp()

        $this->mainPageController = new MainPageController(/* parameters */);

        $this->invok = new Invoker();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        // TODO Auto-generated MainPageControllerTest::tearDown()
        $this->mainPageController = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        // TODO Auto-generated constructor
        parent::__construct($name, $data, $dataName);
    }

    public function testIsExist()
    {
        $this->assertTrue(class_exists(MainPageController::class));
        return true;
    }

    public function gen(): \Generator
    {
        yield [
            'var1' => 1
        ];
        yield [
            'var2' => 2
        ];
        yield [
            'var3' => 3
        ];
        return 'is over';
    }

    public function somedata()
    {
        // return $this->gen();
        $obj = ('/var/www/testlara/tests/test.csv');
        return new \CsvFileIterator($obj);
    }

    /**
     * Tests MainPageController->mainPage()
     */
    public function testMainPage()
    {
        // TODO Auto-generated MainPageControllerTest->testMainPage()
        // $this->markTestIncomplete("mainPage test not implemented");
        $request = new Request();
        $out = $this->mainPageController->mainPage(1, $request);
        $this->assertNotEmpty($out);
        return (bool) true;
    }

    /**
     *
     * @depends testMainPage
     * @depends testIsExist
     * @dataProvider somedata
     */
    public function testSecondPage($some, $main, $exist)
    {
        $this->assertNotNull($some);
        $this->assertTrue($main);
        $this->assertTrue($exist);
        // $res = $this->get('/second');
        // $res->assertStatus(200);

        if ($some > 2) {
            $test = true;
            $this->expectException(Throwable::class);
        } else {
            $test = false;
        }
        $this->assertIsString($this->mainPageController->secondPage($test));
        // try {
        // $out = $this->mainPageController->secondPage($test);
        // } catch (Throwable $e) {
        // if (get_class($e) == \InvalidArgumentException::class) {
        // echo "{$e->getMessage()}\n";
        // $this->expectException();
        // } else {
        // throw new \Exception($e->getMessage());
        // }
        // }
    }

    /**
     *
     * @dataProvider somedata
     * @backupGlobals enabled
     *
     */
    public function testNextPage($in)
    {
        $this->expectOutputRegex("/{$in}+/");
        $GLOBALS['testy'] = null;
        $cb = function () use ($in) {
            echo $this->mainPageController->nextPage((int) $in);
            // sleep(intval($in));
        };
        try {
            $this->invok->invoke($cb, [], 4);
        } catch (TimeoutException $e) {
            throw new \Exception('time is out!');
        }
        $this->assertTrue(true);
    }

    /**
     *
     * @requires function my_count
     */
    public function testFunc()
    {
        $this->markTestIncomplete('Реализуй тест!');
    }

    /**
     *
     * @dataProvider somedata
     * @backupGlobals enabled
     */
    public function testproductDelete($in)
    {
        DB::statement('SET autocommit=OFF;');
        DB::beginTransaction();

        $count = ProductModel::all()->count();
        $this->assertNotEmpty($this->mainPageController->productDelete((int)$in));
        $count2 = ProductModel::all()->count();
        $this->assertLessThan($count, $count2);

        DB::rollBack();
    }
}
