<?php

namespace Vted\PearyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ErrorLogController extends Controller
{
    public function monologAction(Request $request) {

        if(file_exists ( $this->get('kernel')->getRootDir().'../../app/logs/prod.log' )){
            // Symfony2
            $logFile = file_get_contents($this->get('kernel')->getRootDir().'../../app/logs/prod.log');
        }else{
            // Symfony3
            $logFile = file_get_contents($this->get('kernel')->getRootDir().'../../var/logs/prod.log');
        }

        $logs = explode("\n", $logFile);
        $logs = array_reverse($logs);

        foreach ($logs as $key => $log) {
            $pos = strpos($log, ']');
            $strtype= '';
            
            $typePos = 0;
            if( strpos($log, "INFO:") ){
                $typePos = strpos($log, "INFO:");
                $typePos+=3;
                $strtype= 'info';
            }elseif( strpos($log, "ERROR:") ){
                $typePos = strpos($log, "ERROR:");
                $typePos+=4;
                $strtype= 'error';
            }elseif( strpos($log, "CRITICAL:") ){
                $typePos = strpos($log, "CRITICAL:");
                $typePos+=7;
                $strtype= 'critical';
            }elseif( strpos($log, "DEBUG:") ){
                $typePos = strpos($log, "DEBUG:");
                $typePos+=4;
                $strtype= 'debug';
            }
            $logs[$key] = array(
                'date' => substr($log, 1, $pos-1),
                'type' => substr($log, $pos+1, $typePos-$pos),
                'content' => substr($log, $typePos+2),
            );

            // Filtre
            if( !$request->query->get('all') && in_array($strtype, array('debug','info'))){
                unset($logs[$key]);
            }

            // Limite 1 semaine
            if( strtotime(substr($log, 1, $pos-1)) < (time()-60*60*24*7) ){
                unset($logs[$key]);
            }
        }

        return $this->render('VtedPearyBundle:ErrorLog:monolog.html.twig',array(
            'logs' => $logs
        ));
    }

    public function exceptionAction(Request $request){
        $qb = $this->getDoctrine()->getManager()->getRepository('VtedPearyBundle:ErrorLog')
            ->createQueryBuilder('l')
            ->orderBy('l.createDate', 'desc');

        $logs = $this->get('knp_paginator')->paginate(
            $qb->getQuery(),
            $request->query->get('page', 1),
            25
        );

        return $this->render('VtedPearyBundle:ErrorLog:exception.html.twig',array(
            'logs' => $logs
        ));
    }
}