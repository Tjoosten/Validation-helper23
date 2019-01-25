<?php

/**
 * Class EscapeValueTest
 */
class EscapeValueTest extends TestCase
{
    /**
     * @test
     * @testdox Escape een waarde van een input veld 
     */
    public function EscapeValueForAnInputField(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@input('name', '<')");
    }

    /**
     * @test
     * @testdox Escape een waarde voor een text veld
     */
    public function EscapeValueForAnTextarea(): void
    {
        $this->assertBladeRender('&lt;html&gt;', "@text('name', '<html>')");
    }

    /**
     * @test
     * @testdox Escape een waarde voor een checkbox
     */
    public function EscapeValueForAnCheckbox(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@checkbox('name', '<')");
    }

    /**
     * @test
     * @testdox Escape een waarde van een radio knop
     */
    public function EscapeValueForAnRadioButton(): void
    {
        $this->assertBladeRender('name="name" value="&lt;"', "@radio('name', '<')");
    }

    /**
     * @test
     * @testdox Escape een waarde van een option veld
     */
    public function EscapeValueForAnOption(): void
    {
        $this->assertBladeRender('<option value="&lt;">Text</option>', '@options($options, "name")', [
            'options' => ['<' => 'Text']
        ]);
    }
}