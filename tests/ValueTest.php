<?php 

use Illuminate\Database\Eloquent\Model;

/**
 * Class ValueTest 
 */
class ValueTest extends TestCase 
{
    /**
     * @test 
     * @testdox Waarde methode geeft een session terug met lege waardes
     */
    public function valueMethodReturnsSessionEmptyValues(): void 
    {
        $form = app('applicatie_naam');
        session()->flashInput(['field' => '']);

        $this->assertEquals('', $form->value('field'));
    }

    /**
     * @test 
     * @testdox Waarde methode geeft een model terug met lege waardes 
     */
    public function valueMethodReturnsModelEmptyValues(): void 
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('field')->willReturn('');

        $form = app('applicatie_naam');
        $form->model($model->reveal());

        $this->assertEquals('', $form->value('field'));
    }

    /**
     * @test 
     * @testdox Waarde method geeft een standaard waarde terug
     */
    public function valueMethodReturnsDefaultValue(): void 
    {
        $form = app('applicatie_naam');
        $this->assertEquals('default', $form->value('field', 'default'));
    }
}