<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\WebSite;
use App\Entity\SslResult;
use App\Form\WebSiteType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class WebSiteController extends Controller {

    public function index(Request $request) {

//        $form = $this->createForm(WebSiteType::class);

        $number = mt_rand(0, 100);
//        dump($number);
//         $form->handleRequest($request);
//          if ($form->isSubmitted() && $form->isValid()) {
//        // $form->getData() holds the submitted values
//        // but, the original `$task` variable has also been updated
//        $WebSite = $form->getData();
//
//        // ... perform some action, such as saving the task to the database
//        // for example, if Task is a Doctrine entity, save it!
//         $em = $this->getDoctrine()->getManager();
//         $em->persist($WebSite);
//         $em->flush();

        return $this->render('index.html.twig');
//    }
//        return $this->render('base.html.twig', array(
//                    'form' => $form->createView(),
//        ));
    }

    public function view(WebSite $website, UserInterface $user = null) {
        $result = array();
        $result["Url"] = $website->getbaseUrl();
        $result["Online"] = $website->isOnline();
        $result["StatutCode"] = $website->getStatutCode();
        $result["DNNByReverse"] = $website->getDNNByReverse();
        $result["ResponseTime"] = $website->getResponseTime();
        if ($website->getAdvanced()) {
            $result["readableAdvencedFile"] = $website->readableAdvencedFile();
        }
        $result["Ip4"] = $website->getIp4();
        $result["Ip6"] = $website->getIp6();
        $result["Headers"] = $website->getHeaders();
        $result["Image"] = $website->getScreenShot();
        if ($website->getSsl() == NULL) {
            $em = $this->getDoctrine()->getManager();
            $ssl = new SslResult($website);
            $website->setSsl($ssl);
            $em->persist($website);
            $em->flush();
//            $ssl = $website->getSSL();
        } else {
//            $ssl = $website->getSSL();
        }
//
        $sslGlobalNote = substr($website->getSsl()->getRankNote(), 0, 1);
//
        if (in_array($sslGlobalNote, array("A", "B"))) {
            $gradestate = "success";
        } elseif (in_array($sslGlobalNote, array("C", "D"))) {
            $gradestate = "warning";
        } elseif (in_array($sslGlobalNote, array("E", "F"))) {
            $gradestate = "danger";
        } else {
            $gradestate = "dark";
        }
        dump($result["Headers"]);
        return $this->render('Admin/view.html.twig', ["result" => $result, "website" => $website, "gradestate" => $gradestate]);
      
//        return new Response(
//                '<html><body></body></html>'
//        );
    }

    public function liste() {
        return $this->render('Admin/liste.html.twig');
    }

    public function addwebsite(Request $request, UserInterface $user = null) {
        $form = $this->createForm(WebSiteType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $WebSite = $form->getData();
            $WebSite->setClient($user);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($WebSite);
            $em->flush();

            return $this->render('Admin/addwebsite.html.twig');
        }
        return $this->render('Admin/addwebsite.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

//    public function testOnLine(Request $request, WebSite $website) {
//        $isAjax = $request->isXMLHttpRequest();
//        if ($isAjax) {
//            if ($website->getStatutCode() == 200) {
//                $r = true;
//            } else {
//                $r = FALSE;
//            }
//            $response = json_encode(
//                    array(
//                        'r' =>$r,
//                    )
//            );
//            return new Response($response, 200, array(
//                'Content-Type' => 'application/json'
//            ));
//        } else {
//            return new Response('Error', 403);
//        }
//    }
    
    public function ajaxResponseTime(Request $request, WebSite $website) {
        $isAjax = $request->isXMLHttpRequest();
        if ($isAjax) {
            $response = json_encode(
                    array(
                        'r' =>$website->getResponseTime(),
                    )
            );
            return new Response($response, 200, array(
                'Content-Type' => 'application/json'
            ));
        } else {
            return new Response('Error', 403);
        }
    }
    
    public function ajaxStatutCode(Request $request, WebSite $website) {
        $isAjax = $request->isXMLHttpRequest();
        if ($isAjax) {
            $response = json_encode(
                    array(
                        'r' =>$website->getStatutCode(),
                    )
            );
            return new Response($response, 200, array(
                'Content-Type' => 'application/json'
            ));
        } else {
            return new Response('Error', 403);
        }
    }
    
    public function ajaxImage(Request $request, WebSite $website) {
        $isAjax = $request->isXMLHttpRequest();
        if ($isAjax) {
            $response = json_encode(
                    array(
                        'r' =>$website->getScreenShot(TRUE),
                    )
            );
            return new Response($response, 200, array(
                'Content-Type' => 'application/json'
            ));
        } else {
            return new Response('Error', 403);
        }
    }
    
    public function ajaxHeaders(Request $request, WebSite $website) {
        $isAjax = $request->isXMLHttpRequest();
        if ($isAjax) {
            $response = json_encode(
                    array(
                        'r' =>$website->getHeaders(),
                    )
            );
            return new Response($response, 200, array(
                'Content-Type' => 'application/json'
            ));
        } else {
            return new Response('Error', 403);
        }
    }

}
