<?php

class ArchillectGrabber
{
	const ARCHILLECT_HOST = 'http://archillect.com';

	private $path;

	/**
	 * @param string $path
	 */
	public function __construct(string $path)
	{
		$this->path = $path;
	}

	/**
	 * @param int $id
	 */
	public function saveImage(int $id)
	{
		$content = file_get_contents(sprintf('%s/%d', self::ARCHILLECT_HOST, $id));
		$dom = new \DomDocument('1.0','utf-8');	
		@$dom->loadHtml($content, LIBXML_ERR_NONE);

		$imageSrc = $dom->getElementById('ii')->getAttribute('src');
		$imageContent = file_get_contents($imageSrc);

		$fileInfo = new finfo(FILEINFO_MIME);
		$imageMime = $fileInfo->buffer($imageContent);

		if (false !== strpos($imageMime, 'image/gif')) {
			$type = '.gif';
		} elseif(false !== strpos($imageMime, 'image/png')) {
			$type = '.png';
		} elseif(false !== strpos($imageMime, 'image/jpeg')) {
			$type = '.jpg';
		}

		if (true === isset($type)) {
			file_put_contents(sprintf('%s/%d%s', $this->path, $id, $type), $imageContent);
			echo "done".PHP_EOL;
		}

		unset($dom);
	}
}