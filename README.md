# laravel-pdf-to-image
Convert pdf files to images for Laravel.


Laravel 框架下的 PDF 转图片工具包，
<p>本包提供了Laravel 把pdf文件转换为图片的功能, 同时基于Laravel Storage 对生成的图片进行存储和管理。</p>
<h4>功能列表：</h4>
<ol>
<li>按页转换PDF文件为图片，每页生成1张图片</li>
<li>Convert every page of PDF fiel to one image.</li>
<li>保存到指定的存储空间</li>
<li>Save images to disk of Storage</li>
<li>支持云存储(测试中)</li>
<li>Save image to cloud disk.(Developing)</li>
<li>支持定时任务后台转换图片(开发中)</li>
<li>Convert PDF file to images by cron task.(Developing)</li>
</ol>
<h4>依赖 Package dependencies</h4>
<p>
   必须安装扩展包，You must install package imagick, 
  参考信息 more info: <a href="http://php.net/manual/en/book.imagick.php">http://php.net/manual/en/book.imagick.php</a>
<a href="http://php.net/manual/en/imagick.setup.php">http://php.net/manual/en/imagick.setup.php</a>
</p>
<p>
  "ext-imagick" : "*",<br/>
        "intervention/image": "^2.0",<br/>
        "illuminate/support": "5.*"<br/>
</p>
<p>
   执行 run:  php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5" <br/>
   then： you will find a new file image.php in folder config. Change " 'driver' => 'gd' " to "  'driver' => 'imagick' "
</p>

<h4>安装Installation:</h4>
<p>
    composer require jianhuawang/laravel-pdf-to-image:^0.4
</p>
<h5>Laravel >= 5.5, after install nothing left to do.</h5>
<h5>Laravel <5.5</h5>
<p>
  Add a provider in providers array in config/app.php:<br/>
  JianhuaWang\PdfToImage\PdfToImageMaker::class,<br/>
  Add a aliase in aliases array:<br/>
  'PdfToImage'=>JianhuaWang\PdfToImage\PdfToImageFacade::class,
</p>

<h4>用法Usage:</h4>
<ol>
  <li>
      Following code will read pdf file on (project root) + /storage/app/test.pdf, and convert first page to image, the image will be saved on (project root) + /storage/app/(current date)/(seconds).jpg
      $pdfFileNameWithPath='test.pdf';
      $converter=new JianhuaWang\PdfToImage\PdfToImageMaker($pdfFileNameWithPath);

      $converter->saveImage();// Default action is converting all pages to images.
  </li>
  <li>
      <p>
        The following codes has same function with above.
      </p>
      <p>
        use PdfToImage;
        PdfToImage::pdfFile('test.pdf')->saveImage();
      </p>
  </li>
</ol>
