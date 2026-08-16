# Repository Guidelines

## プロジェクト概要

DAIgoAPI2 は、DAIgoAPP（Android）向けのbackend APIです。

- PHP 8.5 / [Slim 4](https://www.slimframework.com/)
- Docker Composeで `php:8.5-apache` コンテナ上に構築（ローカル実行はDocker前提）
- [MeCab](https://taku910.github.io/mecab/) による形態素解析
- Composerで依存管理
- PHPCS / PHPStan / PHPUnitで品質確認
- `v*` タグのpushでSSH経由のproduction deployが起動し、production側もPHP 8.5 + repository専用Composerを使用する

構成の詳細は [README.md](README.md) を参照してください。

## 変更方針

- Issueの解決に必要な最小限の差分にする
- 無関係なrefactoring / rename / formatting / dependency updateを混ぜない
- 変更前に実装・呼び出し元・`app/routes.php` のroutes・対応するtestsを確認する
- API contract（request/response仕様）を推測で変更しない
- Slimから別frameworkへ勝手に移行しない
- 変更対象外のファイルを一括整形しない
- 要件が不明確で複数の妥当な実装がある場合は、実装前にユーザーへ確認する

## PHP / Composer

- PHP 8.5を前提とする
- `composer.lock` を尊重し、意図しないdependency更新をしない
- dependencyを変更する場合は目的とcompatibilityを確認する
- productionだけ別のPHP versionへ戻すような変更をしない

## Build / Test

変更範囲に対応する検証を実行する。代表的なコマンド:

```
docker compose up composer
docker compose up slim -d
docker compose exec slim vendor/bin/phpcs
docker compose exec slim vendor/bin/phpstan
docker compose exec slim vendor/bin/phpunit
git diff --check
```

PHPUnit実行時、`RESOURCES_DIR` / `BEARER_TOKEN` / `MECAB` は `phpunit.xml` 内のテスト用値で上書きされ、ローカルの `.env` には依存しない。

検証を実行できなかった場合や失敗した場合は、成功したものとして扱わず、実行できなかった理由をPull Request本文へ記載する。

## 秘密情報 / local / production

- production credential、SSH鍵、token、Slack webhook URL等を差分やPull Request本文・ログへ含めない
- local設定の不足をダミーsecretのcommitで迂回しない
- `.env` はlocal専用（git管理対象外）として扱う。共有する値の例は `.env.example` にのみ置く
- production操作を行う場合は、Issueで許可された範囲かを確認する
- destructive operationや追加認証が必要な操作は、実行前にユーザーへ確認する

## Git / Pull Request

- mainへ直接commit / pushしない
- force push等の破壊的操作をしない
- Issue対応では 調査 → 実装 → 検証 → commit → push → Ready for reviewのPull Request作成 の順で進める
- Pull Request本文には対応Issue、目的、変更内容、最終検証結果を記載する
- 解消済みの途中経過や試行錯誤を大量に残さない
- ユーザーの承認なしに通常のPull Requestをmergeしない
- Issueを手動でcloseしない
- Dependabotが作成したPull Requestは、repository ownerがApproveし、required CI / branch protectionを満たした場合にauto-mergeしてよい
- Dependabotが作成したPull Requestを自動Approveしない
