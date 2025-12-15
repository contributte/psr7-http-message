<?php declare(strict_types = 1);

namespace Contributte\Psr7\Bridge;

use Nette\Application\Response as ApplicationResponse;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Psr\Http\Message\ResponseInterface;

class Psr7Response implements ApplicationResponse
{

	public function __construct(
		private ResponseInterface $response,
	)
	{
	}

	public function getResponse(): ResponseInterface
	{
		return $this->response;
	}

	public function send(IRequest $httpRequest, IResponse $httpResponse): void
	{
		$this->sendStatus($httpResponse);
		$this->sendHeaders($httpResponse);
		$this->sendBody();
	}

	protected function sendStatus(IResponse $httpResponse): void
	{
		$httpResponse->setCode($this->response->getStatusCode(), $this->response->getReasonPhrase());
	}

	protected function sendHeaders(IResponse $httpResponse): void
	{
		foreach ($this->response->getHeaders() as $name => $values) {
			foreach ($values as $value) {
				$httpResponse->setHeader($name, $value);
			}
		}
	}

	protected function sendBody(): void
	{
		$stream = $this->response->getBody();
		$stream->rewind();

		while (!$stream->eof()) {
			echo $stream->read(8192);
		}
	}

}
