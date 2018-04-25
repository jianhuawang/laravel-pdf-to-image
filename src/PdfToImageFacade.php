<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JianhuaWang\PdfToImage;

/**
 * Description of PdfToImageFacade
 *
 * @author jianhua.wang
 */
use Illuminate\Support\Facades\Facade;

class PdfToImageFacade extends Facade
{

    /**
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'PdfToImage';
    }

}
