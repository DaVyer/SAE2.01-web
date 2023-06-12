<?php

namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title = '')
    {
        WebPage::__construct($title);
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
    <div class="header">
        <h1>{$this->getTitle()}</h1>
    </div>
  
    <div class="content">
        {$this->getBody()}
    </div>
  
    <div class="footer">
        <div class="modif">{$this->getLastModification()}</div>
    </div>
  </body>
    
</html>
HTML;
        return $html;
    }
}