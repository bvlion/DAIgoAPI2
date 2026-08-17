# Unauthenticated WEB

## get /view/terms_of_use

Return terms of use html

### request

Content | Parameter | Description
:--|:--|:--

```
http://localhost:8000/view/terms_of_use
```

### response

Content | Parameter | Description
:--|:--|:--
html | `<!DOCTYPE HTML>` | terms of use


```
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>利用規約</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/4.0.0/github-markdown.min.css" rel="stylesheet" type="text/css" media="all"/>
  <link href="/default.css" rel="stylesheet" type="text/css" media="all"/>
  <link rel="icon" href="/favicon-192x192.png" sizes="192x192" type="image/png">
  <link rel="icon" href="/favicon.ico">
</head>
<body>
<div class="container main">
  <div class="markdown-body"><h1>【略語Generator】利用規約</h1>

<p>この規約は、bvlion（以下「当方」と言います。）が提供するアプリケーション【略語Generator】（以下「本アプリ」と言います。）を利用される皆様（以下「ユーザー」と言います。）がご利用頂く際の取扱いにつき定めるものです。本規約に必ず同意のうえご利用ください。</p>

<h2>第 1 条（本規約への同意）</h2>

<!-- 以下、resources/terms_of_use.md の内容がHTMLに変換されて続く（省略） -->
</div>
</div>
</body>
</html>
```

## get /view/privacy_policy

Return privacy policy html

### request

Content | Parameter | Description
:--|:--|:--

```
http://localhost:8000/view/privacy_policy
```

### response

Content | Parameter | Description
:--|:--|:--
html | `<!DOCTYPE HTML>` | privacy policy

```
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>プライバシーポリシー</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/4.0.0/github-markdown.min.css" rel="stylesheet" type="text/css" media="all"/>
  <link href="/default.css" rel="stylesheet" type="text/css" media="all"/>
  <link rel="icon" href="/favicon-192x192.png" sizes="192x192" type="image/png">
  <link rel="icon" href="/favicon.ico">
</head>
<body>
<div class="container main">
  <div class="markdown-body"><h1>【略語Generator】プライバシーポリシー</h1>

<p>当方が提供するアプリケーション「【略語Generator】以下「本アプリ」と言います。」において利用される皆様（以下「ユーザー」と言います。）から取得、提供いただいた個人に関する情報を以下のとおり取り扱います。</p>

<h2>1. 取得する情報と利用目的</h2>

<!-- 以下、resources/privacy_policy.md の内容がHTMLに変換されて続く（省略） -->
</div>
</div>
</body>
</html>
```

## get /app/rules

Return rules html for app

### request

Content | Parameter | Description
:--|:--|:--
backColor | #FFFFFF | html's background color
textColor | #000000 | html's text color
isPrivacyPolicy | true | if true show PrivacyPolicy else TermsOfUse

```
http://localhost:8000/app/rules?backColor=%23FFFFFF&textColor=%23000000&isPrivacyPolicy=true
```

### response

Content | Parameter | Description
:--|:--|:--
html | `<!DOCTYPE HTML>` | rules

```
<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/4.0.0/github-markdown.min.css" rel="stylesheet" type="text/css" media="all" />
  <style>.small { font-size: 70%% !important;  color: #000000; }</style>
</head>
<body style="background-color: #FFFFFF;">
<div class="container">
  <div class="markdown-body small">
    <h1>【略語Generator】プライバシーポリシー</h1>

<p>当方が提供するアプリケーション「【略語Generator】以下「本アプリ」と言います。」において利用される皆様（以下「ユーザー」と言います。）から取得、提供いただいた個人に関する情報を以下のとおり取り扱います。</p>

<h2>1. 取得する情報と利用目的</h2>

<!-- 以下、resources/privacy_policy.md の内容がHTMLに変換されて続く（省略） -->
  </div>
</div>
</body>
</html>
```
