<?php 
/**
 * Pimcore
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.pimcore.org/license
 *
 * @copyright  Copyright (c) 2009-2010 elements.at New Media Solutions GmbH (http://www.elements.at)
 * @license    http://www.pimcore.org/license     New BSD License
 */
 
class Pimcore_Document {

    /**
     * @param null $adapter
     * @return null|Pimcore_Document_Adapter_Imagick
     * @throws Exception
     */
    public static function getInstance ($adapter = null) {
        try {
            if($adapter) {
                $adapterClass = "Pimcore_Document_Adapter_" . $adapter;
                if(Pimcore_Tool::classExists($adapterClass)) {
                    return new $adapterClass();
                } else {
                    throw new Exception("document-transcode adapter `" . $adapter . "´ does not exist.");
                }
            } else {
                return new Pimcore_Document_Adapter_Imagick();
            }
        } catch (Exception $e) {
            Logger::crit("Unable to load document adapter: " . $e->getMessage());
            throw $e;
        }

        return null;
    }

    /**
     * @return bool
     */
    public static function isAvailable () {
        try {
            if(extension_loaded("imagick")) {
                return true;
            }
        } catch (Exception $e) {
            Logger::warning($e);
        }

        return false;
    }
}
