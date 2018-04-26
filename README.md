# laravel-pdf-to-image
Convert pdf files to images for Laravel 5


Laravel 5下的 PDF 转图片工具包，
<p>本包提供了Laravel 5 把pdf文件转换为图片的功能, 同时基于Laravel Storage 对生成的图片进行存储和管理。</p>
<h4>功能列表：</h4>
<ol>
<li>按页转换PDF文件为图片，每页生成张图片</li>
<li>保存到指定的存储空间</li>
<li>支持云存储(测试中)</li>
<li>支持定时任务后台转换图片(开发中)</li>
<li>支持队列转换图片(开发中)</li>
</ol>

<h4>用法Usage:</h4>
<ol>
  <li>
    <p>
      $pdfFileNameWithPath='test.pdf';
      
      $converter=new JianhuaWang\PdfToImage\PdfToImageMaker($pdfFileNameWithPath);
      $converter->saveImage();
    </p>
    <p>
      Above code will read pdf file on (project root) + /storage/app/test.pdf, and convert first page to image, the image will be saved on (project root) + /storage/app/(current date)/(seconds).jpg
      </p>
  </li>
  <li>
  <p>
    The following code has same function with above.
  </p>
  <p>
    use PdfToImage;
    
    PdfToImage::pdfFile('test.pdf')->saveImage();
    </p>
    
</li>
</ol>
