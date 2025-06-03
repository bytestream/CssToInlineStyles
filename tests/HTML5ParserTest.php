<?php

namespace TijsVerkoyen\CssToInlineStyles\Tests;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class HTML5ParserTest extends TestCase
{
    protected ?CssToInlineStyles $cssToInlineStyles = null;

    /**
     * @before
     */
    protected function prepare(): void
    {
        $this->cssToInlineStyles = new CssToInlineStyles(true);
    }

    /**
     * @after
     */
    protected function clear(): void
    {
        $this->cssToInlineStyles = null;
    }

    public function testBasicHtml(): void
    {
        if ($this->cssToInlineStyles === null) {
            $this->fail('The cssToInlineStyles has not been initialised.');
        }

        $html = '<!doctype html><html><head><style>body{color:blue}</style></head><body><p>foo</p></body></html>';
        $css = 'p { color: red; }';
        $expected = <<<EOF
<!doctype html>
<html><head><style>body{color:blue}</style></head><body style="color: blue;"><p style="color: red;">foo</p></body></html>
EOF;

        $this->assertEquals($expected, $this->cssToInlineStyles->convert($html, $css));
    }

    public function testHtml4(): void
    {
        if ($this->cssToInlineStyles === null) {
            $this->fail('The cssToInlineStyles has not been initialised.');
        }

        $html = '<html><head><style>body{color:blue}</style></head><body><p>foo</p></body></html>';
        $css = 'p { color: red; }';
        $expected = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head><style>body{color:blue}</style></head>
<body style="color: blue;"><p style="color: red;">foo</p></body>
</html>
EOF;

        $this->assertEquals($expected, $this->cssToInlineStyles->convert($html, $css));
    }

    public function testHtml5(): void
    {
        if ($this->cssToInlineStyles === null) {
            $this->fail('The cssToInlineStyles has not been initialised.');
        }

        $html = '<!doctype html><html><head><style>body{color:blue}</style></head><body><p>foo</p></body></html>';
        $css = 'p { color: red; }';
        $expected = <<<EOF
<!doctype html>
<html><head><style>body{color:blue}</style></head><body style="color: blue;"><p style="color: red;">foo</p></body></html>
EOF;
        $this->assertEquals($expected, $this->cssToInlineStyles->convert($html, $css));
    }
}
