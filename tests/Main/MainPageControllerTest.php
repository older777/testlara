<?php
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

    protected static $data;

    protected $invok, $close;

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
        DB::statement('SET autocommit=OFF;');
        DB::beginTransaction();
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
        DB::rollBack();

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
        $obj = ('tests/test.csv');
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
        $mockProductModel = $this->createMock(ProductModel::class);
        $out = $this->mainPageController->mainPage($mockProductModel);
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
            sleep(intval($in));
        };
        try {
            $this->invok->invoke($cb, [], 5);
        } catch (TimeoutException $e) {
            throw new \Exception('time is out!');
        }
        $this->assertTrue(true);
    }

    /**
     */
    public function testproductPage()
    {
        $out = $this->mainPageController->productPage(1);
        $this->assertStringNotContainsString("не найден", $out);
        $out = $this->mainPageController->productPage(0);
        $this->assertStringContainsString("не найден", $out);
    }

    public function testProductAdd()
    {
        $req = $this->createMock(Request::class);
        $out = $this->mainPageController->productAdd($req);
        $this->assertNotEmpty($out);
    }

    /**
     *
     * @dataProvider somedata
     * @backupGlobals enabled
     *
     */
    public function testproductDelete($in)
    {
        $count = ProductModel::all()->count();
        $this->assertNotEmpty($this->mainPageController->productDelete((int) $in));
        $count2 = ProductModel::all()->count();
        $this->assertLessThanOrEqual($count, $count2);

        // создать и настроить заглушку
        $close = $this->createMock(MainPageController::class);
        $close->method('productDelete')->willReturn('Продукт удалён');

        $out = $close->productDelete((int) $in);
        $this->assertNotEmpty($out);
    }

    /**
     * Двойник MainPageController
     * метод mainpage
     */
    public function testMainPageMock()
    {
        $close = $this->getMockBuilder(MainPageController::class)
            ->onlyMethods([
            'mainPage'
        ])
            ->getMock();
        $close->expects($this->exactly(3))
            ->method('mainPage')
            ->withConsecutive([
            $this->equalTo(1)
        ], [
            $this->greaterThan(1)
        ], [
            3
        ]);
        $mockProductModel = $this->createMock(ProductModel::class);
        $out = $close->mainPage($mockProductModel);
        // $this->assertSame("Page is: 1", );
        // $out = $close->mainPage($in, new Request());
        // $this->assertSame("Page is: {$in}", $out);
        // $this->assertSame(2, $close->secondPage());
        // $this->assertSame(3, $close->secondPage());
        // $this->assertSame(4, $close->secondPage());
        $out = $close->mainPage(30);
        $out = $close->mainPage(3);
    }

    /**
     * Двойник MainPageController
     * метод secondpage
     */
    public function testSecondPageMock()
    {
        $close = $this->getMockBuilder(MainPageController::class)
            ->onlyMethods([
            'secondPage'
        ])
            ->getMock();
        $close->expects($this->once())
            ->method('secondPage')
            ->willReturnOnConsecutiveCalls(1, 2, 3, 4, 5, 8);
        //$out = $close->secondPage();
        $this->assertSame(1, $close->secondPage());
        //$this->assertSame(2, $close->secondPage());
        //$this->assertSame(3, $close->secondPage());
        //$this->assertSame(4, $close->secondPage());
        $this->assertInfinite(log(0));
    }
}
