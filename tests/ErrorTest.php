<?php

/**
 * Class ErrorTest
 */
class ErrorTest extends TestCase
{
    /**
     * @test
     * @testdox Geef geen error weer wanneer er geen error is.
     */
    public function doNotDisplayErrorWhenThereIsNoError(): void
    {
        $this->assertBladeRender('', '@error("field")');
    }

    /**
     * @test
     * @testdox Weergave van een foutmelding
     */
    public function displayErrors(): void
    {
        $this->withError('field', 'Foutmelding');
        $this->assertBladeRender('<div class="help-block">Foutmelding</div>', '@error("field")');
    }

    /**
     * @test
     * @testdox Geef een foutmelding weer met een aangepaste template
     */
    public function displayErrorWithCustomTemplate(): void
    {
        $this->withError('field_name', 'Foutmelding');

        $this->assertBladeRender('has-error', "@error('field_name', 'has-error')");
        $this->assertBladeRender('<span>Foutmelding</span>', "@error('field_name', '<span>:message</span>')");
    }

    /**
     * @test
     * @testdox Geef een foutmelding weer met een aangepaste template uit de config
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
     * @testdox Escape foutmelding
     */
    public function escapeError(): void
    {
        $this->withError('field_name', '<html>');
        $this->assertBladeRender('<div class="help-block">&lt;html&gt;</div>', '@error("field_name")');
    }
}