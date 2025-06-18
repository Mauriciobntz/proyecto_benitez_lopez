<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\ConfiguracionModel;
use App\Models\CategoriaModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form'];

    /**
     * Modelos para configuraciones globales
     */
    protected $configuracionModel;
    protected $categoriaModel;

    /**
     * Configuraciones globales de la tienda
     */
    protected $configuracionTienda;
    protected $categoriasGlobales;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = service('session');

        // Inicializar modelos para configuraciones globales
        $this->configuracionModel = new ConfiguracionModel();
        $this->categoriaModel = new CategoriaModel();

        // Cargar configuraciones globales
        $this->cargarConfiguracionesGlobales();
    }

    /**
     * Carga las configuraciones globales de la tienda y categorías
     * que se necesitan en el navbar y footer
     */
    protected function cargarConfiguracionesGlobales()
    {
        // Cargar configuración de la tienda
        $this->configuracionTienda = $this->configuracionModel->getConfiguracion();
        
        // Cargar categorías para el navbar
        $this->categoriasGlobales = $this->categoriaModel->getCategoriasParaMostrar();

        // Hacer disponibles las configuraciones globales para todas las vistas
        $this->compartirConfiguracionesConVistas();
    }

    /**
     * Comparte las configuraciones globales con todas las vistas
     */
    protected function compartirConfiguracionesConVistas()
    {
        // Obtener la instancia del view service
        $view = service('renderer');
        
        // Compartir configuraciones globales con todas las vistas
        $view->setVar('configuracionTienda', $this->configuracionTienda);
        $view->setVar('categoriasGlobales', $this->categoriasGlobales);
        
        // También compartir variables específicas del footer
        $view->setVar('nombreTienda', $this->configuracionTienda['nombre_tienda'] ?? 'FOLLOW');
        $view->setVar('emailTienda', $this->configuracionTienda['email_tienda'] ?? '');
        $view->setVar('telefonoTienda', $this->configuracionTienda['telefono_tienda'] ?? '');
        $view->setVar('whatsappTienda', $this->configuracionTienda['whatsapp_tienda'] ?? '');
        $view->setVar('direccionTienda', $this->configuracionTienda['direccion_tienda'] ?? '');
        $view->setVar('facebookUrl', $this->configuracionTienda['facebook_url'] ?? '');
        $view->setVar('instagramUrl', $this->configuracionTienda['instagram_url'] ?? '');
        $view->setVar('twitterUrl', $this->configuracionTienda['twitter_url'] ?? '');
        $view->setVar('whatsappUrl', $this->configuracionTienda['whatsapp_url'] ?? '');
        $view->setVar('horarioAtencion', $this->configuracionTienda['horario_atencion'] ?? '');
    }

    /**
     * Método helper para obtener configuraciones específicas
     */
    protected function obtenerConfiguracion($clave, $valorPorDefecto = '')
    {
        return $this->configuracionTienda[$clave] ?? $valorPorDefecto;
    }

    /**
     * Método helper para obtener categorías
     */
    protected function obtenerCategorias()
    {
        return $this->categoriasGlobales;
    }
}