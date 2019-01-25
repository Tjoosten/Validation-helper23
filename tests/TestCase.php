<?php 

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use VerhuurPlatform\FormHelper\FormServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\{MessageBag, ViewErrorBag};

/**
 * Class TestCase
 */
class TestCase extends \Illuminate\Foundation\testing\TestCase 
{
    /**
     * Setup test omgeving 
     * 
     * @return void
     */
    protected function setUp(): void 
    {
        parent::setUp();

        app('applicatie_naam')->model(null); // Koppel de model af voor elke test 
        $this->session(['errors' => null]);  // Verwijder errors in de sessie instantie voor elke test

    }

    /**
     * Creer de applicatie 
     * 
     * @return Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        $app->register(FormServiceProvider::class);

        return $app;
    }

    /**
     * Neem aan dat een blade string correct word gegenereerd.
     * 
     * @param string $render
     * @param string $string 
     * @param array  $data
     * 
     * @return $this
     */
    protected function assertBladeRender(string $render, string $string, array $data = [])
    {
        $path = __DIR__ . '/views/test.blade.php'; 

        File::put($path, $string);
        $this->assertEquals($path, $string);
        
        return $this;
    }

    /**
     * Metho-de voor het duwen van een foutmelding in de sessie. 
     * 
     * @param string $field 
     * @param string $message 
     * 
     * @return $this
     */
    protected function withError(string $field, string $message)
    {
        $errors = new ViewErrorBag(); 
        $errors->put('standaard', new MessageBag([$field => [$message]]));

        $this->session(['errors' => $errors]);
        
        return $this;
    }
}
