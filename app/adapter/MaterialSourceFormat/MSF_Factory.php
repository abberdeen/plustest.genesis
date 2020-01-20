<?php

namespace Adapter\MaterialSourceFormat;
use Adapter\MaterialSourceFormat\MSF;
use Adapter\MaterialSourceFormat\MSFQuery\MSF_MT2012_G_Query;
use Adapter\MaterialSourceFormat\MSFQuery\MSF_MT2017_G_Query;
use Adapter\MaterialSourceFormat\MSFQuery\MSF_PLUSTEST_Query;
use Adapter\MaterialSourceFormat\MSFQuery\MSF_IGX2018_Query;
use \AppException;



/**
 * Class MSF_Factory
 */
class MSF_Factory{
    /**
     * @param $connection
     * @param Material $material
     * @return MSF_IGX2018_Query|MSF_MT2012_G_Query|MSF_MT2017_G_Query|MSF_PLUSTEST_Query
     * @throws AppException
     */
    public static function createMSFQuery(&$connection,$material){
        switch($material->getSourceFormat()){
            case MSF::MT2012_G:
                return new MSF_MT2012_G_Query($connection,$material);
                break;
            case MSF::MT2017_G:
                return new MSF_MT2017_G_Query($connection,$material);
                break;
            case MSF::PLUSTEST:
                return new MSF_PLUSTEST_Query($connection,$material);
                break;
            case MSF::IGX2018:
                return new MSF_IGX2018_Query($connection,$material);
                break;
            default:
                throw new \AppException('Undefined  MSF',2101);
        }
    }
}