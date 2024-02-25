<?php

declare(strict_types=1);

use App\Application\Actions\Markdown\AppMarkdownAction;
use App\Application\Actions\Markdown\ViewPrivacyPolicyMarkdownAction;
use App\Application\Actions\Markdown\ViewTermsOfUseMarkdownAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/health', function (Request $request, Response $response) {
        $response->getBody()->write(json_encode(['status' => 'ok']));
        return $response;
    });

    $app->get('/app/rules', AppMarkdownAction::class);

    $app->group('/view', function (Group $group) {
        $group->get('/privacy_policy', ViewPrivacyPolicyMarkdownAction::class);
        $group->get('/terms_of_use', ViewTermsOfUseMarkdownAction::class);
    });
};
