<?php

namespace LOCKSSOMatic\PluginBundle\Plugins;

use Doctrine\ORM\EntityManager;
use LOCKSSOMatic\PluginBundle\Entity\LomPluginData;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Base class for plugins.
 */
abstract class AbstractPlugin extends ContainerAware
{

    /**
     * Get the name of the plugin.
     * 
     * @return string
     */
    abstract function getName();

    /**
     * Get a description of the plugin.
     * 
     * @return string
     */
    abstract function getDescription();

    /**
     * 
     * @param type $object
     * @param type $key
     * @return LomPluginData
     */
    private function getDataObject($key, $object = null)
    {
        $domain = null;
        $objectId = null;
        if ($object !== null && is_object($object)) {
            $domain = get_class($object);
            $objectId = $object->getId();
        } else if ($object !== null && is_string($object)) {
            $domain = $object;
        }

        /** @var EntityManager */
        $em = $this->container->get('doctrine')->getManager();
        $repo = $em->getRepository('LOCKSSOMaticPluginBundle:LomPluginData');
        $data = $repo->findOneBy(array(
            'plugin'   => get_class($this),
            'domain'   => $domain,
            'objectId' => $objectId,
            'datakey'  => $key,
        ));
        return $data;
    }

    public function getData($key, $object = null)
    {
        $data = $this->getDataObject($key, $object);
        if ($data === null) {
            return null;
        }
        $value = $data->getValue();
        $res = unserialize($value);
        return $res;
    }

    public function setData($key, $object = null, $value = null)
    {
        $data = $this->getDataObject($object, $key);
        if ($data === null) {
            $data = new LomPluginData();            
            $this->container->get('doctrine')->getManager()->persist($data);
            $data->setPlugin(get_class($this));
            $data->setDataKey($key);
            if ($object !== null && is_object($object)) {
                $data->setDomain(get_class($object));
                $data->setObjectId($object->getId());
            } else if ($object !== null && is_string($object)) {
                $data->setDomain($object);
            }
        }
        $data->setValue(serialize($value));
        $this->container->get('doctrine')->getManager()->flush();
    }

    public function __toString()
    {
        return $this->getName();
    }

}
