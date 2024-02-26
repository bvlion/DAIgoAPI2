<?php

declare(strict_types=1);

namespace App\Application\Actions\Dgo;

use Psr\Http\Message\ResponseInterface as Response;

use function DI\value;

class CreateDgoAction extends DgoAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        if (!isset($this->request->getQueryParams()['target'])) {
            $this->response->getBody()->write(json_encode(['text' => 'target is empty'], JSON_UNESCAPED_UNICODE));
            return $this->response->withStatus(400);
        }
        $target = $this->request->getQueryParams()['target'];
        if (empty($target)) {
            $this->response->getBody()->write(json_encode(['text' => 'target is empty'], JSON_UNESCAPED_UNICODE));
            return $this->response->withStatus(400);
        }

        $this->logger->info("target: " . $target);

        $wordList = explode("\n", file_get_contents($_ENV['ROOT_DIR'] . '/resources/words.txt'));
        $words = [];
        foreach ($wordList as $word) {
            $text = explode("=", $word);
            $words[$text[0]] = $text[1];
        }

        if (isset($words[$target])) {
            $this->response->getBody()->write(json_encode(['text' => $words[$target]], JSON_UNESCAPED_UNICODE));
            return $this->response;
        }

        $notExistList = explode("\n", file_get_contents($_ENV['ROOT_DIR'] . '/resources/notExists.txt'));
        foreach ($notExistList as $notExist) {
            $text = explode("=", $notExist);
            $target = str_replace($text[0], $text[1], $target);
        }

        exec("echo " . $target . " | " . $_ENV['MECAB'], $res);
        $daigo = '';
        if (is_array($res) && count($res)) {
                $this->logger->info("mecab: " . json_encode($res, JSON_UNESCAPED_UNICODE));
                foreach ($res as $v) {
                    $arr = explode(",", $v);
                    if (count($arr) < 4) continue;
                    $type = explode("\t", $arr[0]);
                    if ($type[1] === "助詞") continue;
                    if ($type[1] === "助動詞") continue;
                    if ($type[1] === "記号") continue;
                    if ($arr[2] === "助動詞語幹") continue;
                    if (count($arr) < 8) {
                        if (isset($type) && $type[1] === "名詞") {
                            $daigo .= $type[0];
                        }
                        continue;
                    };

                    $katakana = $arr[7];
                    $daigo .= $this->kana2alphabet($katakana);
                }
        }

        $this->logger->info("res: " . $daigo);
        $this->response->getBody()->write(json_encode(['text' => $daigo], JSON_UNESCAPED_UNICODE));
        return $this->response;
    }

    private function kana2alphabet(String $target): String {
        $checkWord = null;
        if (strlen($target) === 1) {
            $checkWord = "$target ";
        } else {
            $checkWord = $target;
        }
    
        $checkWordDouble = mb_substr($checkWord, 0, 2);
        if ($checkWordDouble  === "ジャ" || $checkWordDouble  === "ジュ" || $checkWordDouble  === "ジョ") {
            return "J";
        }

        switch (mb_substr($checkWord, 0, 1)) {
            case "ア": return 'A';
            case "イ": return "I";
            case "ウ": return "U";
            case "エ": return "E";
            case "オ": return "O";
            case "ジ": return "J";
            case "チ": return "C";
            case "カ":
            case "キ":
            case "ク":
            case "ケ":
            case "コ":
                return "K";
            case "ガ":
            case "ギ":
            case "グ":
            case "ゲ":
            case "ゴ":
                return "G";
            case "サ":
            case "シ":
            case "ス":
            case "セ":
            case "ソ":
                return "S";
            case "ザ":
            case "ズ":
            case "ゼ":
            case "ゾ":
                return "Z";
            case "タ":
            case "ツ":
            case "テ":
            case "ト":
                return "T";
            case "ダ":
            case "ヂ":
            case "ヅ":
            case "デ":
            case "ド":
                return "D";
            case "ナ":
            case "ニ":
            case "ヌ":
            case "ネ":
            case "ノ":
                return "N";
            case "ハ":
            case "ヒ":
            case "フ":
            case "ヘ":
            case "ホ":
                return "H";
            case "バ":
            case "ビ":
            case "ブ":
            case "ベ":
            case "ボ":
                return "B";
            case "パ":
            case "ピ":
            case "プ":
            case "ペ":
            case "ポ":
                return "P";
            case "マ":
            case "ミ":
            case "ム":
            case "メ":
            case "モ":
                return "M";
            case "ヤ":
            case "ユ":
            case "ヨ":
                return "Y";
            case "ラ":
            case "リ":
            case "ル":
            case "レ":
            case "ロ":
                return "R";
            case "ワ":
                return "W";
            default: return mb_substr($checkWord, 0, 1);
        }
    }
}
