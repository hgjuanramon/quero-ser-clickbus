<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AutomaticoController extends Controller {

    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    protected $_saldo = 0;
    protected $_billetes = array(100, 50, 20, 10);
    protected $_saldoInicial = 1000;

    public function __construct() {
        $this->recargarSaldo();
    }

    public function indexAction() {
        $billetesDenominaciones = $this->retirarDinero(130);
        $cobrar = $this->darDinero($billetesDenominaciones);
        $saldo_actual = $this->consultarSaldo();
        echo 'Saldo: '.$saldo_actual;
        echo 'Cantidad' .$billetesDenominaciones;
        print_ar($cobrar);
        $params = array('cobrar' => $cobrar, 'consultar' => $saldo_actual);
        return $params;
    }

    protected function recargarSaldo($cantidad = 0) {
        $this->_saldo = ($cantidad > 0) ? ($cantidad * 2) : $this->_saldoInicial;
    }

    public function retirarDinero($monto = 0) {

        if ($monto !== "") {
            if (is_numeric($monto)) {

                if (($monto % 10) !== 0) {
                    exit("Solo multiplos de 10");
                }
                if ($monto > 0) {
                    exit("Solo multiplos de 10");
                }
                // Saldo infinito
                if ($monto > $this->consultarSaldo()) {
                    $this->recargarSaldo($monto);
                }

                $billeteDenominaciones = array();

                $resto = $monto;

                foreach ($this->obtenerBilletesPorDenominacion() as $billete) {
                    if ($resto >= $billete) {
                        $billeteDenominaciones[$billete] = floor($resto / $billete);
                        $resto = ($resto % $billete);
                        if ($resto === 0) {
                            break;
                        }
                    }
                }
                $this->_saldo -= $monto;
                return $billeteDenominaciones;
            } else {
                exit('Solo Numeros');
            }
        } else {
            exit('Monto Vasio');
        }
    }

    public function darDinero($billeteDenominaciones) {
        $html = "[";
        foreach ($billeteDenominaciones as $key => $value) {
            for ($i = 0; $i < $value; $i++) {
                $html.=$key . ",";
            }
        }
        $html = rtrim($html, ",");
        $html .= "]";
        return $html;
    }

    public function consultarSaldo() {
        return $this->_saldo;
    }

// Hacer la ordenacion de la denominacion mas grande a la mas chica
    protected function obtenerBilletesPorDenominacion() {
        return $this->_billetes;
    }

}
