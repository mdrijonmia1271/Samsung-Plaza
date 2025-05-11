<?php

namespace Rdehnhardt\Debug;

use Symfony\Component\VarDumper\Dumper\HtmlDumper as SymfonyHtmlDumper;

class HtmlDumper extends SymfonyHtmlDumper
{
    /**
     * Colour definitions for output.
     *
     * @var array
     */

    
    protected $styles = [
        'default' => 'background-color:#18171B; color:#FF8400; line-height:1.2em; font:12px Menlo, Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:99999; word-break: break-all',
        'num' => 'font-weight:bold; color:#1299DA',
        'const' => 'font-weight:bold',
        'str' => 'font-weight:bold; color:#56DB3A',
        'note' => 'color:#1299DA',
        'ref' => 'color:#A0A0A0',
        'public' => 'color:#FFFFFF',
        'protected' => 'color:#FFFFFF',
        'private' => 'color:#FFFFFF',
        'meta' => 'color:#B729D9',
        'key' => 'color:#56DB3A',
        'index' => 'color:#1299DA',
        'ellipsis' => 'color:#FF8400',
    ];

    /*protected $styles = [
        'default' => 'background-color:#000; border-radius: 2px; border: 1px solid #000; color:#FF8400; line-height:1.2em; font-weight:normal; font:14px Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:100000',
        'num'       => 'color:#a71d5d',
        'const'     => 'color:#ff8400',
        'str'       => 'color:#56db3a',
        'cchr'      => 'color:#222',
        'note'      => 'color:#1299da',
        'ref'       => 'color:#a0a0a0',
        'public'    => 'color:#fff',
        'protected' => 'color:#ff8400',
        'private'   => 'color:#ff8400',
        'meta'      => 'color:#b729d9',
        'key'       => 'color:#56db3a',
        'index'     => 'color:#56db3a',
    ];*/
}
