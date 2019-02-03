<?php 

/**
 * Class ErrorTest 
 */
class ErrorTest extends TestCase 
{
    /**
     * @test 
     * @testdox Geen geen foutmelding weer als er geen is
     */
    public function doNotDisplayErrorWhenThereIsNoError(): void 
    {
        $this->assertBladeRender('', '@error("field")');
    }

    /**
     * @test
     * @testdox Geen een foutmelding weer
     */
    public function displayError(): void 
    {
        $this->withError('field', 'foutmelding'); 
        $this->assertBladeRender('<div class="invalid-feedback">foutmelding</div>', '@error("field")');
    }

    /**
     * @test
     * @testdox Weergave van een foutmelding met een aangepaste template
     */
    public function displayErrorWithCustomTemplate(): void 
    {
        $this->withError('field_name', 'foutmelding'); 

        $this->assertBladeRender('invalid-feedback', "@error('field_name', 'invalid-feedback')");
        $this->assertBladeRender('<span>foutmelding</span>', "@error('field_name', '<span>:message</span>')");
    }

    /**
     * @test
     * @testdox Weergave van een foutmelding met een aangepaste template (config)
     */    
    public function displayErrorWithCustomTemplateDefinedInConfig(): void 
    {
        $originalConfig = config('form-helpers.error_template');
        config(['form-helpers.error_template' => '<error>:message</error>']);

        $this->withError('field_name', 'Error Message');
        $this->assertBladeRender('<error>Error Message</error>', "@error('field_name')");

        config(['form-helpers.error_template' => $originalConfig]);
    }

    /**
     * @test
     * @testdox Escape een foutmelding
     */
    public function escapeError(): void 
    {
        $this->withError('field_name', '<html>');
        $this->assertBladeRender('<div class="help-block">&lt;html&gt;</div>', '@error("field_name")');
    }
}