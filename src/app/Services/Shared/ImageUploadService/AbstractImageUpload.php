<?php

namespace App\Services\Shared\ImageUploadService;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

abstract class AbstractImageUpload
{
  /**
   * The Driver of the storage
   */
  protected $driver = 'public';

  /**
   * Folder Path
   *
   * @var string
   */
  protected $basePath = '';

  /**
   * Image Quality
   *
   * @var integer
   */
  protected $quality = 80;

  /**
   * Image Format
   *
   * @var string
   */
  protected $format = 'jpg';

  /**
   * @var Storage
   */
  protected $storage;

  public function __construct()
  {
    $this->storage = Storage::disk($this->driver);
  }

  /**
   * upload image 
   * 
   * @param UploadedFile $image
   * @return string string filename
   * @throws Exception
   */
  public function upload(UploadedFile $image)
  {
    $this->checkReadiness();

    $filename = Str::uuid() . '.' . $this->format;

    $imageToUpload = Image::make($image)->encode($this->format, $this->quality);

    $this->storage->put(
      $this->basePath . '/' . $filename,
      $imageToUpload->stream()->__toString()
    );

    return $filename;
  }

  /**
   * delete image
   * 
   * @param string $filename
   * @return bool
   * @throws Exception
   */
  public function delete(string $filename)
  {
    $this->checkReadiness();

    return $this->storage->delete($this->basePath . '/' . $filename);
  }

  /**
   * Get image with path.
   *
   * @param string $filename
   * @throws Exception
   */
  public function getImageWithPath(string $filename)
  {
    $this->checkReadiness();

    return $this->storage->url($this->basePath . '/' . $filename);
  }

  /**
   * Check if image is exists
   * 
   * @param string filename
   * @return bool 
   * @throws Exception
   */
  public function exists(string $filename)
  {
    $this->checkReadiness();

    return $this->storage->exists($this->basePath . '/' . $filename);
  }

  /**
   * Check if service is ready to operate
   */
  protected function checkReadiness()
  {
    if (empty($this->basePath)) {
      throw new \Exception('Base Path not defined');
    }
  }
}
