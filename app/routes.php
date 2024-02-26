<?php

declare(strict_types=1);

use App\Application\Actions\Markdown\AppMarkdownAction;
use App\Application\Actions\Markdown\TextPrivacyPolicyMarkdownAction;
use App\Application\Actions\Markdown\TextTermsOfUseMarkdownAction;
use App\Application\Actions\Markdown\ViewPrivacyPolicyMarkdownAction;
use App\Application\Actions\Markdown\ViewTermsOfUseMarkdownAction;
use App\Application\Actions\Dgo\CreateDgoAction;
use App\Application\Actions\Dgo\UpsertDgoAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Middleware\BearerAuthMiddleware;

return function (App $app) {
    // UnauthenticatedAPI
    $app->get('/health', function (Request $request, Response $response) {
        $response->getBody()->write(json_encode(['status' => 'ok']));
        return $response;
    });
    $app->get('/privacy_policy', TextPrivacyPolicyMarkdownAction::class);
    $app->get('/terms_of_use', TextTermsOfUseMarkdownAction::class);

    // UnauthenticatedWEB
    $app->get('/app/rules', AppMarkdownAction::class);
    $app->group('/view', function (Group $group) {
        $group->get('/privacy_policy', ViewPrivacyPolicyMarkdownAction::class);
        $group->get('/terms_of_use', ViewTermsOfUseMarkdownAction::class);
    });

    // AuthenticatedAPI
    $app->get('/get-samples', function (Request $request, Response $response) {
        $response->getBody()->write(json_encode(explode(',', file_get_contents($_ENV['ROOT_DIR'] . '/resources/samples.txt')), JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    })->add(BearerAuthMiddleware::class);
    
    $app->get('/get-dai-go', CreateDgoAction::class)->add(BearerAuthMiddleware::class);
    $app->post('/upsert-dai-go', UpsertDgoAction::class)->add(BearerAuthMiddleware::class);
};
