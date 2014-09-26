<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Form\ContactType;
// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OrdenacionController extends Controller {

    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction() {
        $data = $this->getData();
        if (!is_array($data) || count($data) <= 0) {
            exit("No existen datos");
        }

        try {
            $data = $this->orderData($data);
            $groups = array();
            $groupIndex = 0;
            $range = 10;
            $top = 0;

            // Recorrer los datos
            foreach ($data as $key => &$value) {
                // Cuando el valor sea mayor que el top inicial
                while ($value > $top) {
                    // incrementar el top hasta que sea mayor o igual
                    $top += $range;
                }

                if ($top >= $value) {
                    // Agregar el valor y agruparlo
                    $groups[$groupIndex][] = $value;

                    // Checar si aun hay un elemento despues del actual dentro del array
                    if (array_key_exists($key + 1, $data)) {
                        // Si encontramos un elemento
                        if ($data[$key + 1] > $top) {
                            // si es mayor incrementamos el top y cambiamos de index
                            $top += $range;
                            $groupIndex++;
                        }
                    }
                    // Ir eliminando los valores
                    unset($value);
                }
            }
            $params = array('groups' => $groups);

            return $this->render('AcmeDemoBundle:Ordenacion:index.html.twig', $params);
        } catch (Exception $e) {



            exit($e->getMessage());
        }
    }

    public function getData() {
        $data = array(10, 1, -20, 14, 99, 136, 19, 20, 117, 22, 93, 120, 131);
        //$data = null;
        return $data;
    }

    public function orderData($data = array()) {
        // Ordenar los numeros
        for ($i = 0; $i < count($data); $i++) {
            if (filter_var($data[$i], FILTER_VALIDATE_INT) === false) {
                exit("Solo numeros enteros");
            }

            for ($j = 0; $j < count($data); $j++) {
                if ($data[$i] < $data[$j]) {
                    $temp = $data[$i];
                    $data[$i] = $data[$j];
                    $data[$j] = $temp;
                }
            }
        }
        return $data;
    }

}
