<?php 

use Illuminate\Support\Facades\{Artisan, File};

/**
 * Class ConfigTest 
 */
class ConfigTest extends TestCase 
{
    /**
     * @test 
     * @testdox Test of het configuratie bestand gepubliceerd kan worden
     */
    public function ConfigFileIsPublished(): void 
    {
        $configFile = __DIR__ . '/../vendor/laravel/laravel/config/form-helpers.php';
        
        File::delete($configFile);
        $this->assertFileNotExists($configFile);
        
        Artisan::call('vendor:publish', [
            '--provider' => 'ActivismeBE\FormHelper\FormServiceProvider',
        ]);
        
        $this->assertFileExists($configFile);

    }
}