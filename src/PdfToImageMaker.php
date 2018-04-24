<?php

namespace JianhuaWang\PdfToImage;

use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfToImageMaker
{
    protected $imageMaker;
    
    protected $diskName;




    public function __construct()
    {
//        $this->diskName=
        $this->imageMaker=new Pdf();
                
    }
    
    public function disk($name)
    {
        if(empty($name)){
            return $this->diskName;
        }
        
//        Storage::disk(config('admin.upload.disk'))
    }
    
}