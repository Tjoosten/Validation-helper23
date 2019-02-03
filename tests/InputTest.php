<?php 

use Illuminate\Database\Eloquent\Model;

/**
 * Class InputTest
 */
class InputTest extends TestCase
{
    /**
     * Combinaties:
     *
     * -oude invoer en -model            = null/standaard
     * -oude invoer en +model/-attribuut = null/standaard
     * +oude invoer en +model/+attribuut = oude invoer
     * -oude invoer en +model/+attribuut = model's attribuut
     */

    /**
     * @test
     * @testdox Generatie van valide attributen
     */
    public function itGeneratesValidAttributes(): void
    {
        $this->assertBladeRender('name="name" value=""', "@input('name')");
        $this->assertBladeRender('name="name" value="default"', "@input('name', 'default')");
    }

    /**
     * @test
     * @testdox Generatie van valide attributen wanneer de model geen attribuut weergeeft
     */
    public function itGeneratesValidAttributesWhenThe_ModelDoesNotHaveTheAttribute(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn(null);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('name="name" value=""', '@form($model) @input("name")', $viewData);
        $this->assertBladeRender('name="name" value="default"', '@form($model) @input("name", "default")', $viewData);
    }

    /**
     * @test
     * @testdox Generatie van valide attributen wanneer een oude invoer aanwezig is
     */
    public function itGeneratesValidAttributesWhenOldInputExists(): void
    {
        $this->session(['_old_input' => ['name' => 'Old John Doe']]);
        $this->assertBladeRender('name="name" value="Old John Doe"', "@input('name')");
    }

    /**
     * @test
     * @textdox Generatie van valide attributen wanneer een oude invoer + model aatribuut aanwezig is
     */
    public function itGeneratesValidAttributesWhenOldInputAndModelExists(): void
    {
        $this->session(['_old_input' => ['name' => 'Old John Doe']]);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn('John Doe');

        $viewData = ['model' => $model->reveal()];
        $this->assertBladeRender('name="name" value="Old John Doe"', '@form($model) @input("name")', $viewData);
    }

    /**
     * @test
     * @testdox Generatie van valide attributen wanneer een model bestaat
     */
    public function itGeneratesValidAttributesWhenModelExists(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('name')->willReturn('John Doe');
        
        $viewData = ['model' => $model->reveal()];
        $this->assertBladeRender('name="name" value="John Doe"', '@form($model) @input("name")', $viewData);
    }
}