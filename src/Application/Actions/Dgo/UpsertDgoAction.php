<?php

declare(strict_types=1);

namespace App\Application\Actions\Dgo;

use Psr\Http\Message\ResponseInterface as Response;

class UpsertDgoAction extends DgoAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $posts = $this->request->getParsedBody();
        if (!isset($posts['word']) || !isset($posts['dai_go']) || empty($posts['word']) || empty($posts['dai_go'])) {
            $this->response->getBody()->write(json_encode(['save' => 'parameter is empty'], JSON_UNESCAPED_UNICODE));
            return $this->response->withStatus(400);
        }

        $wordList = explode("\n", file_get_contents($_ENV['RESOURCES_DIR'] . 'words.txt'));
        $words = [];
        foreach ($wordList as $word) {
            $text = explode('=', $word);
            $words[$text[0]] = $text[1];
        }
        $words[$posts['word']] = $posts['dai_go'];
        $newWordList = '';
        foreach ($words as $key => $value) {
            $newWordList .= $key . '=' . $value . "\n";
        }
        file_put_contents(
            $_ENV['RESOURCES_DIR'] . 'words.txt',
            mb_substr($newWordList, 0, mb_strlen($newWordList) - 1)
        );

        // $this->response->getBody()->write(json_encode(['save' => 'success'], JSON_UNESCAPED_UNICODE));
        $this->response->getBody()->write(json_encode(['save' => $posts], JSON_UNESCAPED_UNICODE));
        return $this->response;
    }
}
