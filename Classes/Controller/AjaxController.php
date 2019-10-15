<?php
declare(strict_types=1);

namespace GeorgRinger\Uri2Link\Controller;


use GeorgRinger\Uri2Link\Service\UrlParser;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AjaxController
{

    public function checkAction(ServerRequestInterface $request): JsonResponse
    {
        $uri = $request->getQueryParams()['uri'];
        $response = [];
        $parser = GeneralUtility::makeInstance(UrlParser::class);

        try {
            $newValue = $parser->parse($uri);
            if ($newValue !== $uri) {
                $response['transformed'] = $newValue;
                $response['status'] = true;
            }
        } catch (\Exception $exception) {
            $response['false'] = true;
            $response['message'] = $exception->getMessage();
        }
        return new JsonResponse($response);
    }

}
