<?php

namespace TastPHP\FrontBundle\Controller;

use TastPHP\Common\Controller;
use TastPHP\Framework\Http\Request;

class HomeController extends Controller
{
    public function indexAction()
    {
//        $ipsReal = $this->get('redis')->hGetAll('ips');
        $ipsAll = $this->get('redis')->hGetAll('ips_all');

        $services = $this->get('redis')->hGetAll('services');
        $serviceStatus = $this->get('redis')->hGetAll('s_status');

        $data = [];

        foreach ($ipsAll as $ip => $weight) {
            $data[$ip]['status'] = $serviceStatus[$ip];
            $data[$ip]['weight'] = $weight;
            $data[$ip]['serviceName'] = $services[$ip];
        }

        return $this->render('home/index.html.twig', [
            'data' => $data
        ]);
    }

    public function modifyWeightAction(Request $request)
    {
        if (empty($request->request->get("weight")) || empty($request->request->get("ip"))) {
            echo -1;
        }

        $weight = $request->request->get("weight");
        $ip = $request->request->get("ip");

        $this->get('redis')->hSet('ips_all', $ip, $weight);
        $this->get('redis')->hSet('ips', $ip, $weight);

        echo 1;
    }
}