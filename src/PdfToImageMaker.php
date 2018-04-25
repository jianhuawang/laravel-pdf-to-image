<?php

namespace JianhuaWang\PdfToImage;

/**
 * split pdf file and save as image by one page
 * 
 */
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PdfToImageMaker
{

    protected $imageMaker;
    protected $imagick;
    protected $resolutionX = 100;
    protected $resolutionY = 100;
    protected $format = 'jpg';
    protected $quality = '100';
    protected $currentPage = 1;
    protected $offset = 0;
    protected $totalPages;
    protected $pdfDisk = 'local';
    protected $imageDisk = 'local';
    protected $distDir;
    protected $imagePrefix;

    /**
     * pdf file name which needed to be converted to image
     * @var string
     */
    protected $pdfFile = '';

    public function __construct($pdfFileName = '')
    {
        $this->pdfFile = $pdfFileName;
    }

    public function __call($name, $parameters)
    {
        return $this->getImageMaker()->$name(...$parameters);
    }

    public function pdfDisk($name = '')
    {
        if (empty($name)) {
            return $this->pdfDisk;
        }
        $this->pdfDisk = $name;
        return $this;
    }

    public function imageDisk($name = '')
    {
        if (empty($name)) {
            return $this->imageDisk;
        }
        $this->imageDisk = $name;
        return $this;
    }

    public function pdfFile($filename = '')
    {
        if (empty($filename)) {
            return $this->pdfFile;
        }
        $this->pdfFile = $filename;

        return $this;
    }

    public function currentPage($page = 1)
    {
        if (empty($page)) {
            return $this->currentPage;
        }
        $this->currentPage = $page;
        return $this;
    }

    public function offset($number = 0)
    {
        if (empty($number)) {
            return $this->offset;
        }
        $this->offset = $number;
        return $this;
    }

    public function resolution($resolutionX, $resolutionY)
    {
        $this->resolutionX = $resolutionX;
        $this->resolutionY = $resolutionY;
        return $this;
    }

    public function getResolution()
    {
        return [$this->resolutionX, $this->resolutionY];
    }

    public function getResolutionX()
    {
        return $this->resolutionX;
    }

    public function getResolutionY()
    {
        return $this->resolutionY;
    }

    public function distDir($dir = '')
    {
        if (empty($dir)) {
            return $this->distDir;
        }

        $this->savedAs = $dir;
        return $this;
    }

    public function imagePrefix($prefix = '')
    {
        if (empty($prefix)) {
            return $this->imagePrefix = $prefix;
        }
        $this->imagePrefix = $prefix;
        return $this;
    }

    public function quality($value = 0)
    {
        if (empty($value)) {
            return $this->quality;
        }

        $this->quality = $value;
        return $this;
    }

    public function format($type = '')
    {
        if ($type) {
            return $this->format;
        }

        $this->format = $type;
        return $this;
    }

    public function totalPages()
    {
        return $this->totalPages;
    }

    /**
     * 
     * 
     * @return \Intervention\Image\Image
     */
    public function getImageMaker()
    {
        return Image::make($this->getImagick($this->currentPage));
    }

    /**
     * 初始化并返回imagick实例
     */
    protected function getImagick($pagePointer)
    {
        $pdfStorage = Storage::disk($this->pdfDisk);
        $pdfFileName = $pdfStorage->path($this->pdfFile);

        $imagick = new \imagick();
        //压缩率
        $imagick->setResolution($this->resolutionX, $this->resolutionY);

        //读取当前页
        $imagick->readimage($pdfFileName . "[$pagePointer]");

        return $imagick;
    }

    /**
     * save one page as image
     * 
     * @param int $pagePointer which page should be converted
     * @return bool
     */
    public function saveImage($pagePointer = 1)
    {
        $imageWriter = $this->getImagick($pagePointer);

        $imageContent = Image::make($imageWriter)->encode($this->format, $this->quality);

        $distDir = $this->solveDistDir();
        $imageName = $this->solveDistImageName($pagePointer);

        $imageStorage = Storage::disk($this->imageDisk);

        return $imageStorage->put($distDir . DIRECTORY_SEPARATOR . $imageName, $imageContent);
    }

    /**
     * convert angd save images defined by currentPage and offset
     * 
     * @return boolean
     * @throws \ImagickException
     */
    public function saveImages()
    {
        $start = max($this->currentPage - 1, 0);

        $imagick = $this->getImagick($start);
        $totalPages = (int) $imagick->getnumberimages();
        $this->totalPages = $totalPages;

        $end = intval($start + $this->offset);
        $end = min($totalPages, $end);

        for ($i = $start; $i <= $end; $i++) {
            $this->saveImage($i);
        }

        return true;
    }

    protected function solveDistImageName($page)
    {
        return $this->solvePrefix() . $page . '.' . $this->format;
    }

    /**
     * 
     * @return string
     */
    protected function solvePrefix()
    {
        if (!$this->imagePrefix) {
            $this->imagePrefix = strval(time()) . '_';
        }
        return $this->imagePrefix;
    }

    /**
     * 
     * @return string
     */
    protected function solveDistDir()
    {
        if (!$this->distDir) {
            $this->distDir = date("Ymd", time());
        }

        $this->distDir=trim("/" . $this->distDir . "\\", "/");
        return trim( $this->distDir , "\\");
    }

}
