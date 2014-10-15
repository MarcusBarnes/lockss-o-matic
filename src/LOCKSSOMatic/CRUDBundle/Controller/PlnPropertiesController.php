<?php

namespace LOCKSSOMatic\CRUDBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use LOCKSSOMatic\CRUDBundle\Entity\PlnProperties;
use LOCKSSOMatic\CRUDBundle\Form\PlnPropertiesType;

/**
 * PlnProperties controller.
 *
 */
class PlnPropertiesController extends Controller
{

    /**
     * Lists all PlnProperties entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LOCKSSOMaticCRUDBundle:PlnProperties')->findAll();

        return $this->render('LOCKSSOMaticCRUDBundle:PlnProperties:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PlnProperties entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PlnProperties();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('plnproperties_show', array('id' => $entity->getId())));
        }

        return $this->render('LOCKSSOMaticCRUDBundle:PlnProperties:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a PlnProperties entity.
     *
     * @param PlnProperties $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PlnProperties $entity)
    {
        $form = $this->createForm(new PlnPropertiesType(), $entity, array(
            'action' => $this->generateUrl('plnproperties_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PlnProperties entity.
     *
     */
    public function newAction()
    {
        $entity = new PlnProperties();
        $form   = $this->createCreateForm($entity);

        return $this->render('LOCKSSOMaticCRUDBundle:PlnProperties:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PlnProperties entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LOCKSSOMaticCRUDBundle:PlnProperties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlnProperties entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LOCKSSOMaticCRUDBundle:PlnProperties:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PlnProperties entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LOCKSSOMaticCRUDBundle:PlnProperties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlnProperties entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LOCKSSOMaticCRUDBundle:PlnProperties:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PlnProperties entity.
    *
    * @param PlnProperties $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PlnProperties $entity)
    {
        $form = $this->createForm(new PlnPropertiesType(), $entity, array(
            'action' => $this->generateUrl('plnproperties_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PlnProperties entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LOCKSSOMaticCRUDBundle:PlnProperties')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PlnProperties entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('plnproperties_edit', array('id' => $id)));
        }

        return $this->render('LOCKSSOMaticCRUDBundle:PlnProperties:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PlnProperties entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LOCKSSOMaticCRUDBundle:PlnProperties')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PlnProperties entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('plnproperties'));
    }

    /**
     * Creates a form to delete a PlnProperties entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plnproperties_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
