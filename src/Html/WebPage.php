<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    private string $head = '';
    private string $title = '';
    private string $body = '';

    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    public function getHead(): string
    {
        return $this->head;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    public function appendCss(string $css): void
    {
        $css = <<<HTML
    <style>$css</style>
HTML;
        $this->appendToHead($css);
    }

    public function appendCssUrl(string $url): void
    {
        $cssUrl = <<<HTML
    <link href="$url" rel="stylesheet">
HTML;
        $this->appendToHead($cssUrl);
    }

    public function appendJs(string $js): void
    {
        $js = <<<HTML
    <script>$js</script>
HTML;
        $this->appendToHead($js);
    }

    public function appendJsUrl(string $url): void
    {
        $jsUrl = <<<HTML
    <script src="$url"></script>
HTML;
        $this->appendToHead($jsUrl);
    }

    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    public function toHTML(): string
    {
        $html = <<<HTML
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$this->getTitle()}</title>
    {$this->getHead()}
  </head>
  <body>
  {$this->getBody()}
  </body>
  <p id="modif">{$this->getLastModification()}</p>
</html>
HTML;
        return $html;
    }

    public function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
    }

    public function getLastModification(): string
    {
        return "Dernière modification : " . date("F d Y H:i:s.", getlastmod());
    }
}