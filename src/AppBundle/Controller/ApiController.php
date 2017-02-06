<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Products;

class ApiController extends Controller {

    /**
     * @Route("/product/getall", name="product_getall")
     */
    public function getAllProductAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('Action getallProductAction triggered with method ' . $request->getMethod());
        $response = new JsonResponse();
        $responseData = $this->formatDataResponse();
        if ($this->isMethod('GET', $request)) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT p
    FROM AppBundle:Products p
    WHERE p.isactive = :isactive')
                    ->setParameter('isactive', true);

            $products = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            $responseData = $this->formatDataResponse(
                    '', true, $products ? count($products) : 0, $products
            );
        }
        $response->setData($responseData);
        return $response;
    }

    /**
     * @Route("/product/getsingle/{id}", name="product_getsingle")
     */
    public function getSingleProductAction($id, Request $request) {
        $logger = $this->get('logger');
        $logger->info('Action getSingleProductAction triggered with method ' . $request->getMethod());
        $response = new JsonResponse();
        $responseData = $this->formatDataResponse();

        if ($this->isMethod('GET', $request)) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT p
    FROM AppBundle:Products p
    WHERE p.isactive = :isactive
    AND p.id = :id')
                    ->setParameter('isactive', true)
                    ->setParameter('id', $id);

            $products = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            $responseData = $this->formatDataResponse(
                    '', true, $products ? count($products) : 0, $products ? $products[0] : []
            );
        }
        $response->setData($responseData);
        return $response;
    }

    /**
     * @Route("/category/getall", name="category_getall")
     */
    public function getAllCategoriesAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('Action getallCategoriesAction triggered with method ' . $request->getMethod());
        $response = new JsonResponse();
        $responseData = $this->formatDataResponse();

        if ($this->isMethod('GET', $request)) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT c
    FROM AppBundle:Categories c');

            $categories = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            $response = new JsonResponse();
            $responseData = $this->formatDataResponse(
                    '', true, $categories ? count($categories) : 0, $categories
            );
        }
        $response->setData($responseData);
        return $response;
    }

    /**
     * @Route("/category/getsingle/{id}", name="category_getsingle")
     */
    public function getSingleCategoryAction($id, Request $request) {
        $logger = $this->get('logger');
        $logger->info('Action getsingleCategoryAction triggered with method ' . $request->getMethod());
        $response = new JsonResponse();
        $responseData = $this->formatDataResponse();

        if ($this->isMethod('GET', $request)) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT c
    FROM AppBundle:Categories c
    WHERE c.id = :id')
                    ->setParameter('id', $id);

            $categories = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
            $response = new JsonResponse();
            $responseData = $this->formatDataResponse(
                    null, true, $categories ? count($categories) : 0, $categories ? $categories[0] : []
            );
            ;
        }
        $response->setData($responseData);
        return $response;
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */
    public function deleteProductAction($id, Request $request) {
        $logger = $this->get('logger');
        $logger->info('Action deleteProductAction triggered with method ' . $request->getMethod() . ' by User ' . $this->getUserId());
        $response = new JsonResponse();
        if ($this->getUserId() === NULL) {
            $responseData = $this->formatDataResponse('Only authenicated users are allows to use this method');
            $response->setData($responseData);
            return $response;
        }
        $responseData = $this->formatDataResponse();
        if ($this->isMethod('DELETE', $request)) {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('AppBundle:Products')->find($id);
            if (!$product) {
                $responseData = $this->formatDataResponse('Invalid product id.');
                $logger->error("Invalid product ID $id for deleteProductAction by User " . $this->getUserId());
            } else {
                $em->remove($product);
                $em->flush();
                $responseData = $this->formatDataResponse('Product was deleted.', TRUE);
                $logger->error("Delete operation (deleteProductAction) completed for product $id by User " . $this->getUserId());
            }
        }
        $response->setData($responseData);
        return $response;
    }

    /**
     * @Route("/product/update", name="product_update")
     */
    public function updateProductAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('Action updateProductAction triggered with method ' . $request->getMethod() . ' by User ' . $this->getUserId());
        $response = new JsonResponse();
        if ($this->getUserId() === NULL) {
            $responseData = $this->formatDataResponse('Only authenicated users are allows to use this method');
            $response->setData($responseData);
            return $response;
        }
        $responseData = $this->formatDataResponse();
        if (empty($request->get('id'))) {
            $responseData = $this->formatDataResponse('No product ID supplied');
            $logger->error("No product ID supplied for updateProductAction by User " . $this->getUserId());
        } elseif ($this->isMethod(['PUT', 'POST', 'PATCH'], $request)) {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('AppBundle:Products')
                    ->find($request->get('id'));
            if (!$product) {
                $responseData = $this->formatDataResponse('Invalid product ID');
                $logger->error("Invalid product ID $id for updateProductAction by User " . $this->getUserId());
            } else {
                $product->setDataFromRequest($request, $this->getDoctrine());
                $product->setModifiedby($this->getRequestUser());
                if ($product->getCategoryid() === NULL || !$product->dataValid()) {
                    $responseData = $this->formatDataResponse('Invalid category ID or invalid');
                    $logger->error("Invalid category ID or invalid data for updateProductAction by User " . $this->getUserId());
                } else {
                    $em->flush();
                    $responseData = $this->formatDataResponse('Product updated', TRUE, 1, $product->getName());
                    $logger->info("Product ID $id updated (updateProductAction) by User " . $this->getUserId());
                }
            }
        }
        $response->setData($responseData);
        return $response;
    }

    /**
     * @Route("/product/create", name="product_create")
     */
    public function createProductAction(Request $request) {
        $logger = $this->get('logger');
        $logger->info('Action createProductAction triggered with method ' . $request->getMethod() . ' by User ' . $this->getUserId());
        $response = new JsonResponse();
        if ($this->getUserId() === NULL) {
            $responseData = $this->formatDataResponse('Only authenicated users are allows to use this method');
            $response->setData($responseData);
            return $response;
        }
        $responseData = $this->formatDataResponse();
        if ($this->isMethod(['PUT', 'POST'], $request)) {
            $product = new Products();
            $em = $this->getDoctrine()->getManager();
            $product->setDataFromRequest($request, $this->getDoctrine());
            $product->setCreatedby($this->getRequestUser());
            $product->setModifiedby($this->getRequestUser());
            if ($product->getCategoryid() === NULL || !$product->dataValid()) {
                //die(print_r($product->getCategoryid(), 1));
                $logger->error("Invalid category ID  or invalid data for updateProductAction by User " . $this->getUserId());
                $responseData = $this->formatDataResponse('Invalid category ID or invalid data');
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();
                $logger->info('Product created(createProductAction) with ID: ' . $product->getId() . ' by User ' . $this->getUserId());
                $responseData = $this->formatDataResponse('Product created', TRUE, 1, array('id' => $product->getId()));
            }
        }
        $response->setData($responseData);
        return $response;
    }

    /**
     * Used to format the response to it can be consistent
     * @param strong $message Message about response
     * @param boolean $completed Was the task completed
     * @param int $count Affected or returned records
     * @param mixed $data Data associated with query
     * @return array
     */
    protected function formatDataResponse($message = 'Incorrect request method.', $completed = FALSE, $count = 0, $data = NULL) {
        $responseDate = new \DateTime('now');
        return compact(array('count', 'completed', 'message', 'data', 'responseDate'));
    }

    /**
     * Checks if the request method is of specified type.
     * @param mixed $method Name of method and array of method names to check
     * @param Request $request
     * @return boolean
     */
    protected function isMethod($method, Request $request) {
        if (!is_array($method)) {
            $method = array($method);
        }
        if (in_array($request->getMethod(), $method)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Used to return the User for the current request
     * Null is returned if user is not logged in
     * @return AppBundle\Entity\Users
     */
    protected function getRequestUser() {
        if ($this->getUserId()) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:Users')->find($this->getUserId());
            return $user;
        } else {
            return null;
        }
    }

    /**
     * Returns the ID for the user of the current request
     * Null is returned if user is not logged in
     * @return int
     */
    protected function getUserId() {
        return $this->getUser() ? $this->getUser()->getId() : NULL;
    }

}
