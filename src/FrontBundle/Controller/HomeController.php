<?php

namespace TastPHP\FrontBundle\Controller;

use TastPHP\Common\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $ipsReal = $this->get('redis')->hGetAll('ips');
        $ipsAll = $this->get('redis')->hGetAll('ips_all');
        $services = $this->get('redis')->hGetAll('services');
        $serviceStatus = $this->get('redis')->hGetAll('s_status');

        $data = [];

        foreach ($ipsAll as $ip => $weight) {
            $data[$ip]['status'] = $serviceStatus[$ip];
            $data[$ip]['weight'] = $weight;
            $data[$ip]['serviceName'] = $services[$ip];
        }

        return $this->render('home/index.html.twig',[
            'data' => $data
        ]);
    }
}