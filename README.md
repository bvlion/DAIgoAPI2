# D◯I 語 API

DAIgoAPP（Android）向けの backend API です。

- PHP 8.5
- [Slim 4](https://www.slimframework.com/)
- [MeCab](https://taku910.github.io/mecab/) による形態素解析で D◯I 語を生成

## ディレクトリ構成

| パス | 役割 |
|:--|:--|
| `app/` | ルーティング (`routes.php`)・DIコンテナ定義 (`dependencies.php`)・アプリ設定 (`settings.php`) |
| `src/` | Actionクラスなどアプリケーション本体（PSR-4: `App\`） |
| `public/` | Webサーバの公開ルート。エントリーポイント `index.php` |
| `resources/` | API・Web画面が参照する実データ（単語リスト、利用規約/プライバシーポリシー等） |
| `tests/` | PHPUnitテスト（PSR-4: `Tests\`） |
| `docker/` | ローカル実行用（`slim`）・Composer実行用の Dockerfile / Apache・PHP設定 |
| `doc/` | APIドキュメント |

## ローカル開発

### 1. `.env` の準備

```
cp .env.example .env
```

`.env` はローカル専用のfileで、git管理対象外です。`RESOURCES_DIR` / `BEARER_TOKEN` / `MECAB` を保持します。既定値のままDocker Compose環境で動作します。

### 2. Composerでdependencyをinstall

```
docker compose up composer
```

### 3. アプリを起動

```
docker compose up slim -d
```

コンテナ内はPHP 8.5です。バージョン確認は以下で行えます。

```
docker compose exec slim php -v
```

起動後、`http://localhost:8000` でAPIへアクセスできます。

```
curl http://localhost:8000/health
```

`AuthenticatedAPI`（後述）は `.env` の `BEARER_TOKEN` を `Authorization: Bearer <token>` ヘッダーに設定してアクセスしてください。

### 4. コンテナの停止

```
docker compose down
```

## 品質確認

```
docker compose exec slim vendor/bin/phpcs
docker compose exec slim vendor/bin/phpstan
docker compose exec slim vendor/bin/phpunit
git diff --check
```

PHPUnit実行時は `phpunit.xml` 内で `RESOURCES_DIR` / `BEARER_TOKEN` / `MECAB` がテスト用の値に上書きされるため、`.env` の内容には依存しません。

## API docs

- [Authenticated API](/doc/AuthenticatedAPI.md)
- [Unauthenticated API](/doc/UnauthenticatedAPI.md)
- [Unauthenticated Web](/doc/UnauthenticatedWEB.md)

## CI / Deploy

- Pull Requestを作成すると `Tests` workflow（PHP 8.5でPHPCS / PHPStan / PHPUnitを実行）が起動します
- `Tests` はmainブランチのrequired status checkです
- `v*` タグをpushするとproduction deploy workflowが起動し、SSH経由でproductionサーバーへ反映します
- production側もPHP 8.5で、production専用のComposer (`composer.phar`) を使用します
- Dependabotが作成したPull Requestは、repository ownerがApproveし、required Tests / branch protectionを満たした場合にauto-mergeされます
