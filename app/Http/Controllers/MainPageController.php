<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;

class MainPageController extends Controller
{

    /**
     * Главная
     *
     * @param Int $id
     * @param Request $request
     * @return string
     */
    public function mainPage(Int $id = 0, Request $request)
    {
        $page = $request->input('page', $id);
        return "Page is: $page";
    }

    /**
     * Вторая страница
     *
     * @param boolean $test
     * @throws \InvalidArgumentException
     * @return string
     */
    public function secondPage($test = false)
    {
        if ($test > 0) {
            throw new \InvalidArgumentException('test', null);
        }
        return 'second page';
    }

    /**
     * Следующая тестовая страница
     *
     * @param integer $in
     * @return string
     */
    public function nextPage(int $in)
    {
        return "Next is {$in}";
    }

    /**
     * Страница продукта
     *
     * @param int $product
     * @return string
     */
    public function productPage(int $product = null)
    {
        $res = ProductModel::where('id', $product)->first();
        if (! empty($res)) {
            $out = "Продукт: &#34{$res->name}&#34, цена: {$res->price}р;";
        } else {
            $out = "Продукт не найден";
        }
        return $out;
    }

    /**
     * Добавить новый продукт
     *
     * @param Request $request
     * @return string
     *
     */
    //@codeCoverageIgnoreStart
    public function productAdd(Request $request)
    {
        $name = $request->input('name', null);
        $price = $request->input('price', null);
        if (! empty($name) && ! empty($price)) {
            $product = new ProductModel();
            $product->name = $name;
            $product->price = $price;
            $product->save();
            $out = "Создан новый продукт<br />Название:{$name}, цена:{$price}";
        } else {
            $out = "Укажите полные данные!";
        }
        return $out;
    }
    
    /**
     * 
     * @param int $id
     * @return string
     * 
     */
    public function productDelete(int $id) {
        $res = ProductModel::where('id',$id)->first();
        if (! empty($res)) {
            $res->delete();
            $out = "Продукт удалён!";
        } else {
            $out = "Ошибка! Продукт с номером #{$id} не найден!";
        }
        return $out;
    }
    //@codeCoverageIgnoreEnd
}
