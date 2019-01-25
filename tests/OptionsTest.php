<?php 

use VerhuurPlatform\FormHelper\Form;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OptionsTest 
 */
class OptionsTest extends TestCase 
{
    /**
     * @test 
     * @testdox Generatie van optie velden
     */
    public function itGeneratesOptions(): void
    {
        $viewData = [
            'options' => [
                'option_a' => 'Option A',
                'option_b' => 'Option B',
            ],
            'default' => ['option_a', 'option_b']
        ];
        
        // Geen geselecteerde optie
        $html  = '<option value="option_a">Option A</option>';
        $html .= '<option value="option_b">Option B</option>';
        $this->assertBladeRender($html, '@options($options, "select")', $viewData);
        
        // Standaard geselecteerde optie
        $html  = '<option value="option_a">Option A</option>';
        $html .= '<option value="option_b" selected>Option B</option>';
        $this->assertBladeRender($html, '@options($options, "select", "option_b")', $viewData);
        
        // Multiple default selected options
        $html  = '<option value="option_a" selected>Option A</option>';
        $html .= '<option value="option_b" selected>Option B</option>';
        $this->assertBladeRender($html, '@options($options, "select", $default)', $viewData);
    }

    /**
     * @test
     * @testdox Generatie van optie velden met een placeholder
     */
    public function itGeneratesOptionsWithPlaceholder(): void
    {
        $viewData = ['options' => ['option_value' => 'Option Text']];

        $html  = '<option value="" selected disabled>Placeholder</option>';
        $html .= '<option value="option_value">Option Text</option>';

        $this->assertBladeRender($html, '@options($options, "select", null, "Placeholder")', $viewData);
    }

    /**
     * @test
     * @testdox Generatie van opties wanneer een model de attribute niet bezit
     */
    public function itGeneratesOptionWhenTheModelDoesNotHaveTheAttribute(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn(null);

        $viewData = [
            'model'   => $model->reveal(),
            'default' => ['option_a', 'option_b'],
            'options' => [
                'option_a' => 'Option A',
                'option_b' => 'Option B',
            ],
        ];

        // Geen geselecteerde optie
        $html  = '<option value="option_a">Option A</option>';
        $html .= '<option value="option_b">Option B</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select")', $viewData);
        
        // Standaard geselecteerde optie
        $html  = '<option value="option_a">Option A</option>';
        $html .= '<option value="option_b" selected>Option B</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select", "option_b")', $viewData);
        
        // Meerdere standdarde geselecteerde opties
        $html  = '<option value="option_a" selected>Option A</option>';
        $html .= '<option value="option_b" selected>Option B</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select", $default)', $viewData);
    }

    /**
     * @test
     * @testdox Generatie van opties wanneer de database model bestaat
     */
    public function itGeneratesOptionsWhenTheModelExists(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn('option_b');
        $model->getAttribute('select_multiple')->willReturn(['option_b', 'option_a']);
        
        $viewData = [
            'model' => $model->reveal(),
            'default' => ['option_a', 'option_b'],
            'options' => [
                'option_a' => 'Option A',
                'option_b' => 'Option B',
            ],
        ];

        // Geselecteerde optie
        $html  = '<option value="option_a">Option A</option>';
        $html .= '<option value="option_b" selected>Option B</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select")', $viewData);
        
        // Negeer de stanldaard optie omdat de model een geslecteerde optie weergeeft.
        $this->assertBladeRender($html, '@form($model) @options($options, "select", "option_a")', $viewData);
        
        // Meerdere opties geselecteerd
        $html  = '<option value="option_a" selected>Option A</option>';
        $html .= '<option value="option_b" selected>Option B</option>';
        $this->assertBladeRender($html, '@form($model) @options($options, "select_multiple")', $viewData);
    }

    /**
     * @test
     * @testdox generatie van optie velden wanneer er een oude input en model attribuut aanwezig is
     */
    public function itGeneratesOptionsWhenOldInputAndTheModelExists(): void
    {
        $model = $this->prophesize(Model::class);
        $model->getAttribute('select')->willReturn('model_option_value');

        $viewData = [
            'model'   => $model->reveal(),
            'options' => ['option_value' => 'Option Text'],
        ];

        $this->session(['_old_input' => ['select' => 'option_value']]);
        $html = '<option value="option_value" selected>Option Text</option>';

        $this->assertBladeRender($html, '@form($model) @options($options, "select")', $viewData);
        $this->assertBladeRender($html, '@form($model) @options($options, "select", "default_value")', $viewData);
    }

    /**
     * @test
     * @testdox Generatie van opties wanneer een oud invoer aanwezig is
     */
    public function it_generates_options_when_old_input_exists(): void
    {
        $viewData = ['options' => ['option_value' => 'Option Text']];
        $this->session(['_old_input' => ['select' => 'option_value']]);
        $html = '<option value="option_value" selected>Option Text</option>';
        
        $this->assertBladeRender($html, '@options($options, "select")', $viewData);
        $this->assertBladeRender($html, '@options($options, "select", "default_value")', $viewData);
    }
}