<?php

namespace Acme\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function paginatorAction($min,$max){
        
          $client = \Elasticsearch\ClientBuilder::create()->build() ;
        
        $par = array(
            'index' => 'mi2s',
            'type'  => 'dataset',
            'from' =>  $min ,
            'size'  => $max-$min , 
            'body'  => array(
                'query' => array(
                    'bool' => array(
                        'should' => array(
                            array(
                                'match' => array(
                                    'licence' => 'GNU'
                                )
                            )
                        ,
                            array(
                                'match' => array(
                                    'type' => 'instrument'
                                )
                            )
                        ,
                            array(
                                'match' => array(
                                    'type' => 'TRACE'
                                )
                            )
                        )
                    )
                )
            )
        ) ;
        
         $response = $client->search($par);

    	
        return $this->render('AcmeMainBundle:Default:paginator.html.twig', 
                array(
                    'name' =>  $response['hits']['hits'] , 

                ));
        
        
    }
    
    
    public function indexAction($name,  \Symfony\Component\HttpFoundation\Request $request)
    {
             
        $client = \Elasticsearch\ClientBuilder::create()->build() ;
        
        $par = array(
            'index' => 'mi2s',
            'type'  => 'dataset',
            'from' =>  0 ,
            'size'  =>  10 , 
            'body'  => array(
                'query' => array(
                    'bool' => array(
                        'should' => array(
                            array(
                                'match' => array(
                                    'licence' => 'GNU'
                                )
                            )
                        ,
                            array(
                                'match' => array(
                                    'type' => 'instrument'
                                )
                            )
                        ,
                            array(
                                'match' => array(
                                    'type' => 'TRACE'
                                )
                            )
                        )
                    )
                )
            )
        ) ;
        
         $response = $client->search($par);

         $count  = sizeof($response['hits']['hits']) ; 
       

         
         $r1 = $client->search($par);
         
         
         print $count ; 
    	
        return $this->render('AcmeMainBundle:Default:index.html.twig', 
                array(
                    'name' => $name , 
                    'r1' =>  $r1['hits']['hits'] , 
                    'name' =>  $response['hits']['hits'] , 
                    'count' => $count
                ));
    }
}
