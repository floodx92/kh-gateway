<?php

namespace Floodx92\KhGateway;

use Floodx92\KhGateway\Contract\CryptoInterface;
use Floodx92\KhGateway\Contract\HttpClientInterface;
use Floodx92\KhGateway\Enum\ReturnMethod;
use Floodx92\KhGateway\Exception\HttpException;
use Floodx92\KhGateway\Model\Request\ApplePayInitRequest;
use Floodx92\KhGateway\Model\Request\ApplePayProcessRequest;
use Floodx92\KhGateway\Model\Request\EchoRequest;
use Floodx92\KhGateway\Model\Request\GooglePayProcessRequest;
use Floodx92\KhGateway\Model\Request\OneClickEchoRequest;
use Floodx92\KhGateway\Model\Request\OneClickInitRequest;
use Floodx92\KhGateway\Model\Request\OneClickProcessRequest;
use Floodx92\KhGateway\Model\Request\PaymentCloseRequest;
use Floodx92\KhGateway\Model\Request\PaymentInitRequest;
use Floodx92\KhGateway\Model\Request\PaymentProcessRequest;
use Floodx92\KhGateway\Model\Request\PaymentRefundRequest;
use Floodx92\KhGateway\Model\Request\PaymentReverseRequest;
use Floodx92\KhGateway\Model\Request\PaymentStatusRequest;
use Floodx92\KhGateway\Model\Response\ApplePayEchoResponse;
use Floodx92\KhGateway\Model\Response\EchoResponse;
use Floodx92\KhGateway\Model\Response\GooglePayEchoResponse;
use Floodx92\KhGateway\Model\Response\GooglePayInitRequest;
use Floodx92\KhGateway\Model\Response\InitResponse;
use Floodx92\KhGateway\Model\Response\OneClickEchoResponse;
use Floodx92\KhGateway\Model\Response\PaymentInitResponse;
use Floodx92\KhGateway\Model\Response\PaymentResponse;
use Floodx92\KhGateway\Model\Response\PaymentStatusResponse;
use Floodx92\KhGateway\Model\Response\ProcessResponse;
use JsonMapper\JsonMapperFactory;
use JsonMapper\JsonMapperInterface;

class ApiService
{
    private JsonMapperInterface $mapper;

    public function __construct(
        private readonly CryptoInterface $crypto,
        private readonly HttpClientInterface $httpClient,
    ) {
        $this->mapper = (new JsonMapperFactory())->bestFit();
    }

    /**
     * @template T
     *
     * @param class-string<T> $responseClass
     *
     * @return T
     *
     * @throws HttpException
     */
    private function checkResult(?\stdClass $result, string $responseClass)
    {
        if (null === $result) {
            throw new HttpException('Invalid response (null)', 400);
        }

        $response = $this->mapper->mapObject($result, new $responseClass());
        if (!$this->crypto->verifySignature($response, $response->signature)) {
            throw new HttpException('Invalid response signature', 400);
        }

        return $response;
    }

    /**
     * @throws HttpException
     */
    public function echo(EchoRequest $request, ReturnMethod $method = ReturnMethod::POST): EchoResponse
    {
        $this->crypto->createSignature($request);

        $result = match ($method) {
            ReturnMethod::POST => $this->httpClient->post('/echo', $request->toArray()),
            ReturnMethod::GET => $this->httpClient->get(sprintf('/echo/%s/%s/%s', $request->merchantId, $request->dttm ?? '', urlencode($request->signature))),
        };

        return $this->checkResult($result, EchoResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function googlePayProcess(GooglePayProcessRequest $request): ProcessResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/googlepay/process', $request->toArray());

        return $this->checkResult($result, ProcessResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function googlePayInit(GooglePayInitRequest $request): InitResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/googlepay/init', $request->toArray());

        return $this->checkResult($result, InitResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function googlePayEcho(EchoRequest $request): GooglePayEchoResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/googlepay/echo', $request->toArray());

        return $this->checkResult($result, GooglePayEchoResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function applePayProcess(ApplePayProcessRequest $request): ProcessResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/applepay/process', $request->toArray());

        return $this->checkResult($result, ProcessResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function applePayEcho(EchoRequest $request): ApplePayEchoResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/applepay/echo', $request->toArray());

        return $this->checkResult($result, ApplePayEchoResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function applePayInit(ApplePayInitRequest $request): InitResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/applepay/init', $request->toArray());

        return $this->checkResult($result, InitResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function oneClickEcho(OneClickEchoRequest $request): OneClickEchoResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/oneclick/echo', $request->toArray());

        return $this->checkResult($result, OneClickEchoResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function oneClickInit(OneClickInitRequest $request): InitResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/oneclick/init', $request->toArray());

        return $this->checkResult($result, InitResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function oneClickProcess(OneClickProcessRequest $request): ProcessResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/oneclick/process', $request->toArray());

        return $this->checkResult($result, ProcessResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function paymentStatus(PaymentStatusRequest $request): PaymentStatusResponse
    {
        $this->crypto->createSignature($request);

        $path = implode('/', array_filter([
            '/payment/status',
            $request->merchantId,
            $request->payId,
            $request->dttm,
            urlencode($request->signature),
        ]));

        $result = $this->httpClient->get($path);

        return $this->checkResult($result, PaymentStatusResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function paymentInit(PaymentInitRequest $request): PaymentInitResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->post('/payment/init', $request->toArray());

        return $this->checkResult($result, PaymentInitResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function paymentClose(PaymentCloseRequest $request): PaymentResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->put('/payment/close', $request->toArray());

        return $this->checkResult($result, PaymentResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function paymentReverse(PaymentReverseRequest $request): PaymentResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->put('/payment/reverse', $request->toArray());

        return $this->checkResult($result, PaymentResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function paymentRefund(PaymentRefundRequest $request): PaymentResponse
    {
        $this->crypto->createSignature($request);

        $result = $this->httpClient->put('/payment/refund', $request->toArray());

        return $this->checkResult($result, PaymentResponse::class);
    }

    /**
     * @throws HttpException
     */
    public function paymentProcess(PaymentProcessRequest $request): string
    {
        $this->crypto->createSignature($request);

        $path = implode('/', array_filter([
            '/payment/process',
            $request->merchantId,
            $request->payId,
            $request->dttm,
            urlencode($request->signature),
        ]));

        return $this->httpClient->get($path, 'Location');
    }
}
