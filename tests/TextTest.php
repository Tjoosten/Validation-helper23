<?php 

use Illuminate\Database\Eloquent\Model; 

/**
 * Class TextTest
 */
class TextTest extends TestCase 
{
    /**
     * @test 
     * @testdox Generatie van valide attributen
     */
    public function itGeneratesValidAttributes(): void 
    {
        $this->assertBladeRender('', "@text('beschrijving')");
        $this->assertBladeRender('standaard', "@text('beschrijving', 'standaard')");
    }

    /**
     * @test 
     * @testdox Generatie van valide attributen wanneer database model geen waarde heeft
     */
    public function itGeneratesValidAttributesWhenTheModelDoesNotHaveTheAttribute(): void 
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('beschrijving')->willReturn(null);

        $viewData = ['model' => $model->reveal()];

        $this->assertBladeRender('', '@form($model) @text("description")', $viewData);
        $this->assertBladeRender('standaard', '@form($model) @text("beschrijving", "standaard")', $viewData);
        $this->assertBladeRender('', '');
    }

    /**
     * @test 
     * @testdox Generatie van valide attributen wanneer er oude inputs aanwezig zijn.
     */
    public function itGeneratesValidAttributesWhenOldInputExists(): void 
    {
        $this->session(['_old_input' => ['beschrijving' => 'beschrijving']]);
        $this->assertBladeRender('beschrijving', '@text("beschrijving")');
    }

    /**
     * @test 
     * @testdox Generatie van valide attributen wanneer oude inputs en model aanwezig zijn
     */
    public function itGeneratesValidAttributesWhenOldInputAndModelExists(): void 
    {
        $this->session(['_old_input' => ['beschrijving' => 'Beschrijving van een oude invoer']]);

        $model = $this->prophesize(Model::class);
        $model->getAttribute('beschrijving')->willReturn('Beschrijving van model');

        $viewData = ['model' => $model->reveal()];
        $this->assertBladeRender('Beschrijving van een oude invoer', '@form($model) @text("beschrijving")', $viewData);
    }

    /**
     * @test 
     * @testdox generatie van valide attributen wanneer model bestaat. 
     */
    public function itGeneratesValidAttributesWhenModelExists(): void 
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('beschrijving')->willReturn('Beschrijving'); 

        $viewData = ['model' => $model->reveal()];
        $this->assertBladeRender('Beschrijving', '@form($model) @text("beschrijving")', $viewData);

    }  
}